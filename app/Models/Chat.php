<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $_fillable = [
     
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
   
   
}
