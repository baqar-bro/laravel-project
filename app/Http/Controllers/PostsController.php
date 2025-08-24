<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\UserAccount;
use Exception;
use Illuminate\Http\Request;

use function Pest\Laravel\post;

class PostsController extends Controller
{
    //
    public function insertpostdata(Request $request)
    {
        try {
            $user_id = session('user_id');
            if ($user_id) {
                $account_id = UserAccount::where('user_id', $user_id)->first();
                $post = new Posts();
                $post->text = $request->input('post_text');
                if ($request->hasFile('post_image')) {
                    $imagePath = $request->file('post_image')->store('posts', 'public');
                    $imageUrl = asset('storage/' . $imagePath);
                    $post->image = $imageUrl;
                } else {
                    $post->image = null;
                }
                $post->account_id = $account_id->id;
                $post->save();
                return response()->json([
                    'posting' => 'success'
                ]);
            } else {
                throw new Exception('session expired');
            }
        } catch (Exception $e) {
            return response()->json([
                'err' => $e->getMessage()
            ]);
        };
    }

    public function loadposts($pageNum)
    {
        try {
            $page = $pageNum;
            $limit = 7;
            $user = UserAccount::where('user_id', session('user_id'))->first();
            $posts = Posts::with('useracc')->latest()->skip(($page - 1) * $limit)->take($limit)->get() ?? null;
            if ($posts->isNotEmpty()) {
                return response()->json([
                    'posts' => $posts,
                    'authuser' => $user
                ]);
            } else {
                return response()->json([
                    'posts' => []
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'err' => $e->getMessage()
            ]);
        }
    }
}
