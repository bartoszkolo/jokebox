{{-- resources/views/jokes/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-6">Jokes List</h1>

    {{-- Temporary test output --}}
    <div class="bg-white rounded shadow p-4 mb-4">
        <p>{!! nl2br(e("Here's a line.\nAnd here's another one.")) !!}</p>
    </div>

    {{-- Rest of your view --}}
</div>
@endsection
