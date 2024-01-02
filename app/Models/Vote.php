<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['joke_id', 'user_id', 'vote'];

    public function joke()
    {
        return $this->belongsTo(Joke::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
