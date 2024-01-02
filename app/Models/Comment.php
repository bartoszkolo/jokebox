<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['joke_id', 'user_id', 'text'];   
    public function user()
{
    return $this->belongsTo(User::class);
}

public function joke()
{
    return $this->belongsTo(Joke::class);
}

}
