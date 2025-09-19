<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\UserAccount;
use App\Models\notifications;
use Carbon\Carbon;
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
                    'timestamp' => $notification->created_at,
                    'read_at' => $notification->read_at
                ];
            });
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json([
                'err' => 'something went wrong'
            ]);
        }
    }

    public function readAllNotification (Request $request){
        $acc = UserAccount::where('user_id', session('user_id'))->first();
        if($request->boolean('mark')){
            $acc->unreadNotifications()->update(['read_at' => Carbon::now()]);
        }
    }
} 


