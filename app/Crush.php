<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crush extends Model
{
    protected $fillable = [
        'notification', 'status','sender_phone', 'receiver_phone'
    ];
}
