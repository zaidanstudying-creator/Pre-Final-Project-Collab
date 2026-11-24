<?php

namespace App\Livewire\Interactions;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class BookComments extends Component
{
    use WithPagination;

    public Book $book;

    #[Rule('required|string|min:3|max:500', message: [
        'required' => 'Komentar tidak boleh kosong.',
        'min' => 'Komentar minimal 3 karakter.',
        'max' => 'Komentar maksimal 500 karakter.',
    ])]
    public string $body = '';

    public function mount(Book $book): void
    {
        $this->book = $book;
    }

    public function postComment(): void
    {
        if (! Auth::check()) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        $this->validate();

        $this->book->comments()->create([
            'user_id' => Auth::id(),
            'body' => trim($this->body),
        ]);

        $this->reset('body');
        $this->resetPage();

        session()->flash('comment_status', 'Komentar Anda berhasil dipublikasikan!');
    }

    public function deleteComment(int $commentId): void
    {
        abort_unless(Auth::check(), 401);

        $comment = Comment::query()->whereKey($commentId)->where('book_id', $this->book->id)->firstOrFail();

        abort_unless(Auth::id() === $comment->user_id || Auth::user()?->isAdmin(), 403, 'Anda tidak berhak menghapus komentar ini.');

        $comment->delete();

        session()->flash('comment_status', 'Komentar berhasil dihapus.');
    }

    public function render()
    {
        $comments = $this->book->comments()
            ->with('user:id,name,role')
            ->latest()
            ->paginate(6);

        return view('livewire.interactions.book-comments', [
            'comments' => $comments,
            'totalComments' => $this->book->comments()->count(),
        ]);
    }
}
