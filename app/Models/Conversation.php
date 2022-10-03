<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    public function messages(){
        return $this->hasMany(Message::class,'convo','id');
    }

    public function participantOne(){
        return $this->belongsTo(User::class,'participant_one','id');
    }
    public function participantTwo(){
        return $this->belongsTo(User::class,'participant_two','id');
    }
}
