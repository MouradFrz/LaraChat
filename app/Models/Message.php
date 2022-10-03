<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['senderID','message','convo'];
    public function user(){
        return $this->belongsTo(User::class,'senderID','id');
    }
    public function conversation(){
        return $this->belongsTo(Conversation::class,'convo','id');
    }
}
