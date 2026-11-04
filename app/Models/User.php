<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'bio'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    // /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: Satu user/penulis bisa memiliki banyak buku
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Relasi: Buku yang disimpan/di-bookmark oleh user ke rak baca
     */
    public function bookmarkedBooks(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'bookmarks')->withTimestamps();
    }

    /**
     * Helper untuk cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
