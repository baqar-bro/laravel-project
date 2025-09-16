<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class notifications extends Model
{
    use HasFactory;
    //
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime'
    ];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'notifiable_id',
        'notifiable_type',
        'type',
        'data',
        'read_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function notifiable()
    {
        return $this->morphTo();
    }
}
