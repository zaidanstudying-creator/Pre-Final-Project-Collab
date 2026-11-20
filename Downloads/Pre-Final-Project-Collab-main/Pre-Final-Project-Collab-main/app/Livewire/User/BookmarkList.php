<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookmarkList extends Component
{
    public function remove(int $bookId): void
    {
        Auth::user()->bookmarkedBooks()->detach($bookId);
        session()->flash('success', 'Buku berhasil dihapus dari rak bookmark.');
    }

    public function render()
    {
        return view('livewire.user.bookmark-list', [
            'books' => Auth::user()
                ->bookmarkedBooks()
                ->with(['user', 'category'])
                ->latest('books.created_at')
                ->get(),
        ])->layout('layouts.app');
    }
}
