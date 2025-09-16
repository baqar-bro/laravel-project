<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\UserAccount;
use App\Models\notifications;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class NotifyController extends Controller
{
    //
    public function notifications(Request $request)
    {
        try {
            $acc = UserAccount::where('user_id', session('user_id'))->first();
            $notifications = $acc->notifications()->latest()->get();
            $result = $notifications->map(function ($notification) {
                $post = Posts::find($notification->data['post_id'] ?? null);
                $user_who_like = UserAccount::find($notification->data['id'] ?? null);
                return [
                    'post' => $post,
                    'user' => $user_who_like,
                    'message' => $notification->data['message'],
                    'timestamp' => $notification->created_at
                ];
            });
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json([
                'err' => 'something went wrong'
            ]);
        }
    }
}
