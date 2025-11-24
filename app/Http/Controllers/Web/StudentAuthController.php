<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StudentAuthController extends Controller
{
    /**
     * Mostrar formulario de login para estudiantes
     */
    public function showLoginForm()
    {
        return Inertia::render('student/Login');
    }

    /**
     * Procesar login de estudiantes
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Autenticación para estudiantes
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            
            // Verificación temporal sin role - solo autenticación exitosa
            $request->session()->regenerate();
            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Mostrar formulario de registro para estudiantes
     */
    public function showRegisterForm()
    {
        return Inertia::render('student/Register');
    }

    /**
     * Procesar registro de estudiantes
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|string|unique:users,dni|max:8',
            'nacimiento' => 'required|date|before:today',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear usuario SIN role por ahora (para evitar error 500)
        $user = User::create([
            'name' => $request->name,
            'apellidos' => $request->apellidos,
            'dni' => $request->dni,
            'nacimiento' => $request->nacimiento,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'restablecimiento' => 1,
        ]);

        // Auto-login después del registro
        Auth::login($user);

        // Usar Inertia location para correcta navegación
        return Inertia::location('/student/dashboard');
    }

    /**
     * Logout para estudiantes
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
