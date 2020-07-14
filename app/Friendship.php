<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $fillable = ['sender_id', 'recipient_id','status'];

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function recipient()
    {
        return $this->belongsTo(User::class);
    }
}
