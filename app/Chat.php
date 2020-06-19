<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    protected $fillable = [
        'owner_id', 'participant_id','created_at'
    ];
    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }
    public function sender(){
        return $this->hasMany(Message::class,'sender_id');
    }
    public function receiver(){
        $p= $this->hasOne(Message::class)->orderBy('created_at','desc');
        return $p;
    }
    public function participant(){
        return $this->belongsTo(User::class,'participant_id');
    }

}
