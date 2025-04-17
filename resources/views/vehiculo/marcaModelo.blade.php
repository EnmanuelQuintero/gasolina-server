@extends('layouts.dash')

@section('content')

<div class="grid md:grid-cols-2 grid-cols-1 gap-8">
    <div class="w-full flex justify-center items-center">
        @include('vehiculo.partials.modalCrear')
    </div>

    <div class="w-full flex justify-center items-center">
        @include('vehiculo.partials.modalCrearVehiculo')
    </div>
</div>

<div class="mt-10">
    @include('vehiculo.partials.tabla')
</div>


@endsection

