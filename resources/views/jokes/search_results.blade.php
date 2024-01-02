@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-center mb-6 text-gray-800 dark:text-gray-200">Wyniki wyszukiwania:</h1>

    <div class="max-w-4xl space-y-8 mx-auto">
        @forelse ($jokes as $joke)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg flex items-start p-6">
                <!-- Voting Section -->
                <div class="flex flex-col items-center mr-4">
                    @auth
                        <!-- Upvote Button -->
                        <form action="{{ route('jokes.upvote', $joke) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-blue-500 hover:text-blue-600 mb-1">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                        </form>

                        <!-- Votes Count -->
                        <span class="font-bold text-lg dark:text-gray-200">{{ $joke->votes_count }}</span>

                        <!-- Downvote Button -->
                        <form action="{{ route('jokes.downvote', $joke) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-600 mt-1">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </form>
                    @else
                        <p class="text-sm text-red-500 dark:text-red-400">Zaloguj się, aby głosować</p>
                    @endauth
                </div>

                <!-- Joke Content -->
                <div class="flex-1">
                    <div class="text-right text-gray-500 dark:text-gray-400 text-sm mb-2">
                        <a href="{{ route('category.jokes', $joke->category->slug) }}" class="hover:text-gray-700 dark:hover:text-gray-300">
                            {{ $joke->category->name }}
                        </a>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 my-2" style="white-space: pre-wrap;">{!! $joke->text !!}</p>

                      <!-- Interactions Section -->
                <div class="flex justify-between items-center mt-4">
                    <!-- Favorite Button -->
                    <button class="favorite-button text-gray-500 hover:text-red-600 p-2 rounded-full" data-joke-id="{{ $joke->id }}">
                        <i class="{{ $userFavorites->contains($joke->id) ? 'fas fa-heart text-red-500' : 'far fa-heart' }} text-2xl"></i>
                    </button>

                    <!-- Comments Placeholder -->
                    <a href="{{ route('jokes.show', $joke) }}" class="text-gray-500 hover:text-gray-600 p-2 rounded-full">
                        <i class="fas fa-comments"></i>
                    </a>

                    <!-- Share Button -->
                    <button class="share-button p-2 rounded-full text-gray-700 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-200">
                        <i class="fas fa-share-alt text-2xl"></i>
                    </button>
                </div>
                </div>
            </div>
        @empty
            <p class="text-gray-800 dark:text-gray-300">Nie znaleziono dowcipów spełniających kryteria.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $jokes->links() }}
    </div>
</div>

<!-- Include any specific scripts for interaction like the favorite button as in welcome.blade.php -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Favorite button interaction
        $('.favorite-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var jokeId = button.data('joke-id');
            var url = `/jokes/${jokeId}/favorite`;

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.favorited) {
                        button.find('i').removeClass('far').addClass('fas').addClass('text-red-500');
                    } else {
                        button.find('i').removeClass('fas').removeClass('text-red-500').addClass('far');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        // Voting interaction (upvote and downvote)
        // Note: Adjust the selectors and URLs based on your actual HTML structure and routes
        $('.upvote-button, .downvote-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var jokeId = button.closest('.joke-container').data('joke-id'); // Adjust the selector as needed
            var isUpvote = button.hasClass('upvote-button');
            var url = `/jokes/${jokeId}/${isUpvote ? 'upvote' : 'downvote'}`;

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Update the votes count
                    button.siblings('.votes-count').text(response.newVotesCount);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
@endsection
