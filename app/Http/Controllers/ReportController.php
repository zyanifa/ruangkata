<?php

namespace App\Http\Controllers;

use App\Enums\ReportReason;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function showForm($type, $id)
    {
        // Validate the reportable type and get the model
        $model = $this->getReportableModel($type, $id);
        
        if (!$model) {
            return redirect()->back()->with('error', 'Item tidak ditemukan.');
        }
        
        return view('reports.form', [
            'model' => $model,
            'type' => $type,
            'reasons' => ReportReason::getReasons(),
        ]);
    }
    
    public function store(Request $request, $type, $id)
    {
        $model = $this->getReportableModel($type, $id);
        
        if (!$model) {
            return redirect()->back()->with('error', 'Item tidak ditemukan.');
        }
        
        $validated = $request->validate([
            'reason' => 'required|string',
            'details' => 'nullable|string|max:500',
        ]);
        
        try {
            // Check if the user has already reported this item
            $existingReport = $model->reports()
                ->where('user_id', Auth::id())
                ->first();
                
            if ($existingReport) {
                return redirect()->back()->with('error', 'Anda sudah melaporkan item ini sebelumnya.');
            }
            
            // Create a new report
            $model->reports()->create([
                'user_id' => Auth::id(),
                'reason' => $validated['reason'],
                'details' => $validated['details'],
            ]);
            
            // Redirect to the original post
            if ($type === 'post') {
                return redirect()->route('post.show', [
                    'username' => $model->user->username,
                    'post' => $model->slug
                ])->with('success', 'Laporan telah berhasil dikirim.');
            } elseif ($type === 'comment') {
                return redirect()->route('post.show', [
                    'username' => $model->post->user->username,
                    'post' => $model->post->slug
                ])->with('success', 'Laporan telah berhasil dikirim.');
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim laporan. Silakan coba lagi.');
        }
    }
    
    private function getReportableModel($type, $id)
    {
        switch ($type) {
            case 'post':
                return Post::find($id);
            case 'comment':
                return Comment::find($id);
            default:
                return null;
        }
    }
}