<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrushieMessage extends Model
{
    protected $fillable = [
        'sender_id', 'receiver_id','receiver_read'
    ];

    public function chat(){
        return $this->belongsTo(CrushieChat::class,'chat_id');
    }
}
