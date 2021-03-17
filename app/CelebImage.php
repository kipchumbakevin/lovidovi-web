<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CelebImage extends Model
{


    public function celeb(){
        return $this->belongsTo(Celebrity::class,'celeb_id');
    }
}
