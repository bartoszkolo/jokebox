{{-- resources/views/admin/create.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold">Create New Joke</h1>
    
    <form action="{{ route('admin.jokes.store') }}" method="POST">
        @csrf
        <div class="mt-4">
            <label for="text" class="block">Joke Text</label>
            <textarea name="text" id="text" class="form-control w-full" required></textarea>
        </div>
        <div class="mt-4">
            <label for="category_id" class="block">Category</label>
            <select name="category_id" id="category_id" class="form-control w-full" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Joke</button>
        </div>
    </form>
</div>
@endsection
