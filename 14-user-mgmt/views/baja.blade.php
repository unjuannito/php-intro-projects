@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')
<header>
    <h2>User MGMT</h2>
    <form id="menuForm" class="menuForm" action="index.php" method="POST">
        <select id="nav" name="nav">
        <option value="-1">Usuario</option>
        <option value="1">Perfil</option>
        <option value="2">Logout</option>
        <option id="ocultar" selected value="3">Baja</option>
        </select>
    </form>
</header>

<form id="bajaForm" class="bajaForm" action="index.php" method="POST">
    <h2 for="logout">Quieres eliminar tu cuenta?</h2>
    <div class="bajaSection">
        <label for="password"> Introduzca la Contraseña</label><input name="password" type="text">
        <span>{{$error}}</span>
    </div>
    <input type="submit" name="submitButton" value="Eliminar cuenta">
    <input type="submit" name="submitButton" value="Volver al inicio">

</form>
<script>
    Array.from(document.getElementById("nav").children).forEach(option => {
        option.addEventListener("click", ()=>{
            document.getElementById("menuForm").submit();
        });
    }) 
</script>

@endSection