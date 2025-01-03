@extends('app')
@section('title', 'Inicia sesion con google para acceder al catastro')
@section('header')
<h1>
	Iniciar sesión con Google
</h1>
@endSection
@section('content')
    <a href="{{ $authUrl }}">Iniciar sesión con Google</a>
@endSection
