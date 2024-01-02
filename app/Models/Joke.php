<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joke extends Model
{
    use HasFactory;
    protected $fillable = ['text', 'category_id', 'user_id', 'upvotes'];
    // Assuming you have a 'user_id' column in your jokes table for the user who posted the joke
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Assuming you have a 'category_id' column in your jokes table
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // One joke can have many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_jokes');
    }
    

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

// Joke model

    // Accessor for the net vote count
    public function getVotesCountAttribute()
    {
        // Subtract the count of downvotes from upvotes to get the rating
        $upvotes = $this->votes()->where('vote', 1)->count();
        $downvotes = $this->votes()->where('vote', -1)->count();
        
        return $upvotes - $downvotes;
    }


}
