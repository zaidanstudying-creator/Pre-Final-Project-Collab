<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();

            // Cek apakah user yang login adalah admin
            if (auth()->user()->role === 'admin') {
                return $this->redirect('/admin/moderation', navigate: true);
            }

            // Jika user/penulis biasa, arahkan ke Katalog Pembaca
            return $this->redirect('/', navigate: true);
        }

        $this->addError('email', 'Kredensial yang diberikan tidak cocok dengan data kami.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.app');
    }
}
