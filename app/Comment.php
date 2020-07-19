<?php

namespace App;

use App\Traits\HasLikes;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasLikes;

    protected $fillable = ['user_id','status_id','body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function path()
    {
        // TODO
    }

}
