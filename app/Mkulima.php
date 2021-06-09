<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mkulima extends Model
{
    protected $fillable = [
       'paid','pin','phone','inviteCode','videos','referrals','total'
    ];

}
