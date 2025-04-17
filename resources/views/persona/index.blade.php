@extends('layouts.dash')

@section('content')

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