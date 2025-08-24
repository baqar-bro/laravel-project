<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Posts;
use App\Models\AccountInteractivity;
use Illuminate\Notifications\Notifiable;

class UserAccount extends Model
{
    //
    use HasFactory;
    use Notifiable;

    public function user(){
       return $this->belongsTo(User::class , 'user_id');
    }

    public function followers(){
        return $this->hasMany(AccountInteractivity::class , 'followings');
    }

    public function followings(){
        return $this->hasMany(AccountInteractivity::class , 'followers');
    }

    public function followingAccounts(){
        return $this->belongsToMany(UserAccount::class , 'account_interactivities' , 'followers' , 'followings');
    }

    public function followerAccounts(){
        return $this->belongsToMany(UserAccount::class , 'account_interactivities' , 'followings' , 'followers');
    }

    public function posts(){
        return $this->hasMany(Posts::class , 'account_id');
    }

    public function LikePosts(){
        return $this->hasMany(likes::class , 'account_id');
    }

    public function BookmarkPosts(){
        return $this->hasMany(Bookmark::class , 'account_id');
    }
    
}
