<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class STKModel extends Model
{
    protected $fillable = [
        'mpesa_code','phone','status','merchant_request_id'
        ];

}
