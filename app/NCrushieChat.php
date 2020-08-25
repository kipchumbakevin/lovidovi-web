<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NCrushieChat extends Model
{
    protected $fillable = [
        'owner_id', 'participant_id','created_at'
    ];

    public function receiver(){
        $p= $this->hasOne(NCrushieMessage::class,'chat_id')->orderBy('created_at','desc');
        return $p;
    }
}
