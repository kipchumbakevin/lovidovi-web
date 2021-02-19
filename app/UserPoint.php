<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{


    protected $fillable = [
        'points','actor','billion','convict','virgin','student','car','medicine','plastic','african','jobless','pet','pass'
    ];
}
