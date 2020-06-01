<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecretMessage extends Model
{
    protected $fillable = [
        'sender_id', 'receiver_id'
    ];
    public function use(){
        return $this->belongsTo(User::class,'sender_id');
    }
    public function chat(){
        return $this->belongsTo(SecretChat::class,'owner_id');
    }
}
