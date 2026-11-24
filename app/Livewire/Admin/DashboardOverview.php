<?php

namespace App\Livewire\Admin;

use App\Models\Book;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardOverview extends Component
{
    use WithPagination;

    public string $search = '';

    public function mount(): void
    {
        abort_unless(Auth::user()?->isAdmin(), 403);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function deleteComment(int $commentId): void
    {
        abort_unless(Auth::user()?->isAdmin(), 403);

        $comment = Comment::findOrFail($commentId);
        $comment->delete();

        session()->flash('success', 'Komentar berhasil dihapus.');
    }

    public function render()
    {
        // 4 Kartu Metrik Platform
        $metrics = [
            'total_users' => User::count(),
            'total_published_books' => Book::where('status', 'published')->count(),
            'total_pending_books' => Book::where('status', 'pending')->count(),
            'total_comments' => Comment::count(),
        ];

        // Tabel Moderasi Komentar Terbaru dengan pencarian dan pagination
        $comments = Comment::query()
            ->with(['user:id,name,email', 'book:id,title,slug'])
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('body', 'like', '%'.$this->search.'%')
                        ->orWhereHas('user', function ($sub) {
                            $sub->where('name', 'like', '%'.$this->search.'%')
                                ->orWhere('email', 'like', '%'.$this->search.'%');
                        })
                        ->orWhereHas('book', function ($sub) {
                            $sub->where('title', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.dashboard-overview', [
            'metrics' => $metrics,
            'comments' => $comments,
        ])->layout('layouts.dashboard');
    }
}
