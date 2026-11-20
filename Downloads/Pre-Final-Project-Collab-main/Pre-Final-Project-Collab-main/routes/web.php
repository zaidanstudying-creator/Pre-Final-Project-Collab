<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Author\BookIndex;
use App\Livewire\Author\BookCreate;
use App\Livewire\Author\BookEdit;
use App\Livewire\Author\ChapterManage;
use App\Livewire\Admin\ModerationIndex;
use App\Livewire\Admin\CategoryManage;
use App\Livewire\User\BookmarkList;
use App\Livewire\Catalog\HomeIndex;
use App\Livewire\Catalog\BookDetail;
use App\Livewire\Catalog\ChapterReader;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

// Rute Guest (Autentikasi)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

// Rute Publik (Katalog Utama)
Route::get('/', HomeIndex::class)->name('home');
Route::get('/book/{slug}', BookDetail::class)->name('book.detail');
Route::get('/book/{book_slug}/chapter/{chapter_number}', ChapterReader::class)->name('book.read');

// Rute Pembaca (Rak Buku)
Route::middleware(['auth'])->group(function () {
    Route::get('/bookmarks', BookmarkList::class)->name('bookmarks.index');
});

// Rute Penulis (Studio Karya)
Route::middleware(['auth'])->prefix('author')->name('author.')->group(function () {
    Route::get('/books', BookIndex::class)->name('books.index');
    Route::get('/books/create', BookCreate::class)->name('books.create');
    Route::get('/books/{book}/edit', BookEdit::class)->name('books.edit');
    Route::get('/books/{book}/chapters', ChapterManage::class)->name('chapters.index');
});

// Rute Administrator
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/moderation', ModerationIndex::class)->name('moderation.index');
    Route::get('/categories', CategoryManage::class)->name('categories.index');
});

// Tambahkan baris ini di routes/web.php (boleh diletakkan paling bawah)
Route::get('/profile/{id?}', \App\Livewire\User\ProfileIndex::class)->name('profile');
