@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')
<header>
    <h2>User MGMT</h2>
    <form id="menuForm" class="menuForm" action="index.php" method="POST">
        <select id="nav" name="nav">
            <option value="-1">Usuario</option>
            <option id="ocultar" selected value="1">Perfil</option>
            <option value="2">Logout</option>
            <option value="3">Baja</option>
        </select>
    </form>
</header>

<h1 class="h1Perfil">Tus datos</h1>

<form class="perfilForm" acction="index.php" method="POST">
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
            @endforeach    </select>
    <span>{{$requireds[3]}}</span>

    <span class="info-section">{{$error}}</span>

    <input class="" type="submit" value="Cambiar datos" name="submitButton"/>
</form>
<script>
    Array.from(document.getElementById("nav").children).forEach(option => {
        option.addEventListener("click", ()=>{
            document.getElementById("menuForm").submit();
        });
    })
    
</script>
@endSection