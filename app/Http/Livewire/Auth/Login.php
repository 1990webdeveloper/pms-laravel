<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    /**
     * Handle the login form submission.
     *
     * @return void
     */
    public function loginSubmit()
    {
        $this->validate([
            'email' => 'required|string|email:rfc,dns',
            'password' => 'required|string|min:6',
        ]);
        if (tenant('id')) {
            $this->userLogin();
        } else {
            $this->adminLogin();
        }
    }

    /**
     * Handle the login process for admin users.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminLogin()
    {
        if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->intended(route('user.dashboard'))->with('success', 'Login successfully');
        }
        return redirect()->route('login')->with('error', trans('auth.failed'));
    }

    /**
     * Handle the login process for tenant (user) login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userLogin()
    {
        if (auth()->guard('pms_user')->attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->intended(route('user.dashboard'))->with('success', 'Login successfully');
        }
        return redirect()->route('login')->with('error', trans('auth.failed'));
    }

    /**
     * Render the component's view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth');
    }
}
