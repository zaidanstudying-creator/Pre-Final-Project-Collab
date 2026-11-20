<?php

namespace App\Livewire\Author;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookEdit extends Component
{
    use WithFileUploads;

    public Book $book;
    public $title;
    public $category_id;
    public $synopsis;
    public $cover_image;
    public $existing_cover;

    public function mount(Book $book)
    {
        // Proteksi: cegah user mengedit buku milik orang lain
        if ($book->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $this->book = $book;
        $this->title = $book->title;
        $this->category_id = $book->category_id;
        $this->synopsis = $book->synopsis;
        $this->existing_cover = $book->cover_image;
    }

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:150',
            'category_id' => 'required|exists:categories,id',
            'synopsis' => 'required|min:20',
            'cover_image' => 'nullable|image|max:2048',
        ];
    }

    public function update()
    {
        $this->validate();

        $imagePath = $this->existing_cover;

        // Jika ada upload cover baru
        if ($this->cover_image) {
            if ($this->existing_cover && Storage::disk('public')->exists($this->existing_cover)) {
                Storage::disk('public')->delete($this->existing_cover);
            }
            $imagePath = $this->cover_image->store('covers', 'public');
        }

        // Update data buku
        $this->book->update([
            'category_id' => $this->category_id,
            'title' => $this->title,
            'synopsis' => $this->synopsis,
            'cover_image' => $imagePath,
        ]);

        session()->flash('success', 'Informasi buku berhasil diperbarui!');
        return $this->redirect(route('author.books.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.author.book-edit', [
            'categories' => Category::all(),
        ])->layout('layouts.app');
    }
}
