{{-- resources/views/jokes/random.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Joke Display Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg flex items-start p-5">
            <!-- Voting Section -->
            <div class="flex flex-col items-center mr-4">
                <!-- Upvote Button -->
                <button type="button" class="upvote-button p-2 bg-blue-100 text-blue-500 hover:bg-blue-200 rounded-full shadow transition duration-150 ease-in-out dark:bg-blue-200 dark:text-blue-600">
                    <i class="fas fa-arrow-up"></i>
                </button>

                <!-- Votes Count -->
                <span class="font-bold text-lg my-1">{{ $joke->upvotes }}</span>

                <!-- Downvote Button -->
                <button type="button" class="downvote-button p-2 bg-red-100 text-red-500 hover:bg-red-200 rounded-full shadow transition duration-150 ease-in-out dark:bg-red-200 dark:text-red-600">
                    <i class="fas fa-arrow-down"></i>
                </button>
            </div>

            <!-- Joke Content -->
            <div class="flex-1">
                <!-- Joke ID and Category -->
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-500 text-sm dark:text-gray-400">
                        Dowcip #{{ $joke->id }} | Kategoria: <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300">{{ $joke->category->name }}</a>
                    </span>
                    <!-- Read Aloud Button -->
                    <button class="read-aloud-button" data-joke-text="{{ addslashes($joke->text) }}">
                        <i class="fas fa-volume-up dark:text-white"></i>
                    </button>
                </div>
                <p class="text-gray-700 my-2 dark:text-gray-300" style="white-space: pre-wrap;">{{ $joke->text }}</p>

                <!-- Line Separator -->
                <hr class="my-4 dark:border-gray-600">

                <!-- Interactions (Favorite, Comments, Share) -->
                <!-- Adjust this section as per your design in welcome.blade.php -->
            </div>
        </div>

        <!-- Button to load a new random joke -->
        <div class="text-center">
            <form action="{{ route('jokes.random') }}" method="GET">
                <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300 ease-in-out transform hover:scale-105">
                    Następny losowy dowcip
                </button>
            </form>
        </div>
    </div>
</div>

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
