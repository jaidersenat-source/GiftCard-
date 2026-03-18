<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller {

    public function create() {
        // Si ya está logueado como admin, redirigir directo
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.products.index');
        }
        return view('auth.login');
    }

    public function store(Request $request) {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Las credenciales no son correctas.',
            ])->onlyInput('email');
        }

        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'No tienes permisos de administrador.',
            ]);
        }

        $request->session()->regenerate();
        return redirect()->intended(route('admin.products.index'));
    }

    public function destroy(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}