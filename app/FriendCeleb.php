<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendCeleb extends Model
{
    public function self(){
        return $this->belongsTo(SelfCelebrity::class,'self_id');
    }
    public function category(){
        return $this->belongsTo(Celebrity::class,'category_id');
    }
}
