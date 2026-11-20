<?php

namespace App\Livewire\Author;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookCreate extends Component
{
    use WithFileUploads;

    public $title = '';
    public $category_id = '';
    public $synopsis = '';
    public $cover_image;

    protected $rules = [
        'title' => 'required|min:3|max:150',
        'category_id' => 'required|exists:categories,id',
        'synopsis' => 'required|min:20',
        'cover_image' => 'nullable|image|max:2048', // Max 2MB
    ];

    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->cover_image) {
            $imagePath = $this->cover_image->store('covers', 'public');
        }

        // Generate slug unik
        $baseSlug = Str::slug($this->title);
        $slug = $baseSlug;
        $counter = 1;
        while (Book::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $book = Book::create([
            'user_id' => Auth::id(),
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $slug,
            'synopsis' => $this->synopsis,
            'cover_image' => $imagePath,
            'status' => 'draft',
        ]);

        session()->flash('success', 'Buku berhasil dibuat dalam status draft! Silakan tambahkan bab pertama ceritamu.');
        return $this->redirect(route('author.chapters.index', $book), navigate: true);
    }

    public function render()
    {
        return view('livewire.author.book-create', [
            'categories' => Category::all(),
        ])->layout('layouts.app');
    }
}
