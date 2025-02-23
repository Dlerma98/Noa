@extends('layouts.noa-layout')

@section('title', 'Panel de Administración')

@if(session('status'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 mx-auto w-1/2 text-center rounded-lg shadow-md">
        <p class="font-semibold">{{ session('status') }}</p>
    </div>
@endif

@section('content')
    <div class="max-w-6xl mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">Gestión de Usuarios</h2>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">ID</th>
                <th class="border p-2">Nombre</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Rol</th>
                <th class="border p-2">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="border">
                    <td class="border p-2">{{ $user->id }}</td>
                    <td class="border p-2">{{ $user->name }}</td>
                    <td class="border p-2">{{ $user->email }}</td>
                    <td class="border p-2">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                    <td class="border p-2">
                        @if ($user->hasRole('lector'))
                            <form action="{{ route('admin.makeRedactor', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                                    Convertir en Redactor
                                </button>
                            </form>
                            @elseif ($user->hasRole('redactor'))
                            <form action="{{ route('admin.makeLector', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                                    Convertir en Lector
                                </button>
                            </form>
                            @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
