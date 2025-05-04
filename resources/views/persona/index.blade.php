@extends('layouts.dash')

@section('content')
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 w-full">
        <strong class="font-bold">¡Error!</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="grid md:grid-cols-2 grid-cols-1 w-full mb-10">
    <div class="flex justify-center items-center w-full h-full">
        @include('persona.partials.modalCrearDepartamentoCargo')
    </div>

    <div class="flex justify-center items-center w-full h-full">
        @include('persona.partials.modalAgregarPersona')
    </div>
</div>



<div class="mt-10 w-full">
    @include('persona.partials.tabla')
</div>


@endsection