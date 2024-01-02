{{-- resources/views/admin/edit.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <form action="{{ route('admin.jokes.update', $joke) }}" method="POST" class="w-full max-w-lg">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label for="text" class="block text-gray-700 text-sm font-bold mb-2">Joke Text</label>
            <textarea name="text" id="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="4">{{ $joke->text }}</textarea>
        </div>

        <div class="mb-6">
            <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
            <div class="inline-block relative w-full">
                <select name="category_id" id="category" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $joke->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M5.59 7.41L10 11.83l4.41-4.42 1.42 1.41-5.83 5.83-5.83-5.83z"/>
                    </svg>
                </div>
            </div>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Joke</button>
    </form>
</div>
@endsection
