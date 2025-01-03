@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')
<form class="form-font" name="form_bounds" 
      action="index.php" method="POST">
    <div class="form-section">
        <h1 class="mensaje"> {{$mensaje}}</h1>
    </div>
    <div class="form-section">
        <p>The number was {{$number}}</p>
    </div>
    <div class="submit-section-2">
        <input type="submit" 
               value="Restart" name="endgamebutton" /> 
    </div>
</form>   
@endSection