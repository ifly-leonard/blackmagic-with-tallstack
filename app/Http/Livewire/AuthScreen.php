<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class AuthScreen extends Component
{
    public $screens = [
        'login',
        'register',
    ];

    public $activeScreen = '';

    public $loginCreds = [];



    public function mount() {
        $this->activeScreen = $this->screens[0];
    }

    public function attemptLogin() {
        $this->activeScreen = $this->screens[1];

    }

    public function render()
    {
        return view('livewire.auth-screen');
    }
}
