@extends('app')
@section('title', 'Introduzca las ciudades')
@section('content')
<form class="form-font" name="form_bounds" 
      action="index.php" method="POST">
    <div class="form-section">
        <label for="lowerbound">Ciudades:</Label>
        <textarea required name="cities" >{{$cities}}</textarea>
    </div>
    <div class="form-section">
        <span class="error">{{$error}}</textarea>
    </div>
    <div class="submit-section-2">
        <input type="submit" 
               value="Enviar" name="citiesbutton" /> 
    </div>
</form>   
@endSection