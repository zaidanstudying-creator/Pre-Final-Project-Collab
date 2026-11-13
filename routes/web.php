<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Author\BookIndex;
use App\Livewire\Author\BookCreate;
use App\Livewire\Author\BookEdit;
use App\Livewire\Author\ChapterManage;
use App\Livewire\Admin\ModerationIndex;
use App\Livewire\Admin\CategoryManage;
use App\Livewire\User\BookmarkList;


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

// route buku
Route::middleware(['auth'])->group(function () {
    Route::get('/bookmarks', BookmarkList::class)->name('bookmarks.index');
});

// admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/moderation', ModerationIndex::class)->name('moderation.index');
    Route::get('/categories', CategoryManage::class)->name('categories.index');
});

require __DIR__.'/auth.php';
