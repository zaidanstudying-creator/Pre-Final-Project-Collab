<?php

namespace App\Livewire\Author;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookIndex extends Component
{
    public function submitForReview($bookId)
    {
        $book = Book::where('id', $bookId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Minimal harus ada 1 bab sebelum diajukan review
        if ($book->chapters()->count() === 0) {
            session()->flash('error', 'Buku harus memiliki minimal 1 bab sebelum diajukan ke admin.');
            return;
        }

        $book->update(['status' => 'pending']);
        session()->flash('success', 'Buku berhasil diajukan untuk ditinjau admin.');
    }

    public function render()
    {
        $books = Book::where('user_id', Auth::id())
            ->with(['category', 'chapters'])
            ->latest()
            ->get();

        return view('livewire.author.book-index', [
            'books' => $books,
        ])->layout('layouts.app');
    }
}
