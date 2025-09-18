<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /** GET /login */
    public function showLoginForm()
    {
        // View belum kita buat. Sementara return JSON supaya route bisa dites.
        return view('auth.login');
    }

    /** POST /login */
    public function login(Request $request)
    {
        $data = $request->validate([
            'login'    => ['required','string','max:255'], // email ATAU username
            'password' => ['required','string','min:6'],
            'remember' => ['sometimes','boolean'],
        ]);

        $login = $data['login'];
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field    => $login,
            'password'=> $data['password'],
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => 'Kredensial tidak cocok.',
            ]);
        }

        $request->session()->regenerate();

        // Arahkan ke intended atau dashboard admin
        return redirect()->intended(route('admin.dashboard'));
    }

    /** POST /logout */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
