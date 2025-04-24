<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('upload')) {
            return response()->json([
                'error' => [
                    'message' => 'No image uploaded'
                ]
            ], 400);
        }

        $file = $request->file('upload');
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Store the uploaded file
        $path = $file->storeAs('uploads/content', $fileName, 'public');
        
        return response()->json([
            'url' => Storage::disk('public')->url($path)
        ]);
    }
}