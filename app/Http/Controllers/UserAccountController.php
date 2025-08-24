<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountValidation;
use App\Models\AccountInteractivity;
use App\Models\Bookmark;
use App\Models\likes;
use App\Models\Posts;
use App\Models\UserAccount;
use Exception;
use Illuminate\Http\Request;

use function Pest\Laravel\json;
use function PHPUnit\Framework\throwException;

class UserAccountController extends Controller
{
    //
    public function createAccount(AccountValidation $request)
    {

        $user = session('user_id');
        $profileUrl = null;
        if ($request->hasFile('image')) {
            $profilePhoto = $request->file('image')->store('photos', 'public');
            $profileUrl = asset('storage/' . $profilePhoto);
        }

        $profile = new UserAccount;
        $profile->image = $profileUrl;
        $profile->name = $request->name;
        $profile->about = $request->about;
        $profile->user_id = $user;
        $profile->save();

        return redirect()->route('show.user.account');
    }

    public function accountinfo()
    {

        try {

            $userId = session('user_id');
            $account = UserAccount::with('user', 'followingAccounts', 'followerAccounts', 'posts' , 'LikePosts' , 'BookmarkPosts')->withCount(['followers', 'followings', 'posts'])
                ->where('user_id', $userId)->first();
            $Likes = Posts::with('useracc')->find($account->LikePosts);
            $bookmark = Posts::with('useracc')->find($account->BookmarkPosts);    

            if (!$account) {
                return response()->json(['error' => 'account not found']);
            }

            return response()->json([
                'account' => $account,
                'image_url' => asset('storage/' . $account->image),
                'posts_count' => $account->posts_count,
                'posts' => $account->posts,
                'like_posts' => $Likes,
                'bookmark_posts' => $bookmark,
                'followers' => $account->followers_count,
                'followings' => $account->followings_count,
                'follower_accounts' => $account->followerAccounts,
                'following_accounts' => $account->followingAccounts,
            ]);
        } catch (\Exception $e) {

            return response()->json(['error' => 'something went wrong']);
        }
    }

    public function getallaccounts()
    {
        try {
            $accounts = UserAccount::all();
            $Auth_user_account = UserAccount::where('user_id', session('user_id'))->first();
            if ($accounts->isEmpty()) {
                throw new Exception('no any account found');
            }
            return response()->json([
                'accounts' => $accounts,
                'auth_acc' => $Auth_user_account ?? null
            ]);
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getsearchaccount($user_name)
    {
        $account = UserAccount::with('user', 'followingAccounts', 'followerAccounts', 'posts')
            ->withCount(['followers', 'followings', 'posts'])->where('name', $user_name)->first();
        return view('user_account.searched_acc', compact('account'));
    }

    public function accountfilter($user_name)
    {
        try {
            $users = UserAccount::when($user_name, function ($query) use ($user_name) {
                return $query->where('name', 'LIKE', '%' . $user_name . '%');
            })->limit(7)->get();
            $Auth_user_account = UserAccount::where('user_id', session('user_id'))->first();
            if ($users) {
                return response()->json([
                    'accounts' => $users,
                    'auth_acc' => $Auth_user_account ?? null
                ]);
            } else {
                throw new exception('account not found');
            }
        } catch (Exception $e) {
            return response()->json([
                'not found' => $e->getMessage()
            ]);
        }
    }
}
