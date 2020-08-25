<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NCrush extends Model
{
    protected $fillable = [
        'notification', 'status','sender_phone', 'receiver_phone'
    ];
}
