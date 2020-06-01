<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecretChat extends Model
{
    protected $fillable = [
        'owner_id', 'participant_id','created_at'
    ];
    public function user(){
        return $this->belongsTo(User::class,'owner_id');
    }
    public function message(){
        return $this->hasMany(Message::class,'sender_id');
    }
    public function participant(){
        return $this->belongsTo(User::class,'participant_id');
    }
}
