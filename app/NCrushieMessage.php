<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NCrushieMessage extends Model
{
    protected $fillable = [
        'sender_id', 'receiver_id','receiver_read'
    ];

    public function chat(){
        return $this->belongsTo(NCrushieChat::class,'chat_id');
    }
}
