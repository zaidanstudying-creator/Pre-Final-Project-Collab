<?php

namespace App\Livewire\Layout;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public function logout()
    {
        Auth::guard('web')->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.layout.sidebar');
    }
}
