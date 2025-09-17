<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Posts;
use App\Models\UserAccount;
use App\Notifications\CommentsNotification;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class CommentsController extends Controller
{
    //
    public function getComments($id, $page)
    {
        try {
            $limit = 20;
            $page_num = $page;
            $post_id = $id;
            $comments = Comments::with('useracc')->where('post_id', $post_id)
                ->skip(($page_num - 1) * $limit)->take($limit)->get();
            $Auth_user_account = UserAccount::where('user_id', session('user_id'))->first();
            if ($comments) {
                return response()->json([
                    'comments' => $comments,
                    'auth_acc' => $Auth_user_account
                ]);
            } else {
                return response()->json([
                    'comments' => 0
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'err' => $e->getMessage()
            ]);
        }
    }

    public function postComment(Request $request)
    {
        try {
            $user_id = session('user_id');
            $auth_acc = UserAccount::where('user_id', $user_id)->first();
            if ($auth_acc) {
                $auth_acc_id = $auth_acc->id;
                $newComment = new Comments();
                $newComment->post_id = $request->post_id;
                $newComment->comments = $request->comment;
                $newComment->account_id = $auth_acc_id;
                $newComment->save();
                $findPost = Posts::find($request->post_id);
                $postOwner = UserAccount::find($findPost->account_id);
                if ($postOwner && $postOwner->id !== $auth_acc) {
                    $postOwner->notify(new CommentsNotification($auth_acc, $findPost , $request->comment));
                }
                return response()->json([
                    'auth_acc' => $auth_acc
                ]);
            } else {
                throw new Exception('create acc first or log in first');
            }
        } catch (Exception $e) {
            return response()->json([
                'err' => $e->getMessage()
            ]);
        }
    }
}
