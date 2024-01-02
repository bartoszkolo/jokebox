{{-- resources/views/jokes/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold mb-6 text-gray-800 dark:text-gray-200 text-center">Dodaj nowy żart</h1>

    <form method="POST" action="{{ route('jokes.store') }}" class="max-w-xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategoria</label>
            <select id="category_id" name="category_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-white">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label for="text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Treść</label>
            <textarea id="text" name="text" rows="4" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
        </div>

        <div class="g-recaptcha mb-4" data-sitekey="6Lcu0RMpAAAAAGZpAIcOi6dVnRcr5ppBcKGaS9pw"></div>

        <div class="flex items-center justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-600 active:bg-teal-600 focus:outline-none focus:border-teal-600 focus:ring focus:ring-teal-200 disabled:opacity-25 transition ease-in-out duration-150">
                Dodaj 
            </button>
        </div>
    </form>
</div>
@endsection
