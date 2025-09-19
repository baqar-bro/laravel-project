<?php

namespace App\Http\Controllers;

use App\Events\LiveNotification;
use App\Events\LiveNotificationEvent;
use App\Models\likes;
use App\Models\Posts;
use App\Models\UserAccount;
use App\Notifications\LikeNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function Illuminate\Log\log;

class LikesController extends Controller
{
    //
    public function likeinteractivity(Request $request)
    {
        try {
            $acc = UserAccount::where('user_id', session('user_id'))->first();
            $acc_id = $acc->id;

            if ($request->likePost) {
                $post = $request->likePost;
                $like = new likes();
                $like->account_id = $acc_id;
                $like->post_id = $post;
                $like->save();
                $findPost = Posts::find($post);
                $postOwner = UserAccount::find($findPost->account_id);
                if ($postOwner && $postOwner->id !== $acc_id) {
                    $postOwner->notify(new LikeNotification($acc, $findPost));
                    event(new LiveNotificationEvent($postOwner,'real time commiunatication runing sucessfully',));
                }

                return response()->json([
                    'like' => true
                ]);
            } else if ($request->unlikePost) {
                $unlikePost = likes::where('account_id', $acc_id)->where('post_id', $request->unlikePost)->first();
                if ($unlikePost !== null) {
                    $unlikePost->delete();
                    return response()->json([
                        'unlike' => false
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'err' => $e->getMessage()
            ]);
        }
    }

    public function checkLike($id)
    {
        $acc = UserAccount::where('user_id', session('user_id'))->first();
        if ($acc !== null) {
            $acc_id = $acc->id;
            $hasLike = likes::where('account_id', $acc_id)->where('post_id', $id)->exists();
            $countLikes = likes::where('post_id', $id)->count();
            return response()->json([
                'check' => $hasLike ? true : false,
                'total_likes' => $countLikes
            ]);
        } else {
            $countLikes = likes::where('post_id', $id)->count();
            return response()->json([
                'check' => false,
                'total_likes' => $countLikes
            ]);
        }
    }
}
