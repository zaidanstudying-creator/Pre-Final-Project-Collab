<?php

namespace App\Livewire\Catalog;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookDetail extends Component
{
    public Book $book;

    public function mount(string $slug): void
    {
        $this->book = Book::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->with(['user:id,name', 'category:id,name', 'chapters'])
            ->firstOrFail();
    }

    public function saveToShelf()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'), navigate: true);
        }

        Auth::user()->bookmarkedBooks()->syncWithoutDetaching([$this->book->id]);
        session()->flash('status', 'Buku berhasil disimpan ke rak Anda.');
    }

    public function render()
    {
        return view('livewire.catalog.book-detail')->layout('layouts.app');
    }
}
