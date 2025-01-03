<?php
session_start();
require "vendor/autoload.php";

use eftec\bladeone\BladeOne;

$views = __DIR__ . '\views'; // it uses the folder /views to read the templates
$cache = __DIR__ . '\cache'; // it uses the folder /cache to compile the result. 

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);
$boundsError = "";

$months = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre ", "Diciembre"];


if (empty($_POST) || filter_input(INPUT_POST, "finalbutton")) {// Si primer acceso a la aplicación
    echo $blade->run('cities');
}else if(filter_input(INPUT_POST, "citiesbutton")) {
    $cities = filter_input(INPUT_POST,"cities");
    if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+(, [a-zA-ZñÑáéíóúÁÉÍÓÚ]+)*$/', $cities)) {
        echo $blade->run("cities", [ "cities" => $cities, "error" => "Campo ciudades incorrecto" ]);
        }else {
        $cities = explode(", ", $cities);
        foreach ($cities as $city) {
            foreach ($months as $month) {
                $temperatures[$city][$month] = [
                    "min" => random_int(-15, 15),
                    "max" => random_int(15, 45)
                ];
            }
        }
        echo $blade->run("generate", [ "cities" => $cities, "months" => $months, "temperatures" => $temperatures ] );

    }
}else if (filter_input(INPUT_POST,"generatebutton")) {

    $temperatures = filter_input(INPUT_POST,"temperatures", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    $temperaturesYearly = [];
    foreach($temperatures as $cities => $months) {
        $max = max(array_column($months, "max"));
        $min = min(array_column($months, "min"));
        $media = ((array_sum(array_column($months, "max")) + array_sum(array_column($months,"min")))/(count(array_column($months,"max")) + count(array_column($months,"min"))));
        
        $max = number_format($max, 2);
        $min = number_format($min, 2);
        $media = number_format($media, 2);
        
        array_push($temperaturesYearly, ["city" => $cities, "max" => $max,"min"=> $min,"media"=> $media ]);

        
    }

    $maxTemperatures = array_column($temperaturesYearly, 'max');
    $minTemperatures = array_column($temperaturesYearly, 'min');
    $cityNames = array_column($temperaturesYearly, 'city');

    array_multisort($maxTemperatures, SORT_DESC, $minTemperatures, SORT_ASC, $cityNames, SORT_ASC, $temperaturesYearly);

    echo $blade->run("temperatures", ["temperaturesYearly" => $temperaturesYearly]);
}

?>