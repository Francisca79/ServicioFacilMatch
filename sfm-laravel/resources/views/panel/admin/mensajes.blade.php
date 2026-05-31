@extends('layouts.panel')

@section('title', 'Mensajes — Admin')

@section('content')
<h1 class="text-3xl font-bold mb-2">Mensajería</h1>
<p class="text-gray-600 mb-8">Advertencias enviadas y mensajes del sistema.</p>
@include('partials.mensajes-list', ['mensajes' => $mensajes])
@endsection
