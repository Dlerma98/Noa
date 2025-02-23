<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para ver esta página.');
        }
        // Obtener todos los usuarios con rol "lector" y "redactor" (Uso whereHas dado que con rol solo podria escoger 1 solo rol)
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['lector', 'redactor']);
        })->get();

        return view('admin.dashboard', compact('users'));
    }

    public function makeRedactor(User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        if ($user->id === auth()->id()) {
            abort(403, 'No puedes cambiar tu propio rol.');
        }
        if ($user->hasRole('lector')) {
            $user->removeRole('lector');
            $user->assignRole('redactor');
        }
        return redirect()->route('admin.dashboard')->with('status', 'Usuario ahora es Redactor.');
    }

    public function makeLector(User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        if ($user->id === auth()->id()) {
            abort(403, 'No puedes cambiar tu propio rol.');
        }
     if($user->hasRole('redactor')) {
        $user->removeRole('redactor');
        $user->assignRole('lector');
    }
        return redirect()->route('admin.dashboard')->with('status', 'Usuario ahora es Lector.');
    }
}
