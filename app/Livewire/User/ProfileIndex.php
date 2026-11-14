<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Book;

class ProfileIndex extends Component
{
    public $user;
    public $publishedBooks;

    public function mount($id = null)
    {
        // Jika ada ID di URL, tampilkan user tersebut. Jika tidak, tampilkan user yang sedang login.
        if ($id) {
            $this->user = User::findOrFail($id);
        } else {
            $this->user = auth()->user();
        }

        // Jika tidak ada user (misal guest mengakses /profile tanpa ID), lempar ke 404
        if (!$this->user) {
            abort(404);
        }

        // Ambil HANYA buku yang statusnya 'published' dari user ini
        $this->publishedBooks = Book::where('user_id', $this->user->id)
                                    ->where('status', 'published')
                                    ->get();
    }

    public function render()
    {
        // Halaman profil menggunakan layout utama (Navbar Wattpad)
        return view('livewire.user.profile-index')
            ->layout('layouts.app');
    }
}
