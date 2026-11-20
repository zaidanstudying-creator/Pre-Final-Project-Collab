<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin (untuk uji coba panel moderasi & kategori)
        User::create([
            'name' => 'Admin Weboo',
            'email' => 'admin@weboo.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'bio' => 'Administrator utama platform Weboo.',
        ]);

        // 2. Akun Penulis / User biasa
        User::create([
            'name' => 'Penulis Demo',
            'email' => 'penulis@weboo.test',
            'password' => Hash::make('password'),
            'role' => 'user',
            'bio' => 'Penulis pemula pencinta cerita fantasi dan fiksi ilmiah.',
        ]);

        // 3. Kategori default buku
        $categories = ['Fiksi', 'Horor', 'Romansa', 'Fantasi', 'Teknologi', 'Puisi'];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
            ]);
        }
    }
}
