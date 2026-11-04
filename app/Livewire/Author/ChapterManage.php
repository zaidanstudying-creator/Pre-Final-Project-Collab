<?php

namespace App\Livewire\Author;

use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChapterManage extends Component
{
    public Book $book;

    // Form properties
    public $chapter_id = null;
    public $chapter_number;
    public $title = '';
    public $content = '';
    public $isEditing = false;

    protected function rules()
    {
        return [
            'chapter_number' => 'required|integer|min:1',
            'title' => 'required|min:3|max:150',
            'content' => 'required|min:50',
        ];
    }

    public function mount(Book $book)
    {
        // Proteksi: cegah user lain mengakses bab milik orang lain
        if ($book->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $this->book = $book;
        $this->setDefaultChapterNumber();
    }

    public function setDefaultChapterNumber()
    {
        $lastNumber = $this->book->chapters()->max('chapter_number') ?? 0;
        $this->chapter_number = $lastNumber + 1;
    }

    public function resetForm()
    {
        $this->reset(['chapter_id', 'title', 'content', 'isEditing']);
        $this->resetValidation();
        $this->setDefaultChapterNumber();
    }

    public function editChapter($id)
    {
        $chapter = $this->book->chapters()->findOrFail($id);
        $this->chapter_id = $chapter->id;
        $this->chapter_number = $chapter->chapter_number;
        $this->title = $chapter->title;
        $this->content = $chapter->content;
        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $chapter = $this->book->chapters()->findOrFail($this->chapter_id);
            $chapter->update([
                'chapter_number' => $this->chapter_number,
                'title' => $this->title,
                'content' => $this->content,
            ]);
            session()->flash('success', 'Bab berhasil diperbarui.');
        } else {
            $this->book->chapters()->create([
                'chapter_number' => $this->chapter_number,
                'title' => $this->title,
                'content' => $this->content,
            ]);
            session()->flash('success', 'Bab baru berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    public function deleteChapter($id)
    {
        $chapter = $this->book->chapters()->findOrFail($id);
        $chapter->delete();
        session()->flash('success', 'Bab berhasil dihapus.');
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.author.chapter-manage', [
            'chapters' => $this->book->chapters()->orderBy('chapter_number', 'asc')->get(),
        ])->layout('layouts.app');
    }
}
