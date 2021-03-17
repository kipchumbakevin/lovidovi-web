<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendFood extends Model
{
    public function self(){
        return $this->belongsTo(Food::class,'self_id');
    }
    public function category(){
        return $this->belongsTo(AddFood::class,'category_id');
    }
}
