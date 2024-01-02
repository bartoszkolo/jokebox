@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-center mb-6 text-gray-800 dark:text-gray-200">{{ $categoryName }} Dowcipy</h1>
    <div class="max-w-4xl space-y-8 mx-auto">
        @forelse ($jokes as $joke)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg flex items-start p-6">
                <!-- Voting Section -->
                <div class="flex flex-col items-center mr-4">
                    @auth
                        <!-- Upvote Button -->
                        <form action="{{ route('jokes.upvote', $joke) }}" method="POST">
                            @csrf
                            <button type="submit" class="mb-1 hover:scale-110 transition-transform">
                                <i class="fas fa-arrow-up text-blue-500 hover:text-blue-600"></i>
                            </button>
                            <span class="font-bold text-lg dark:text-gray-200">{{ $joke->votes_count }}</span>
                            <!-- Downvote Button -->
                            <form action="{{ route('jokes.downvote', $joke) }}" method="POST">
                                @csrf
                                <button type="submit" class="mt-1 hover:scale-110 transition-transform">
                                    <i class="fas fa-arrow-down text-red-500 hover:text-red-600"></i>
                                </button>
                            </form>
                        @else
                            <p class="text-sm text-red-500 dark:text-red-400">Log in to vote</p>
                        @endauth
                </div>

                <!-- Joke Content -->
                <div class="flex-1">
                    <!-- Joke Category -->
                    <div class="text-right text-gray-500 dark:text-gray-400 text-sm mb-2">{{ $joke->category->name }}</div>
                    <p class="text-gray-700 dark:text-gray-300 my-2" style="white-space: pre-wrap;">{{ $joke->text }}</p>

                    <!-- Line Separator -->
                    <hr class="my-4 dark:border-gray-700">

                    <!-- Interactions Section -->
                    <div class="flex justify-between items-center">
                        <!-- Favorite Button -->
                        <form action="{{ route('jokes.favorite', $joke) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-500 dark:text-gray-400 hover:text-red-600 p-2 rounded-full mr-2">
                                <i class="{{ $joke->favoritedByUsers()->where('user_id', auth()->id())->exists() ? 'fas fa-heart text-red-500' : 'far fa-heart' }} text-2xl"></i>
                            </button>
                        </form>

                        <!-- Comments Button -->
                        <a href="{{ route('jokes.show', $joke) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 p-2 rounded-full">
                            <i class="fas fa-comments text-2xl"></i>
                        </a>

                        <!-- Share Button -->
                        <button onclick="navigator.clipboard.writeText('{{ Request::url() }}/jokes/{{ $joke->id }}')" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 p-2 rounded-full">
                            <i class="fas fa-share-alt text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-800 dark:text-gray-300">Nie znaleziono dowcipów w tej kategorii.</p>
        @endforelse
    </div>
    <div class="mt-8">
        {{ $jokes->links() }} {{-- Pagination links --}}
    </div>
</div>
@endsection
