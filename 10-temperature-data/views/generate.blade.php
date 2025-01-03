@extends('app')
@section('title', 'Introduzca las temperaturas')
@section('content')
<form class="form-font" name="form_bounds" 
      action="index.php" method="POST">
    <div class="form-section">
        @foreach ($cities as $city)
        <table class="table-section">
            <thead>
                <tr>
                    <th>{{$city}}</th>
                    <th>Mínima</th>
                    <th>Máxima</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($months as $month)
                    <tr>
                        <td>{{ $month }}</td>
                        <td><input required type="number" name="temperatures[{{$city}}][{{$month}}][min]" value="{{$temperatures[$city][$month]['min']}}"></td>
                        <td><input required type="number" name="temperatures[{{$city}}][{{$month}}][max]" value="{{$temperatures[$city][$month]['max']}}"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        @endforeach
    </div>
    <div class="submit-section">
        <input type="submit" 
               value="Enviar" name="generatebutton" />
    </div>

</form>   
@endSection