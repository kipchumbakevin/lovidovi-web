<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class B2CModel extends Model
{
    protected $fillable = [
        'mpesa_code','phone','status','orinator_id','name'
    ];
}
