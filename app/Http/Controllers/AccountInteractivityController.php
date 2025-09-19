<?php

namespace App\Http\Controllers;

use App\Models\AccountInteractivity;
use App\Models\UserAccount;
use App\Notifications\FollowNotification;
use Exception;
use Illuminate\Http\Request;

class AccountInteractivityController extends Controller
{
    //

    public function accountinteractivity(Request $request)
    {
        try {

            $activity = new AccountInteractivity;
            $user_id = session('user_id');
            $user_acc = UserAccount::where('user_id', $user_id)->first();
            if ($user_acc) {

                $activity->followers = $user_acc->id;
                $activity->followings = $request->id;
                $activity->save();
                $following_user = UserAccount::find($request->id);
                $following_user->notify(new FollowNotification($user_acc));

                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['error' => 'create your account first']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function unfollow(Request $request)
    {
        try {
            $user_id = session('user_id');
            $user_acc = UserAccount::where('user_id', $user_id)->first();
            if ($user_acc) {
               $acc_id = $request->id;
               $check_interacitvity = AccountInteractivity::where('followers' , $user_acc->id)
               ->where('followings' , $acc_id)->first();
               $check_interacitvity->delete();
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['error' => 'create your account first']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function checkfollowing(Request $request)
    {
        try {

            $user_acc = UserAccount::where('user_id', session('user_id'))->first();
            $check_user_follow = AccountInteractivity::where('followers', $user_acc->id)
                ->where('followings', $request->id)->exists();
            if ($check_user_follow) {
                return response()->json([
                    'message' => 'sucess'
                ]);
            } else {
                return response()->json([
                    'message' => 'unsucess'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
