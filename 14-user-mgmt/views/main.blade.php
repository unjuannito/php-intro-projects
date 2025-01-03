@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')
<header>
    <h2>User MGMT</h2>
    <form id="menuForm" class="menuForm" action="index.php" method="POST">
        <select id="nav" name="nav">
            <option id="ocultar" selected value="-1">Usuario</option>
            <option value="1">Perfil</option>
            <option value="2">Logout</option>
            <option value="3">Baja</option>
        </select>
    </form>
</header>

<h1>Bienvenido {{$userName}}</h1>
    <div class="imgs">
    @foreach ($favouritePaintings as $painting)
    <a href="index.php?img={{$painting['id']}}">
        <h3>{{$painting["title"]}}</h3>
        <img src="/public/assets/img/{{$painting['img']}}" alt="{{$painting['img']}}">
    </a>
    @endforeach
    </div>
<script>

    Array.from(document.getElementById("nav").children).forEach(option => {
        option.addEventListener("click", ()=>{
            document.getElementById("menuForm").submit();
        });
    })
</script>
@endSection