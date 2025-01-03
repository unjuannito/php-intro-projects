@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')
<form id="registerForm" class="registerForm" action="index.php" method="POST">

    <div class="formSection">
        <label for="lowerbound">User Name:</Label> 
        <input autofocus id="userName" type="text" name="userName" value="{{$userName}}"/>
        <span>{{$requireds[0]}}</span>
        <label for="email">Email:</Label> 
        <input id="email" type="email" name="email" value="{{$email}}"/>
        <span>{{$requireds[2]}}</span> 
        <label for="password">Password:</Label> 
        <input id="password" type="password" name="password" value="{{$password}}"/>
        <span>{{$requireds[1]}}</span>
        <label for="pintor">Pintor:</Label>
        <select name="pintor" id="pintor">
            @foreach ($painters as $painter)
                <option value="{{$painter['id']}}" {{$pintorSelected[$painter['id']]}}>{{$painter['name']}}</option> 
            @endforeach
        </select>
        <span>{{$requireds[3]}}</span>
        <span>{{$error}}</span>
    </div>
    
    <input class="submitInput" type="submit" value="Register" name="submitButton"/>    
    
    <div class="upSection">
        <span>User Mgmt</span>
        <input class="goTo" type="submit" value="Go to login" id="goLogin" name="submitButton"/>
    </div>
    
</form>
@endSection