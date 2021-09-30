<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable=[

        'message',
        'user_id',
        'chat_id'
    ];
    use HasFactory;
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
