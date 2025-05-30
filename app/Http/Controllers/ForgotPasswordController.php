<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    // Show the forgot password form
    public function show()
    {
        return view('auth.forgot-password');
    }

    // Handle the form submission
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Normally, here you would send the reset link via Laravel's Password facade.
        // But to simulate, just pass the submitted email back with a success flag.

        return back()->with([
            'submitted' => true,
            'email' => $request->email,
        ]);
    }
}