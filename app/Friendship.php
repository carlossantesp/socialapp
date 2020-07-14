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

    public function scopeBetweenUsers($query, $sender, $recipient)
    {
        $query->where([
            ['sender_id',$sender->id],
            ['recipient_id', $recipient->id],
        ])->orWhere([
            ['sender_id', $recipient->id],
            ['recipient_id', $sender->id],
        ]);
    }
}
