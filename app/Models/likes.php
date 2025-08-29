<?php

namespace App\Models;
use App\Models\UserAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likes extends Model
{
    use HasFactory;
    //
    public function user_acc(){
        return $this->belongsTo(UserAccount::class , 'account_id');
    }
}
