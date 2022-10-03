<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
    
    protected function latestMessage(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Message::where('convo',$this->id)->orderBy('created_at','DESC')->first(),
        );
    }
    protected function latestMessageDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Message::where('convo',$this->id)->orderBy('created_at','DESC')->first()->created_at ?? null,
        );
    }
}
