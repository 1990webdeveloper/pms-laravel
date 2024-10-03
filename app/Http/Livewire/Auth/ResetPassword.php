<?php

namespace App\Http\Livewire\Auth;

use App\Models\Pms\PmsUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ResetPassword extends Component
{
    public $password;
    public $token;
    public $password_confirmation;

    public function mount()
    {
        $this->token  = request()->token;
    }

    /**
     * Handle a password reset request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitResetPasswordForm()
    {
        $this->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        try {
            $updatePassword = DB::table('password_reset_tokens')
                ->where(['token' => $this->token])
                ->first();

            if (!$updatePassword) {
                return back()->withInput()->with('error', trans('passwords.token'));
            }

            PmsUser::where('email', $updatePassword->email)->update(['password' => Hash::make($this->password)]);
            DB::table('password_reset_tokens')->where(['email' => $updatePassword->email])->delete();

            return redirect('/login')->with('success', trans('passwords.reset'));
        } catch (\Exception $e) {
            return redirect('/login')->with('error', "Password has been not reset!!");
        }
    }

    /**
     * Render the component's view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.auth.reset-password')->layout('layouts.auth');
    }
}
