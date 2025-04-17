@extends('layouts.app')

@section('content')

<div class="flex items-center justify-center h-screen bg-cover bg-center " style="background-image: url({{ asset('images/gasolinera.jpeg') }}); backdrop-filter: blur(20px); ">
    <div class="w-full max-w-sm p-4 bg-blue-300 border border-gray-200 rounded-lg shadow-md sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 bg-opacity-90 backdrop-blur-sm">
        <h2 class="mb-6 text-xl font-medium text-gray-900 dark:text-white text-center">Iniciar Sesión</h2>

        @if($errors->any())
            <div class="mb-4 p-2 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ url('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="usuario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usuario:</label>
                <input type="text" name="usuario" id="usuario" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="{{ old('usuario') }}" required>
                @error('usuario')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña:</label>
                <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Iniciar Sesión</button>
        </form>
    </div>
</div>

@endsection
