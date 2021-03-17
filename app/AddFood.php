<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddFood extends Model
{
    protected $fillable = [
        'total','pickA','pickB'
    ];
}
