<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendLifestyle extends Model
{
    public function self(){
        return $this->belongsTo(Lifestyle::class,'self_id');
    }
    public function category(){
        return $this->belongsTo(AddLifestyle::class,'category_id');
    }
}
