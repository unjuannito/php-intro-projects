@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')

<form id="loginForm" class="loginForm" action="index.php" method="POST">

    <div class="formSection">
        <label for="lowerbound">User Name:</Label> 
        <input autofocus id="userName" type="text" name="userName" value="{{$userName}}"/>
        <span>{{$requireds[0]}}</span>
        <label for="password">Password:</Label> 
        <input id="password" type="password" name="password" value="{{$password}}"/> 
        <span>{{$requireds[1]}}</span>
        <span class="error">{{$error}}</span>
    </div>

    <input class="submitInput" type="submit" value="Login" name="submitButton"/>

    <div class="upSection">
        <span>User Mgmt</span>
        <input class="goTo" type="submit" id="submitButton" value="Go to register" name="submitButton"/>
    </div>
</form>
@endSection