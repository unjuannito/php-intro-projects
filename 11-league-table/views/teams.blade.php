@extends('app')
@section('title', 'Introduzca los equipos')
@section('content')
<form class="form-font" name="form_bounds" 
      action="index.php" method="POST">
    <div class="form-section">
        <label for="lowerbound">Equipos:</Label>
        <textarea required name="teams" >{{$teams}}</textarea>
    </div>
    <div class="form-section">
        <span class="error">{{$error}}</textarea>
    </div>
    <div class="submit-section-2">
        <input type="submit" 
               value="Enviar" name="teamsButton" /> 
    </div>
</form>   
@endSection