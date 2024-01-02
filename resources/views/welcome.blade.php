{{-- resources/views/welcome.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900">
    <div class="flex -mx-4">
        <!-- Main Content -->
        <div class="w-full lg:w-3/4 px-4">
<!-- Filter box -->
<div class="max-w-4xl mx-auto px-4 lg:px-0">
    <div class="flex flex-wrap justify-start items-center mb-4 gap-2 lg:justify-between">
        
        <form action="{{ route('jokes.index') }}" method="GET" class="inline-flex w-full justify-end items-center">
            <span class="text-gray-700 dark:text-white ml-auto">Filtruj:</span>
            <select name="sort" onchange="this.form.submit()" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 ml-2">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Najnowsze</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Najstarsze</option>
                <option value="highest_rating" {{ request('sort') == 'highest_rating' ? 'selected' : '' }}>Najwyżej oceniane</option>
                <option value="lowest_rating" {{ request('sort') == 'lowest_rating' ? 'selected' : '' }}>Najniżej oceniane</option>
            </select>
        </form>
    </div>
</div>



    <div class="max-w-4xl mx-auto space-y-8">
        @foreach ($jokes as $joke)
            <div class="bg-white rounded-lg shadow-lg flex items-start p-5 dark:bg-gray-800">
                <!-- Voting Section -->
                <div class="flex flex-col items-center mr-4">
                        <!-- Upvote Button -->
                        <button type="button" class="requires-auth upvote-button p-2 bg-blue-100 text-blue-500 hover:bg-blue-200 rounded-full shadow transition duration-150 ease-in-out dark:bg-blue-200 dark:text-blue-600" data-joke-id="{{ $joke->id }}">
                            <i class="fas fa-arrow-up"></i>
                        </button>

                        <!-- Votes Count -->
                        <span class="font-bold text-lg my-1 votes-count dark:text-gray-200">{{ $joke->upvotes }}</span>

                        <!-- Downvote Button -->
                        <button type="button" class="requires-auth downvote-button p-2 bg-red-100 text-red-500 hover:bg-red-200 rounded-full shadow transition duration-150 ease-in-out dark:bg-red-200 dark:text-red-600" data-joke-id="{{ $joke->id }}">
                            <i class="fas fa-arrow-down"></i>
                        </button>
                </div>

                <!-- Joke Content -->
                <div class="flex-1 ">
                    <!-- Joke Category (Upper Right Corner) -->
                    <div class="flex justify-between items-center mb-2">

                <!-- Joke ID and Category -->
                <div class="flex flex-col justify-between">
                    <span class="text-gray-500 text-sm dark:text-gray-400">
                        Dowcip #{{ $joke->id }} | Kategoria: <a href="{{ route('category.jokes', $joke->category->slug) }}" class="hover:text-gray-700 dark:hover:text-gray-300">{{ $joke->category->name }}</a>
                    </span>
                </div>
                    <!-- Read Aloud Button -->
                    <button class="read-aloud-button" data-joke-text="{{ addslashes($joke->text) }}">
                        <i class="fas fa-volume-up dark:text-white"></i>
                    </button>
                    </div>
                    <p class="text-gray-700 my-2 dark:text-gray-300" style="white-space: pre-wrap;">{!! $joke->text !!}</p>

                    <!-- Line Separator -->
                    <hr class="my-4 dark:border-gray-600">
                    <!-- Interactions (Evenly Spaced) -->
                    <div class="flex justify-between items-center">
                        <!-- Favorite Button -->
                        <form class="favorite-form">
                            @csrf
                            <button type="button" class="favorite-button text-gray-500 hover:text-red-600 p-2 rounded-full mr-2 dark:text-gray-400 dark:hover:text-red-500" data-joke-id="{{ $joke->id }}">
                                <i class="{{ $favoriteJokeIds->contains($joke->id) ? 'fas fa-heart text-red-500' : 'far fa-heart' }} text-2xl"></i>
                            </button>
                        </form>

                        <!-- Comments Placeholder (Right) -->
                        <button class="text-gray-500 hover:text-gray-600 p-2 rounded-full ml-2 dark:text-gray-400 dark:hover:text-gray-300">
                            <a href="{{ route('jokes.show', $joke) }}" class="text-gray-500 hover:text-gray-600 p-2 rounded-full">
                                <i class="fas fa-comments text-2xl"></i>
                            </a>
                        </button>

                        <!-- Share Button with Dropdown -->
                        <div class="relative inline-block text-left">
                            <button type="button" class="inline-flex justify-center w-full p-2 rounded-full text-gray-700 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-200" id="share-menu-{{ $joke->id }}" aria-haspopup="true" aria-expanded="true">
                                <i class="fas fa-share-alt text-2xl"></i>
                            </button>
                            <!-- Share Menu -->
                            <div class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 dark:bg-gray-700" aria-labelledby="share-menu-{{ $joke->id }}" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1" role="none">
                                    {{-- List your share options here --}}
                                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm dark:text-gray-300" role="menuitem" tabindex="-1" id="menu-item-0">Share on Facebook</a>
                                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm dark:text-gray-300" role="menuitem" tabindex="-1" id="menu-item-1">Share on WhatsApp</a>
                                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm dark:text-gray-300" role="menuitem" tabindex="-1" id="menu-item-2">Share on Pinterest</a>
                                    {{-- Add more as needed --}}
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            
        @endforeach
    </div>
    

    <!-- Pagination and SEO Text -->
    <div class="mt-8 flex justify-center">
        {{ $jokes->links() }} {{-- Pagination links --}}
    </div>

    <div class="mt-8 px-4 py-2 bg-white rounded-lg shadow dark:bg-gray-700">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">O Jokebox.pl</h2>
        <p class="text-gray-600 mt-2 dark:text-gray-300">
            Witamy w świecie Jokebox.pl, Twoim źródle niekończącej się zabawy i humoru. Nasz serwis internetowy to prawdziwa skarbnica dowcipów, żartów i kawałów, które rozśmieszą Cię do łez! Każdego dnia dostarczamy świeże porcje humoru, od klasycznych kawałów po najnowsze hity internetowe. 
        </p>
        <p class="text-gray-600 mt-2 dark:text-gray-300">
            Szukasz czegoś, co poprawi Ci humor? Przejrzyj naszą obszerną kolekcję żartów i odnajdź te, które pasują do Twojego poczucia humoru. W Jokebox.pl wierzymy, że śmiech to najlepsze lekarstwo, dlatego nieustannie pracujemy, aby dostarczać najlepsze kawały, które rozweselą każdy dzień.
        </p>
        <p class="text-gray-600 mt-2 dark:text-gray-300">
            Dołącz do naszej społeczności miłośników humoru, dziel się swoimi ulubionymi dowcipami i odkrywaj nowe, które rozświetlą Twój dzień. Jokebox.pl to więcej niż serwis z dowcipami - to miejsce, gdzie humor łączy ludzi i sprawia, że każdy dzień staje się jaśniejszy.
        </p>
        <p class="text-gray-600 mt-2 dark:text-gray-300">
            Pamiętaj, śmiech to zdrowie! Odkryj humor na nowo z Jokebox.pl – Twoim źródłem najlepszych dowcipów, żartów i kawałów w sieci.
        </p>
    </div>

     <!-- Sidebar for Joke Categories -->
</div>


    <div class="w-full lg:w-1/4 px-4">
        <div class="sticky top-8">
            <h3 class="text-xl font-semibold mb-4 dark:text-white">Kategorie:</h3>
            <ul class="space-y-3">
                {{-- Replace $categories with your categories data --}}
                @foreach ($categories as $category)
                    <li class="dark:text-gray-300">
                        <a href="{{ route('category.jokes', $category->slug) }}" class="hover:text-blue-500 transition duration-300 ease-in-out">
                            {{ $category->name }} ({{ $category->jokes_count }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>



<!-- At the bottom of your Blade file, before the closing </body> tag -->
<script>
$(document).ready(function() {
    // CSRF token for AJAX call
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.favorite-button').click(function(e) {
    e.preventDefault();
    let button = $(this);
    let jokeId = button.data('joke-id');

    $.ajax({
        url: `/jokes/${jokeId}/favorite`,   
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            if(response.isFavorited) {
                button.find('i').removeClass('far').addClass('fas text-red-500');
            } else {
                button.find('i').removeClass('fas text-red-500').addClass('far');
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
});



    $('.upvote-button').on('click', function(e) {
    e.preventDefault();
    let button = $(this);
    let jokeId = button.data('joke-id');

    $.ajax({
        url: `/jokes/${jokeId}/upvote`,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            button.siblings('.votes-count').text(response.newVotesCount);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
});

$('.downvote-button').on('click', function(e) {
    e.preventDefault();
    let button = $(this);
    let jokeId = button.data('joke-id');

    $.ajax({
        url: `/jokes/${jokeId}/downvote`,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            button.siblings('.votes-count').text(response.newVotesCount);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
});


});
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const readAloudButtons = document.querySelectorAll('.read-aloud-button');
    
        readAloudButtons.forEach(button => {
            button.addEventListener('click', () => {
                const text = button.getAttribute('data-joke-text');
                const icon = button.querySelector('i');
                toggleSpeak(text, icon);
            });
        });
    });
    
    let isSpeaking = false;
    let currentSpeechSynthesisUtterance = null;
    
    function toggleSpeak(text, icon) {
        if (isSpeaking) {
            window.speechSynthesis.cancel();
            isSpeaking = false;
            if (currentSpeechSynthesisUtterance) {
                currentSpeechSynthesisUtterance = null;
            }
            icon.classList.remove('fa-pause');
            icon.classList.add('fa-volume-up');
        } else {
            if (currentSpeechSynthesisUtterance) {
                window.speechSynthesis.cancel();
                isSpeaking = false;
            }
            const msg = new SpeechSynthesisUtterance();
            msg.text = text;
            window.speechSynthesis.speak(msg);
            currentSpeechSynthesisUtterance = msg;
            isSpeaking = true;
            icon.classList.remove('fa-volume-up');
            icon.classList.add('fa-pause');
    
            msg.onend = () => {
                isSpeaking = false;
                icon.classList.remove('fa-pause');
                icon.classList.add('fa-volume-up');
            };
        }
    }
    
    window.onbeforeunload = () => {
        window.speechSynthesis.cancel();
    };
    </script>
    
    


@endsection
