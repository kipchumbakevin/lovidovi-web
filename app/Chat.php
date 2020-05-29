<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'owner_id');
    }
    public function message(){
        return $this->hasMany(Message::class,'sender_id');
    }
    public function participant(){
        return $this->hasOne(User::class,'id');
    }
}
