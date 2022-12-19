<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_message';
    protected $guarded = ['id'];
    protected $touches = ['chat'];

    //belongs to a user
    public function user()
    {
    return $this->belongsTo(\App\Models\User::class, 'user_id');
    }


    //belongs to a chat
    public function chat()
    {
    return $this->belongsTo(\App\Models\Chat::class, 'chat_id');
    }
}
