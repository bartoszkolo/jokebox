<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Joke;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $jokeId)
    {
        $validatedData = $request->validate([
            'text' => 'required|string|max:1000',
        ]);
    
        $comment = new Comment();
        $comment->joke_id = $jokeId;
        $comment->user_id = auth()->id();
        $comment->text = $validatedData['text'];
        $comment->save();
    
        return redirect()->route('jokes.show', ['joke' => $jokeId])
                         ->with('success', 'Comment added successfully!');
    }
}
