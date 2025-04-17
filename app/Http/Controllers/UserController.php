<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Cargar todos los usuarios con sus roles y el estado activo
        $users = User::with('roles')->paginate(10);
        
        return view('users.index', compact('users'));
    }
    
    public function create()
    {
        $roles = Role::all(); // Obtén todos los roles disponibles
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'usuario' => $request->usuario,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Usuario creado con éxito');
    }
}
