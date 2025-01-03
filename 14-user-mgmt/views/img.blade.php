@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')
    <form class="imgForm" action="index.php" method="POST">
        <div class="imgContainer">
            <h1>{{$painting["title"]}}</h1>
            <img src="/public/assets/img/{{$painting['img']}}" alt="{{$painting['img']}}">
        </div>
        <div class="imgInfo">
            <p>{{$painting['description']}}</p>
            <span>Periodo: {{$painting['period']}}</span>
            <span>Tecnica: {{$painting['technique']}}</span>
            <span>Año: {{$painting['year']}}</span>
            <input class="submit" type="submit" name="submitButton" value="Volver al inicio">
        </div>
    </form>
<script>
    Array.from(document.getElementById("nav").children).forEach(option => {
        option.addEventListener("click", ()=>{
            document.getElementById("mainForm").submit();
        });
    })
    
</script>
@endSection