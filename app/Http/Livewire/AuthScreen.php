<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthScreen extends Component
{
    public $screens = [
        'login',
        'register',
    ];

    public $activeScreen = '';

    public $credentials = [];

    public $errors = '';

    /**
     * mount
     *
     * @return void
     */
    public function mount() {
        $this->activeScreen = $this->screens[0];
    }

    /**
     * clearErrors
     *
     * @return void
     */
    public function clearErrors() {
        $this->errors = '';
    }

    /**
     * checkIfUserExists
     *
     * @param  mixed $email
     * @return void
     */
    public function checkIfUserExists($email) {
        return (User::where('email', $email)->count() > 0) ? true : false;
    }

    /**
     * attemptLogin
     *
     * @return void
     */
    public function attemptLogin() {

        $creds = $this->credentials;

        $name = $creds['name'];
        $email = $creds['email'];
        $password = $creds['password'];

        if($this->activeScreen == 'login') {

            $credentials = [
                'email' => $email,
                'password' => $password,
            ];

            $user = User::where('email', $email)->first();

            if(!$user) {
                $this->errors = 'No users found with e-mail ' . $email;
            } else {
                if (Auth::attempt($credentials, remember: true)) {
                    $user = User::where('email', $email)->first();
                    request()->session()->regenerate();
                    return redirect()->route('profile');
                } else {
                    $this->errors = 'Invalid credentials. Can you double check and try again? 👀';
                }
            }


        } else if($this->activeScreen == 'register') {

            if(!$this->checkIfUserExists($email)) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt($password),
                ]);

                Auth::login($user);

                request()->session()->regenerate();
                return redirect()->route('profile');
            } else {
                $this->errors = 'An account already exists for ' . $email;
            }
        }
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.auth-screen');
    }
}
