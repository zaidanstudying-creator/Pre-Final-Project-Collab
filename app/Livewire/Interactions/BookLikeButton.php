<?php

namespace App\Livewire\Interactions;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookLikeButton extends Component
{
    public Book $book;

    public int $likesCount = 0;

    public bool $isLiked = false;

    public function mount(Book $book): void
    {
        $this->book = $book;
        $this->likesCount = $book->likes()->count();
        $this->isLiked = Auth::check() && $book->likes()->where('user_id', Auth::id())->exists();
    }

    public function toggleLike()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'), navigate: true);
        }

        $userId = Auth::id();
        $existingLike = $this->book->likes()->where('user_id', $userId)->first();

        if ($existingLike) {
            $existingLike->delete();
            $this->isLiked = false;
            $this->likesCount = max(0, $this->likesCount - 1);
        } else {
            $this->book->likes()->create([
                'user_id' => $userId,
            ]);
            $this->isLiked = true;
            $this->likesCount++;
        }
    }

    public function render()
    {
        return view('livewire.interactions.book-like-button');
    }
}
