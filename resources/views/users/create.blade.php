@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 text-black dark:text-white">
    <h1 class="text-2xl font-bold mb-6 text-center">Crear Usuario</h1>
    
    @if ($errors->any())
        <div class="mb-4">
            <div class="bg-red-100 text-red-700 p-4 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    
    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="flex flex-col">
            <label for="usuario" class="mb-2 font-medium text-black dark:text-white">Usuario:</label>
            <input type="text" name="usuario" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black dark:text-black" value="{{ old('usuario') }}" required>
        </div>

        <div class="flex flex-col">
            <label for="password" class="mb-2 font-medium text-black dark:text-white">Contraseña:</label>
            <input type="password" name="password" class=" dark:text-black px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transpa text-black dark:text-whiterent" required>
        </div>

        <div class="flex flex-col">
            <label for="password_confirmation" class="mb-2 font-medium text-black dark:text-white">Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation" class="dark:text-black px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transpa text-black dark:text-whiterent" required>
        </div>

        <div class="flex flex-col">
            <label for="role" class="mb-2 font-medium text-black dark:text-white">Rol:</label>
            <select name="role" class="dark:text-black px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required> text-black dark:text-white
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="w-full py-3 px-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Crear Usuario</button>
    </form>
</div>
@endsection
