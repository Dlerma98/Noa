<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Obtener todos los usuarios con rol "lector"
        $users = User::role('lector')->get();
        return view('admin.dashboard', compact('users'));
    }

    public function makeRedactor(User $user)
    {
        if ($user->hasRole('lector')) {
            $user->removeRole('lector');
            $user->assignRole('redactor');
        }

        return redirect()->route('admin.dashboard')->with('success', 'Usuario ahora es Redactor.');
    }
}
