<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fundraiser extends Model
{
    public function contribution(){
        $p= $this->
        hasOne(Contribution::class,'fund_id')->orderBy('created_at','desc');
        return $p;
    }
    public function owner(){
        return $this->belongsTo(Register::class,'user_id');
    }
    public function payments(){
        return $this->hasOne(Payment::class,'fund_id');
    }
}
