<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class C2BModel extends Model
{
    protected $fillable = [
        'mpesa_code','phone','account_number','name'
    ];
}
