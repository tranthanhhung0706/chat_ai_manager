<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\OpenAIStreamAssitantsController;
use App\Http\Controllers\ChatController;

Route::post('/chat/stream', [ChatController::class, 'streamChat']);

Route::get('/streamassitant-chat', [OpenAIStreamAssitantsController::class, 'streamChat']);
Route::get('/chat-stream-assitant', function () {
    return view('chat-stream-assitant'); 
});
Route::get('/pdf',[PDFController::class,"index"]);
Route::post('/pdf',[PDFController::class,"store"])->name("pdf.store");
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');
// Route::view('user', 'user')
//     ->middleware(['auth', 'verified'])
//     ->name('user');
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

Route::middleware(['auth','userMiddleware'])->group(function(){
    
    
});

Route::middleware(['auth','adminMiddleware'])->group(function(){
    Route::get('user',[AdminController::class,'index'])->name('user');
    Route::get('dashboard',[UserController::class,'index'])->name('dashboard');
    Route::view('posts', 'admin.posts')
    ->middleware(['auth', 'verified'])
    ->name('posts');
});