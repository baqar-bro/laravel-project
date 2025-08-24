<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\UserAccount;
use Exception;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    //
    public function postbookmark(Request $request)
    {
        try {
            $acc = UserAccount::where('user_id', session('user_id'))->first();
            $acc_id = $acc->id;

            if ($request->bookmark) {
                $bookmark = new Bookmark();
                $bookmark->account_id = $acc_id;
                $bookmark->post_id = $request->bookmark;
                $bookmark->save();
                return response()->json([
                    'bookmark' => true
                ]);
            } else if ($request->removeMark) {
                $removeMark = Bookmark::where('account_id', $acc_id)->where('post_id', $request->removeMark)->first();
                if ($removeMark !== null) {
                    $removeMark->delete();
                    return response()->json([
                        'removeMark' => false
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'err' => $e->getMessage()
            ]);
        }
    }

    public function checkBookmark($id) {
         $acc = UserAccount::where('user_id', session('user_id'))->first();
        if ($acc !== null) {
            $acc_id = $acc->id;
            $hasBookmark = Bookmark::where('account_id', $acc_id)->where('post_id', $id)->exists();
            return response()->json([
                'check' => $hasBookmark ? true : false,
            ]);
        } else {
            return response()->json([
                'check' => false
            ]);
        }
    }
}
