<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Author\BookIndex;
use App\Livewire\Author\BookCreate;
use App\Livewire\Author\BookEdit;
use App\Livewire\Author\ChapterManage;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->prefix('author')->name('author.')->group(function () {
    Route::get('/books', BookIndex::class)->name('books.index');
    Route::get('/books/create', BookCreate::class)->name('books.create');
    Route::get('/books/{book}/edit', BookEdit::class)->name('books.edit');
    Route::get('/books/{book}/chapters', ChapterManage::class)->name('chapters.index');
});

require __DIR__.'/auth.php';
