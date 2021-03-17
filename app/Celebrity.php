<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Celebrity extends Model
{

    protected $fillable = [
        'total','pickA','pickB'
    ];
    public function image(){
        $p= $this->hasOne(CelebImage::class,'celeb_id');
        return $p;
    }
}
