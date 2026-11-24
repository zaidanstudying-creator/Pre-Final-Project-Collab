<?php

namespace App\Livewire\Author;

use App\Models\Book;
use App\Models\BookLike;
use App\Models\Comment;
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
        $userId = Auth::id();

        $books = Book::where('user_id', $userId)
            ->with(['category', 'chapters'])
            ->latest()
            ->get();

        $stats = [
            'total_books' => $books->count(),
            'total_views' => (int) Book::where('user_id', $userId)->sum('views_count'),
            'total_likes' => BookLike::whereIn('book_id', Book::where('user_id', $userId)->select('id'))->count(),
            'total_comments' => Comment::whereIn('book_id', Book::where('user_id', $userId)->select('id'))->count(),
        ];

        return view('livewire.author.book-index', [
            'books' => $books,
            'stats' => $stats,
        ])->layout('layouts.app');
    }
}
