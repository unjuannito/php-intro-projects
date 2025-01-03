@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')
<header>
    <h2>User MGMT</h2>
    <form id="menuForm" class="menuForm" action="index.php" method="POST">
            <select id="nav" name="nav">
            <option value="-1">Usuario</option>
            <option value="1">Perfil</option>
            <option id="ocultar" selected value="2">Logout</option>
            <option value="3">Baja</option>
        </select>
    </form>
</header>

<form class="logoutForm" action="index.php" method="POST">
    <label for="logout">Quieres salir?</label>
    <input type="submit" name="submitButton" value="Cerrar sesión">
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