@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('h1', 'Ha ocurrido un error')
@section('content')
<p>
    {{$error}}<br>
    Para mas informacion consuelte el codigo de error {{$errorCode}} de PDO.
</p> 
@endSection