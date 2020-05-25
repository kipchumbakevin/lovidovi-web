<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{

    public function getNotificationsAttribute()
    {
        $nt = Notifications::where('receiver_id',$this->id)->get();
        return $nt;
    }
}
