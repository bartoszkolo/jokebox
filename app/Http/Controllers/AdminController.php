<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Joke;
use App\Models\Category;
use App\Models\Vote;

class AdminController extends Controller
{
    public function index() {
        $jokes = Joke::with('category', 'user')->paginate(10);
        return view('admin.index', compact('jokes'));
    }

    public function edit(Joke $joke) {
        $categories = Category::all();
        return view('admin.edit', compact('joke', 'categories'));
    }

    public function update(Request $request, Joke $joke) {
        // Validation and update logic
        // Ensure to validate the request data and update the joke
        $validatedData = $request->validate([
            'text' => 'required', // Add other validation rules as needed
            'category_id' => 'required|exists:categories,id'
        ]);

        $joke->update($validatedData);

        return redirect()->route('admin.index')->with('success', 'Joke updated successfully');
    }

    public function destroy(Joke $joke) {
        $joke->delete();
        return redirect()->route('admin.index')->with('success', 'Joke deleted successfully');
    }

    public function create() {
        $categories = Category::all(); // Assuming you need categories to select from
        return view('admin.create', compact('categories'));
    }
    
    public function store(Request $request) {
        // Validation and logic to store a new joke
        $validatedData = $request->validate([
            'text' => 'required', // Add other validation rules as needed
            'category_id' => 'required|exists:categories,id',
            // other fields
        ]);
    
        Joke::create($validatedData);
    
        return redirect()->route('admin.index')->with('success', 'Joke created successfully');
    }
}
