<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Famous extends Model
{
    protected $fillable = [
        'femaleMusic','maleMusic','femaleActor','maleActor','president','football','business','basketball','models','carlogos'
    ];
}
