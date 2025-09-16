<?php

namespace App\Models;
use App\Models\UserAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    //
    use HasFactory;
    public function useracc (){
        return $this->belongsTo(UserAccount::class , 'account_id');
    }
}
