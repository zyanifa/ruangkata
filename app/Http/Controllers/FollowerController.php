<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function followUnfollow(User $user)
    {
        $wasFollowing = auth()->user()->following()->where('user_id', $user->id)->exists();
        
        $user->followers()->toggle(auth()->user());

        $message = $wasFollowing ? 'Berhasil unfollow!' : 'Berhasil follow!';
        
        return response()->json([
            'followersCount' => $user->followers()->count(),
            'message' => $message
        ]);
    }
}