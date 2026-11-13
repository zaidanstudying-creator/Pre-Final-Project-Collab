<?php

namespace App\Livewire\Admin;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModerationIndex extends Component
{
    public ?int $rejectingBookId = null;

    public string $adminNotes = '';

    public function mount(): void
    {
        abort_unless(Auth::user()?->isAdmin(), 403);
    }

    public function approve(int $bookId): void
    {
        $book = Book::query()->whereKey($bookId)->where('status', 'pending')->firstOrFail();
        $book->update(['status' => 'published', 'admin_notes' => null]);

        session()->flash('success', 'Buku berhasil disetujui dan diterbitkan.');
    }

    public function startReject(int $bookId): void
    {
        Book::query()->whereKey($bookId)->where('status', 'pending')->firstOrFail();
        $this->rejectingBookId = $bookId;
        $this->adminNotes = '';
        $this->resetValidation();
    }

    public function reject(): void
    {
        $this->validate([
            'adminNotes' => ['required', 'string', 'min:10'],
        ], [
            'adminNotes.required' => 'Catatan admin wajib diisi.',
            'adminNotes.min' => 'Catatan admin harus terdiri dari minimal 10 karakter.',
        ]);

        $book = Book::query()
            ->whereKey($this->rejectingBookId)
            ->where('status', 'pending')
            ->firstOrFail();

        $book->update([
            'status' => 'rejected',
            'admin_notes' => $this->adminNotes,
        ]);

        $this->closeRejectForm();
        session()->flash('success', 'Buku ditolak dan catatan revisi berhasil dikirim.');
    }

    public function closeRejectForm(): void
    {
        $this->rejectingBookId = null;
        $this->adminNotes = '';
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.moderation-index', [
            'books' => Book::query()
                ->with(['user', 'category', 'chapters'])
                ->where('status', 'pending')
                ->latest()
                ->get(),
        ])->layout('layouts.app');
    }
}
