<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id','status_id','body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
