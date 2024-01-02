<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Joke;
use App\Models\Category;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;


class JokeController extends Controller
{
   
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'newest');
        $categories = Category::withCount('jokes')->get();
    
        $query = Joke::with('category');
    
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'highest_rating':
                $query->orderBy('upvotes', 'desc');
                break;
            case 'lowest_rating':
                $query->orderBy('upvotes', 'asc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
    
    
        $jokes = $query->paginate(15)->appends($request->except('page'));

        $favoriteJokeIds = auth()->check() ? auth()->user()->favoriteJokes()->pluck('joke_id') : collect();
    
        return view('welcome', compact('jokes', 'categories', 'favoriteJokeIds'));
    }
    
    

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'required|max:1024',
            'category_id' => 'required|exists:categories,id',
            // other validation rules as needed
        ]);
    
        $joke = new Joke();
        $joke->text = $validatedData['text'];
        $joke->category_id = $validatedData['category_id'];
        $joke->user_id = auth()->id();
        $joke->save();
    
        return redirect()->route('jokes.index')->with('success', 'Joke added successfully!');
    }
    
    
    

    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('jokes.create', compact('categories'));
    }
    // Implement other methods similarly

    public function show(Joke $joke)
    {
        // Assuming 'comments' and 'category' are the correct relationship methods in your Joke model.
        // If you have a rating system, ensure that the joke model has the necessary relationship or attribute for it.
        return view('jokes.show', [
            'joke' => $joke->load('comments.user', 'category')
        ]);
    }
    

    public function upvote(Request $request, $jokeId)
    {
        $user = Auth::user();
        $joke = Joke::find($jokeId);
    
        if (!$joke) {
            return response()->json(['error' => 'Joke not found'], 404);
        }
    
        $existingVote = $user->votes()->where('joke_id', $jokeId)->first();
    
        if (!$existingVote) {
            $user->votes()->create([
                'joke_id' => $jokeId,
                'vote' => 1
            ]);
            $joke->increment('upvotes');
        } elseif ($existingVote->vote == -1) {
            $existingVote->update(['vote' => 1]);
            $joke->increment('upvotes', 1); // Increment by 2 if changing from downvote to upvote
        }
    
        $joke = $joke->fresh(); // Refresh the joke instance
        return response()->json([
            'newVotesCount' => $joke->upvotes
        ]);
    }
    
    
    public function downvote(Request $request, $jokeId)
{
    $user = Auth::user();
    $joke = Joke::find($jokeId);

    if (!$joke) {
        return response()->json(['error' => 'Joke not found'], 404);
    }

    $existingVote = $user->votes()->where('joke_id', $jokeId)->first();

    if (!$existingVote) {
        $user->votes()->create([
            'joke_id' => $jokeId,
            'vote' => -1
        ]);
        $joke->decrement('upvotes');
    } elseif ($existingVote->vote == 1) {
        $existingVote->update(['vote' => -1]);
        $joke->decrement('upvotes', 1); // Decrement by 2 if changing from upvote to downvote
    }

    $joke = $joke->fresh(); // Refresh the joke instance
    return response()->json([
        'newVotesCount' => $joke->upvotes
    ]);
}

    public function favorite(Request $request, Joke $joke)
    {
        $user = auth()->user();
        
        // Toggle the favorite status
        $user->favoriteJokes()->toggle($joke->id);
        
        $isFavorited = $user->favoriteJokes()->where('joke_id', $joke->id)->exists();
    
        return response()->json(['isFavorited' => $isFavorited]);
    }
    

    public function favorites()
    {
        $user = auth()->user();
    
        // Assuming you have set up the favoriteJokes relationship in the User model
        $favoriteJokes = $user->favoriteJokes()->with('category')->paginate(10);
    
        return view('jokes.favorites', compact('favoriteJokes'));
    }
    
    

public function random()
{
    // Retrieve a random joke from the database
    $joke = Joke::with('category')->inRandomOrder()->first();

    // Return the 'jokes.random' view with the random joke
    return view('jokes.random', compact('joke'));
}

public function toggleFavorite(Request $request)
{
    $jokeId = $request->input('joke_id');
    $joke = Joke::findOrFail($jokeId);
    $user = auth()->user();
    $user->favoriteJokes()->toggle($joke->id);

    return response()->json(['favorited' => $user->favoriteJokes()->where('joke_id', $joke->id)->exists()]);
}

public function search(Request $request)
{
    $searchTerm = $request->input('search');
    $jokes = Joke::where('text', 'like', '%' . $searchTerm . '%')->paginate(10);

    // Fetch the IDs of the jokes that the authenticated user has favorited
    $userFavorites = auth()->check() ? auth()->user()->favoriteJokes()->pluck('joke_id') : collect();

    return view('jokes.search_results', compact('jokes', 'userFavorites'));
}


public function categoryJokes($slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();
    $jokes = Joke::where('category_id', $category->id)->paginate(10);

    return view('jokes.category', [
        'jokes' => $jokes,
        'categoryName' => $category->name // passing the category name to the view
    ]);
}


}
