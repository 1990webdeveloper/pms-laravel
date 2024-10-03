<?php

namespace App\Http\Livewire\Auth;

use App\Mail\ForgotPasswordEmail;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPassword extends Component
{
    public $email;

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail()
    {
        $this->validate([
            'email' => 'required|string|email:rfc,dns|exists:pms_user,email',
        ], [
            'email.exists' => 'The email could not found in our system. Please check your email address and try again.'
        ]);
        try {
            $token = Str::random(64);

            DB::table('password_reset_tokens')->where(['email' => $this->email])->delete();

            DB::table('password_reset_tokens')->insert([
                'email' => $this->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::to($this->email)->send(new ForgotPasswordEmail($token));

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => "We have emailed your password reset link."
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => "Something wen wrong while sending password reset link."
            ]);
        }
    }

    /**
     * Render the component's view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('layouts.auth');
    }
}
