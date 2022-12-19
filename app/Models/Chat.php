<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';
    protected $guarded = ['id'];

    //has many participants
    public function participants()
    {
    return $this->hasMany(\App\Models\ChatParticipant::class, 'created_by');
    }

    //belongs to a user
    public function user()
    {
    return $this->belongsTo(\App\Models\User::class, 'created_by');
    }


    //has many messages
    public function chats()
    {
    return $this->hasMany(\App\Models\Message::class, 'chat_id');
    }

   //has one last message
   public function lastMessage()
   {
   return $this->hasOne(\App\Models\ChatMessage::class, 'chat_id')->latest('updated_at');
   }


   ///check if chat has a particiant

   public function scopeHasParticipant($query,$userId){
      return $query->whereHas('participants',function($q) use($userId){
        $q->where('user_id',$userId);

      });

   }

}
