@extends('app')
@section('title', 'Form to enter bounds for guess a number Game')
@section('content')
<form class="form-font" name="form_bounds" 
      action="index.php" method="POST">
    <div class="form-section">
        <table class="final-table-section">
            <thead>
                <tr>
                    <th>Equipo</th>
                    <th>Puntuación</th>
                    <th>Goles Metidos</th>
                    <th>Goles Encajados</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                    <tr>
                        <td>{{$team}}</td>
                        <td>{{$score[$team]["points"]}}</td>
                        <td>{{$score[$team]["goals"]}}</td>
                        <td>{{$score[$team]["rivalGoals"]}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>       
    </div>
    <div class="submit-section-2">
        <input type="submit" 
               value="Enviar" name="finalButton" />
        </div>
</form>   
@endSection