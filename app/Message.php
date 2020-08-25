<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id', 'receiver_id','sender_delete','receiver_delete'
    ];
    public function use(){
        return $this->belongsTo(User::class,'sender_id');
    }
    public function chat(){
        return $this->belongsTo(Chat::class,'owner_id');
    }

}
