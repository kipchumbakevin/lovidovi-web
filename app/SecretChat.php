<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecretChat extends Model
{
    protected $fillable = [
        'owner_id', 'participant_id','created_at'
    ];
    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }
    public function message(){
        return $this->hasMany(SecretMessage::class,'sender_id');
    }
    public function receiver(){
        $p= $this->hasOne(SecretMessage::class)->orderBy('created_at','desc');
        return $p;
    }
    public function participant(){
        return $this->belongsTo(User::class,'participant_id');
    }
}
