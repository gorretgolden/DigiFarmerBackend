<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatParticipant extends Model
{
    use HasFactory;
    protected $table = 'chat_participants';
    protected $guarded = ['id'];



     //belongs to a user
     public function user()
     {
     return $this->belongsTo(\App\Models\User::class, 'user_id');
     }


     //belongs to a chat
     public function chat()
     {
     return $this->belongsTo(\App\Models\Chat::class, 'created_by');
     }
}
