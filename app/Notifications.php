<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $fillable = [
        'notification', 'status','sender_phone', 'receiver_phone'
    ];
    public function getNotificationsAttribute()
    {
        $nt = Notifications::where('receiver_id',$this->id)->get();
        return $nt;
    }
}
