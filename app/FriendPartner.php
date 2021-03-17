<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendPartner extends Model
{
    public function self(){
        return $this->belongsTo(Partner::class,'self_id');
    }
    public function category(){
        return $this->belongsTo(AddPartner::class,'category_id');
    }
}
