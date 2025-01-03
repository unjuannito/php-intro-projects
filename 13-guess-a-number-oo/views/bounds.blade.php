@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')
<form class="form-font" name="form_bounds" 
      action="index.php" method="POST">
    <div class="form-section">
        <label for="lowerbound">Lower bound:</Label> 
        <input autofocus id="lowerbound" type="number"  required name="lowerBound" min="1" value="{{$lowerBound}}"/> 
    </div>
    <div class="form-section">
        <label for="upperbound">Upper bound:</Label> 
        <input id="upperbound" type="number"  required name="upperBound" min="1" value="{{$upperBound}}"/> 
    </div>
    <div class="form-section">
        <label for="tries">Tries:</Label> 
        <input id="upperbound" type="number"  required name="tries" min="1" value="{{$tries}}"/> 
    </div>
    <span class="info-section">{{$boundsError}}</span>
    <div class="submit-section-2">
        <input type="submit" 
               value="Send" name="boundsbutton" /> 
    </div>
</form>   
@endSection