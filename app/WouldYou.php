<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WouldYou extends Model
{
    protected $fillable = [
        'optionA','optionB','total','pickA','pickB'
    ];
}
