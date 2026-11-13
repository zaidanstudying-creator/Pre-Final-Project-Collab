<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CategoryManage extends Component
{
    public ?int $categoryId = null;

    public string $name = '';

    public function mount(): void
    {
        abort_unless(Auth::user()?->isAdmin(), 403);
    }

    public function save(): void
    {
        $this->name = trim($this->name);

        $this->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($this->categoryId),
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.min' => 'Nama kategori harus terdiri dari minimal 3 karakter.',
            'name.unique' => 'Nama kategori tersebut sudah digunakan.',
        ]);

        $slug = Str::slug($this->name);
        $category = $this->categoryId
            ? Category::query()->findOrFail($this->categoryId)
            : new Category();

        $category->name = $this->name;
        $category->slug = $this->uniqueSlug($slug, $category->getKey());
        $category->save();

        $wasEditing = $this->categoryId !== null;
        $this->resetForm();
        session()->flash('success', $wasEditing ? 'Kategori berhasil diperbarui.' : 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $categoryId): void
    {
        $category = Category::query()->findOrFail($categoryId);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->resetValidation();
    }

    public function delete(int $categoryId): void
    {
        $category = Category::query()->withCount('books')->findOrFail($categoryId);

        if ($category->books_count > 0) {
            session()->flash('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh '.$category->books_count.' buku.');

            return;
        }

        $category->delete();

        if ($this->categoryId === $categoryId) {
            $this->resetForm();
        }

        session()->flash('success', 'Kategori berhasil dihapus.');
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
    }

    private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'kategori';
        $slug = $baseSlug;
        $suffix = 2;

        while (Category::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $baseSlug.'-'.$suffix++;
        }

        return $slug;
    }

    private function resetForm(): void
    {
        $this->categoryId = null;
        $this->name = '';
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.category-manage', [
            'categories' => Category::query()->withCount('books')->orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}
