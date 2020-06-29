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

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like()
    {
        $this->likes()->firstOrCreate([
            'user_id'=> auth()->id()
        ]);
    }

    public function unlike()
    {
        $this->likes()->where([
            'user_id'=> auth()->id()
        ])->delete();
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id',auth()->id())->exists();
    }

    public function likesCount()
    {
        return $this->likes()->count();
    }
}
