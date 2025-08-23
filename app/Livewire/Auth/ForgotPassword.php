<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Models\Staff;
use App\Models\Franchise;
use App\Models\Receptioners;
use Illuminate\Support\Str;

class ForgotPassword extends Component
{
    public $email;
    public $message = '';
    public $error = '';

    protected $rules = [
        'email' => 'required|email',
    ];

    public function sendResetLink()
    {
        $this->validate();
        $this->error = '';
        $this->message = '';

        // Check if email exists in any of the user tables
        $user = $this->findUserByEmail($this->email);

        if (!$user) {
            $this->error = "We can't find a user with that email address.";
            return;
        }

        // Generate a simple reset token (not stored in database)
        $token = Str::random(60);

        // Store token in session (temporary storage)
        session()->put('password_reset_' . $this->email, [
            'token' => $token,
            'created_at' => now()->timestamp
        ]);

        try {
            // Send reset password email
            Mail::to($this->email)->send(new ResetPasswordMail($token, $this->email));

            $this->message = 'We have emailed your password reset link!';
        } catch (\Exception $e) {
            $this->error = 'Failed to send reset email. Please try again later.';
        }
    }

    private function findUserByEmail($email)
    {
        // Check all user tables
        if (User::where('email', $email)->exists()) {
            return User::where('email', $email)->first();
        }

        if (Staff::where('email', $email)->exists()) {
            return Staff::where('email', $email)->first();
        }

        if (Franchise::where('email', $email)->exists()) {
            return Franchise::where('email', $email)->first();
        }

        if (Receptioners::where('email', $email)->exists()) {
            return Receptioners::where('email', $email)->first();
        }

        return null;
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
