{{-- resources/views/admin/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-2xl font-semibold">Joke Management</h1>
        <a href="{{ route('admin.jokes.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">Add New Joke</a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Joke</th>
                    <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                    <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Posted By</th>
                    <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jokes as $joke)
                    <tr class="hover:bg-gray-100">
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $joke->text }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $joke->category->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $joke->user->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a href="{{ route('admin.jokes.edit', $joke) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
                            <form action="{{ route('admin.jokes.destroy', $joke) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold ml-4" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $jokes->links() }}
    </div>
</div>
@endsection
