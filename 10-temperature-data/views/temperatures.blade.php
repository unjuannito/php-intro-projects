@extends('app')
@section('title', 'Informacion de las temperaturas')
@section('content')
<form class="form-font" name="form_bounds" 
      action="index.php" method="POST">
    <div class="form-section">
        <table class="final-table-section">
            <thead>
                <tr>
                    <th>Ciudad</th>
                    <th>Mínima</th>
                    <th>Máxima</th>
                    <th>Media</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($temperaturesYearly as $temp)
                    <tr>
                        <td>{{$temp['city']}}</td>
                        <td>{{$temp['min']}}</td>
                        <td>{{$temp['max']}}</td>
                        <td>{{$temp['media']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>       
    </div>
    <div class="submit-section-2">
        <input type="submit" 
               value="Enviar" name="finalbutton" />
        </div>
</form>   
@endSection