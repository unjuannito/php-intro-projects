@extends('app')
@section('title', 'Introduzca como acaboron los partidos')
@section('content')
<form class="form-font" name="form_bounds" 
      action="index.php" method="POST">
    <div class="form-section">
        @foreach ($teams as $team)
        <table class="table-section">
            <thead>
                <tr>
                    <th>Partidos en la casa del {{$team}}</th>
                    </tr>
            </thead>
            <tbody>
                @foreach ($matchs[$team] as $match)
                    <tr>
                        <td>
                            {{$team}} - {{$match["rivalTeam"]}}
                        </td>
                        <td>
                            <input required type="number" name="matchs[{{$team}}][{{$match['rivalTeam']}}][score]" value="{{$match['score']}}"> -
                            <input required type="number" name="matchs[{{$team}}][{{$match['rivalTeam']}}][rivalScore]" value="{{$match['rivalScore']}}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        @endforeach
    </div>
    <div class="submit-section">
        <input type="submit" 
               value="Enviar" name="generateButton" />
    </div>

</form>   
@endSection