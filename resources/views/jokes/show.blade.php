@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Joke Display Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="text-gray-800 dark:text-gray-300 my-2" style="white-space: pre-wrap;">{{ $joke->text }}</div>
            <div class="text-right text-gray-500 dark:text-gray-400 text-sm">{{ $joke->category->name }}</div>
            <hr class="my-4 dark:border-gray-700">
        </div>

        <!-- Comments Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Komentarze</h2>
            
            <!-- Comment Form -->
            <form action="{{ route('comments.store', $joke) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <textarea name="text" rows="3" class="form-control w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Twój komentarz" required></textarea>
                </div>
                <div class="mb-4">
                    <button type="submit" class="requires-auth bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-4 rounded-lg transition ease-in-out duration-150">
                        Dodaj Komentarz
                    </button>
                </div>
            </form>

            <!-- Comments Display -->
            @foreach ($joke->comments as $comment)
            <div class="border-b last:border-b-0 pb-4 mb-4 dark:border-gray-700">
                <p class="text-gray-800 dark:text-gray-300">{{ $comment->text }}</p>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Posted by {{ $comment->user->name }} on {{ $comment->created_at->format('F d, Y') }}
                </div>
            </div>
            @endforeach
            @if($joke->comments->isEmpty())
                <p class="dark:text-gray-300">Brak komentarzy.</p>
            @endif
        </div>
    </div>
</div>
@endsection
