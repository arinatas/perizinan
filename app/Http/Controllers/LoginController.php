<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{
    public function index() 
    {
        return view('login.index', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // using bcrypt
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Mengambil pengguna yang saat ini masuk
            $user = Auth::user();

            // Memeriksa apakah pengguna aktif
            if ($user->is_aktif == 1) {
                // Memeriksa apakah pengguna adalah admin
                if ($user->is_admin == 1) {
                    return redirect()->intended('/adminDashboard'); // Pengguna adalah admin
                } else {
                    return redirect()->intended('/userDashboard'); // Pengguna bukan admin
                }
            } else {
                Auth::logout(); // Logout jika pengguna tidak aktif
                return back()->with('loginError', 'Akun nonaktif.')->withInput();
            }
        }

        return back()->with('loginError', 'Login Failed.')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
}
