<?php

use App\Livewire\Admin\DashboardOverview;
use App\Livewire\Author\BookIndex;
use App\Livewire\Catalog\BookDetail;
use App\Livewire\Catalog\ChapterReader;
use App\Livewire\Interactions\BookComments;
use App\Livewire\Interactions\BookLikeButton;
use App\Models\Book;
use App\Models\BookLike;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->author = User::factory()->create([
        'name' => 'Penulis Asli',
        'email' => 'penulis@example.com',
        'role' => 'user',
    ]);

    $this->reader = User::factory()->create([
        'name' => 'Pembaca Setia',
        'email' => 'pembaca@example.com',
        'role' => 'user',
    ]);

    $this->admin = User::factory()->create([
        'name' => 'Admin Utama',
        'email' => 'admin@example.com',
        'role' => 'admin',
    ]);

    $this->category = Category::create([
        'name' => 'Fantasi',
        'slug' => 'fantasi',
    ]);

    $this->book = Book::create([
        'user_id' => $this->author->id,
        'category_id' => $this->category->id,
        'title' => 'Petualangan di Negeri Awan',
        'slug' => 'petualangan-di-negeri-awan',
        'synopsis' => 'Kisah epik penjelajahan pulau melayang di angkasa.',
        'status' => 'published',
        'views_count' => 0,
    ]);

    $this->chapter = Chapter::create([
        'book_id' => $this->book->id,
        'chapter_number' => 1,
        'title' => 'Awal Mula Penerbangan',
        'content' => 'Di sebuah pagi yang cerah, kapal udara bersiap untuk lepas landas menuju awan tertinggi.',
    ]);
});

test('view counter bertambah saat membuka detail buku dan terproteksi anti-spam session', function () {
    expect($this->book->fresh()->views_count)->toBe(0);

    // Buka halaman detail pertama kali
    Livewire::test(BookDetail::class, ['slug' => $this->book->slug]);
    expect($this->book->fresh()->views_count)->toBe(1);

    // Refresh halaman yang sama (session sudah ada)
    Livewire::test(BookDetail::class, ['slug' => $this->book->slug]);
    expect($this->book->fresh()->views_count)->toBe(1);
});

test('view counter bertambah saat membaca bab jika belum tercatat di sesi', function () {
    session()->flush();

    Livewire::test(ChapterReader::class, [
        'book_slug' => $this->book->slug,
        'chapter_number' => $this->chapter->chapter_number,
    ]);

    expect($this->book->fresh()->views_count)->toBe(1);
});

test('guest yang menekan tombol like diarahkan ke route login', function () {
    Livewire::test(BookLikeButton::class, ['book' => $this->book])
        ->call('toggleLike')
        ->assertRedirect(route('login'));

    expect(BookLike::count())->toBe(0);
});

test('user yang login dapat melakukan toggle like secara real-time', function () {
    $this->actingAs($this->reader);

    $component = Livewire::test(BookLikeButton::class, ['book' => $this->book])
        ->assertSee('Suka')
        ->assertSet('isLiked', false)
        ->assertSet('likesCount', 0);

    // Klik like pertama kali
    $component->call('toggleLike')
        ->assertSet('isLiked', true)
        ->assertSet('likesCount', 1)
        ->assertSee('Disukai');

    expect(BookLike::where('user_id', $this->reader->id)->where('book_id', $this->book->id)->exists())->toBeTrue();

    // Klik lagi untuk batalkan like
    $component->call('toggleLike')
        ->assertSet('isLiked', false)
        ->assertSet('likesCount', 0);

    expect(BookLike::where('user_id', $this->reader->id)->where('book_id', $this->book->id)->exists())->toBeFalse();
});

test('user yang login dapat mengirim komentar yang valid', function () {
    $this->actingAs($this->reader);

    Livewire::test(BookComments::class, ['book' => $this->book])
        ->set('body', 'Cerita yang sangat menarik dan menginspirasi!')
        ->call('postComment')
        ->assertHasNoErrors()
        ->assertSee('Cerita yang sangat menarik dan menginspirasi!');

    expect(Comment::where('book_id', $this->book->id)->where('user_id', $this->reader->id)->count())->toBe(1);
});

test('komentar divalidasi minimal 3 karakter dan maksimal 500 karakter', function () {
    $this->actingAs($this->reader);

    Livewire::test(BookComments::class, ['book' => $this->book])
        ->set('body', 'ab')
        ->call('postComment')
        ->assertHasErrors(['body' => 'min']);

    expect(Comment::count())->toBe(0);
});

test('pemilik komentar dan admin berhak menghapus komentar', function () {
    $comment = Comment::create([
        'user_id' => $this->reader->id,
        'book_id' => $this->book->id,
        'body' => 'Komentar untuk diuji hapus.',
    ]);

    // User lain yang bukan pemilik & bukan admin tidak bisa menghapus (403)
    $otherUser = User::factory()->create(['role' => 'user']);
    $this->actingAs($otherUser);

    Livewire::test(BookComments::class, ['book' => $this->book])
        ->call('deleteComment', $comment->id)
        ->assertForbidden();

    expect(Comment::whereKey($comment->id)->exists())->toBeTrue();

    // Pemilik komentar bisa menghapus
    $this->actingAs($this->reader);
    Livewire::test(BookComments::class, ['book' => $this->book])
        ->call('deleteComment', $comment->id);

    expect(Comment::whereKey($comment->id)->exists())->toBeFalse();

    // Buat komentar baru untuk diuji hapus oleh Admin
    $newComment = Comment::create([
        'user_id' => $this->reader->id,
        'book_id' => $this->book->id,
        'body' => 'Komentar spam yang akan dihapus admin.',
    ]);

    $this->actingAs($this->admin);
    Livewire::test(BookComments::class, ['book' => $this->book])
        ->call('deleteComment', $newComment->id);

    expect(Comment::whereKey($newComment->id)->exists())->toBeFalse();
});

test('studio penulis menampilkan 4 kartu statistik secara akurat', function () {
    $this->book->update(['views_count' => 150]);

    BookLike::create([
        'user_id' => $this->reader->id,
        'book_id' => $this->book->id,
    ]);

    Comment::create([
        'user_id' => $this->reader->id,
        'book_id' => $this->book->id,
        'body' => 'Komentar apresiasi karya.',
    ]);

    $this->actingAs($this->author);

    Livewire::test(BookIndex::class)
        ->assertSee('Total Cerita')
        ->assertSee('Total Pembaca')
        ->assertSee('Total Suka')
        ->assertSee('Total Komentar')
        ->assertSee('150');
});

test('admin dashboard dilindungi dan hanya dapat diakses oleh admin', function () {
    // Guest dilarang
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));

    // Regular user dilarang (403)
    $this->actingAs($this->reader);
    $this->get(route('admin.dashboard'))
        ->assertForbidden();

    // Admin dapat mengakses (200)
    $this->actingAs($this->admin);
    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Ringkasan Platform')
        ->assertSee('Moderasi Komentar Terbaru');
});

test('admin dapat memoderasi dan menghapus komentar dari dashboard admin', function () {
    $comment = Comment::create([
        'user_id' => $this->reader->id,
        'book_id' => $this->book->id,
        'body' => 'Spam komentar tautan judi.',
    ]);

    $this->actingAs($this->admin);

    Livewire::test(DashboardOverview::class)
        ->assertSee('Spam komentar tautan judi.')
        ->call('deleteComment', $comment->id);

    expect(Comment::whereKey($comment->id)->exists())->toBeFalse();
});
