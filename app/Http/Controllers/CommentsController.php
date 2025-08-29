<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\UserAccount;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class CommentsController extends Controller
{
    //
    public function getComments($id , $page)
    {
        try {
            $limit = 20;
            $page_num = $page;
            $post_id = $id;
            $comments = Comments::with('useracc')->where('post_id' , $post_id)
            ->skip(($page_num - 1) * $limit)->take($limit)->get();
            $Auth_user_account = UserAccount::where('user_id', session('user_id'))->first();
            if($comments){
                return response()->json([
                    'comments' => $comments ,
                    'auth_acc' => $Auth_user_account
                ]);
            }else{
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
}
