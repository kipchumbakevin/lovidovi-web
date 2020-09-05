<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class USSDModel extends Model
{
    protected $fillable = [
        'number','session','text'
    ];
}
