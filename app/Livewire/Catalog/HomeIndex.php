<?php

namespace App\Livewire\Catalog;

use App\Models\Book;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class HomeIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public string $category = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $books = Book::query()
            ->with(['user:id,name', 'category:id,name'])
            ->where('status', 'published')
            ->when($this->search !== '', fn ($query) => $query->where('title', 'like', '%'.$this->search.'%'))
            ->when($this->category !== '', fn ($query) => $query->where('category_id', $this->category))
            ->latest()
            ->paginate(12);

        return view('livewire.catalog.home-index', [
            'books' => $books,
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
        ])->layout('layouts.app');
    }
}
