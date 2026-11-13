<?php

namespace App\Livewire\Catalog;

use App\Models\Book;
use App\Models\Chapter;
use Livewire\Component;

class ChapterReader extends Component
{
    public Book $book;

    public Chapter $chapter;

    public ?Chapter $previousChapter = null;

    public ?Chapter $nextChapter = null;

    public function mount(string $book_slug, int $chapter_number): void
    {
        $this->book = Book::query()
            ->where('slug', $book_slug)
            ->where('status', 'published')
            ->firstOrFail();

        $this->chapter = $this->book->chapters()
            ->where('chapter_number', $chapter_number)
            ->firstOrFail();

        $this->previousChapter = $this->book->chapters()
            ->where('chapter_number', '<', $this->chapter->chapter_number)
            ->orderByDesc('chapter_number')
            ->first();

        $this->nextChapter = $this->book->chapters()
            ->where('chapter_number', '>', $this->chapter->chapter_number)
            ->orderBy('chapter_number')
            ->first();
    }

    public function render()
    {
        return view('livewire.catalog.chapter-reader')->layout('layouts.app');
    }
}
