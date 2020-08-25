<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mockery\Test\Generator\StringManipulation\Pass\MagicReturnDummy;

class CrushieChat extends Model
{
    protected $fillable = [
        'owner_id', 'participant_id','created_at'
    ];

    public function receiver(){
        $p= $this->hasOne(CrushieMessage::class,'chat_id')->orderBy('created_at','desc');
        return $p;
    }
}
