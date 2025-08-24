<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\UserAccount;
use Exception;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    //
    public function notifications(Request $request)
    {
        try {
            $acc = UserAccount::where('user_id', session('user_id'))->first();
            $notification = $acc->notifications()->latest()->first();
            $post = Posts::find($notification->data['post_id']);
            $user_who_like = UserAccount::find($notification->data['id']);
            return response()->json([
                'post' => $post,
                'user' => $user_who_like,
                'message' => $notification->data['message']
            ]);
        } catch (Exception $e) {
            return response()->json([
                'err' => 'something went wrong'
            ]);
        }
    }
}
