<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JokeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController; // Import at the top
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [JokeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/jokes', [JokeController::class, 'index'])->name('jokes.index');
Route::get('/dodaj', [JokeController::class, 'create'])->name('jokes.create');
Route::post('/jokes', [JokeController::class, 'store'])->name('jokes.store');
Route::get('/jokes', [JokeController::class, 'index'])->name('jokes.index');

Route::get('/jokes/{joke}', [JokeController::class, 'show'])->name('jokes.show');
Route::post('/jokes/{joke}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::post('/send-contact', [ContactController::class, 'sendContactForm'])->name('send.contact');

Route::get('/random', [JokeController::class, 'random'])->name('jokes.random');

Route::post('/jokes/{joke}/upvote', [JokeController::class, 'upvote'])->name('jokes.upvote');
Route::post('/jokes/{joke}/downvote', [JokeController::class, 'downvote'])->name('jokes.downvote');
Route::post('/jokes/{joke}/favorite', [JokeController::class, 'favorite'])->name('jokes.favorite')->middleware('auth');

// Change the route name from 'favorites.index' to 'jokes.favorites'
Route::get('/ulubione', [JokeController::class, 'favorites'])->name('jokes.favorites')->middleware('auth');
Route::get('/category/{slug}', [JokeController::class, 'categoryJokes'])->name('category.jokes');

Route::get('/admin/jokes', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/jokes/{joke}/edit', [AdminController::class, 'edit'])->name('admin.jokes.edit');
Route::put('/admin/jokes/{joke}', [AdminController::class, 'update'])->name('admin.jokes.update');
Route::delete('/admin/jokes/{joke}', [AdminController::class, 'destroy'])->name('admin.jokes.destroy');
Route::get('/admin/jokes/create', [AdminController::class, 'create'])->name('admin.jokes.create');


Route::post('/toggle-favorite', [JokeController::class, 'favorite'])->name('jokes.toggleFavorite');

Route::get('/search', [JokeController::class, 'search'])->name('jokes.search');

Route::get('/polityka-prywatnosci', function () {
    return view('polityka-prywatnosci');
})->name('polityka-prywatnosci');

Route::get('/regulamin', function () {
    return view('regulamin');
})->name('regulamin');

Route::get('/kontakt', function () {
    return view('kontakt');
})->name('kontakt');



// Route::group(['middleware' => ['auth', 'admin']], function () {
//     // Place your admin routes here
//     Route::get('/admin', 'AdminController@index')->name('admin.index');
// });


require __DIR__.'/auth.php';
