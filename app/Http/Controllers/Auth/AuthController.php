<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Maneja el inicio de sesión de los usuarios.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        $credentials = $request->only('usuario', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Asegúrate de que el usuario tenga roles asignados
            if ($user->roles->isNotEmpty()) {
                $role = $user->roles->first()->name; // Obtener el primer rol del usuario
                
                // Redirigir según el rol
                switch ($role) {
                    case 'super_admin':
                        return redirect()->intended('/dashboard');
                    case 'admin':
                        return redirect()->intended('/dashboard');
                    case 'operador':
                        return redirect()->intended('/dashboard');
                    case 'usuario':
                        return redirect()->intended('/user/home');
                    default:
                        Auth::logout();
                        return redirect('/')->withErrors(['usuario' => 'Rol de usuario desconocido.']);
                }
            } else {
                // Si el usuario no tiene roles, redirigir a una página por defecto
                Auth::logout();
                return redirect('/')->withErrors(['usuario' => 'El usuario no tiene roles asignados.']);
            }
        }

        // Verificar si el nombre de usuario existe en la base de datos
        $usuarioExiste = User::where('usuario', $request->usuario)->exists();

        if (!$usuarioExiste) {
            return redirect()->back()->withInput()->withErrors(['usuario' => 'El usuario ingresado es incorrecto.']);
        }

        // Autenticación fallida con notificación de error
        return redirect()->back()->withInput()->withErrors(['password' => 'La contraseña ingresada es incorrecta.']);
    }

    /**
     * Maneja el cierre de sesión del usuario.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Invalidar todas las sesiones del usuario
        DB::table('sessions')->where('user_id', Auth::user()->id)->delete();

        // Cerrar sesión
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
