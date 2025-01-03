<?php
session_start();
require "vendor/autoload.php";

use eftec\bladeone\BladeOne;

$views = __DIR__ . '\views'; // it uses the folder /views to read the templates
$cache = __DIR__ . '\cache'; // it uses the folder /cache to compile the result. 

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);
$boundsError = "";

if (empty($_POST)) {// Si primer acceso a la aplicación
    echo $blade->run('bounds');
}else if(filter_input(INPUT_POST, "boundsbutton")) {

    $lowerBound = filter_input(INPUT_POST,"lowerBound");
    $upperBound = filter_input(INPUT_POST,"upperBound");
    $tries = filter_input(INPUT_POST,"tries");

    if ($upperBound <= $lowerBound) {
        $boundsError = "Upper bound must be higher than lower bound";
    } else {
        $boundsError = false;
    }
    
    if (!$lowerBound || !$upperBound || !$tries || $boundsError) {
        echo $blade->run("bounds", [ "lowerBound" => $lowerBound , "upperBound" => $upperBound, "tries" => $tries, "boundsError" => $boundsError ]);
    }else {
        $_SESSION =  [ "lowerBound" => $lowerBound , "upperBound" => $upperBound, "tries" => $tries, "boundsError" => $boundsError, "number" => random_int($lowerBound, $upperBound)];
        echo $blade->run('guess', [ "lowerBound" => $lowerBound , "upperBound" => $upperBound, "tries" => $tries, "boundsError" => $boundsError , "number" => false]);
    }
} else if(filter_input(INPUT_POST, "guessbutton")){
    $lowerBound = $_SESSION["lowerBound"];
    $upperBound = $_SESSION["upperBound"];
    $tries = $_SESSION["tries"];
    $number = $_SESSION["number"];

    $guess = filter_input(INPUT_POST,"guess");

    if ($guess == $number) {
        echo $blade->run('endgame', [ "mensaje" => "You win", "number" => $number]);

    }else {
        $tries--;
        if($tries > 0){
            $_SESSION["tries"] = $tries;
            if($guess < $number) $mensaje = "The number is higher";
            else $mensaje = "The number is lower";
            echo $blade->run('guess', [ "lowerBound" => $lowerBound , "upperBound" => $upperBound, "tries" => $tries, "boundsError" => $boundsError, "guess" => $guess, "mensaje"=> $mensaje]);
        }else {
            echo $blade->run('endgame', [ "mensaje" => "You loose", "number" => $number]);
        }
    }

}else if(filter_input(INPUT_POST, "endgamebutton")) {
    session_destroy();
    echo $blade->run("bounds");

}

?>