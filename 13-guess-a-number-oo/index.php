<?php
session_start();
require "vendor/autoload.php";
require "GuessANumber.php";

use eftec\bladeone\BladeOne;

$views = __DIR__ . '\views'; // it uses the folder /views to read the templates
$cache = __DIR__ . '\cache'; // it uses the folder /cache to compile the result. 

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

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
        $guessANumber = new GuessANumber($lowerBound, $upperBound, $tries); 
        echo $blade->run('guess', [ "lowerBound" => $lowerBound , "upperBound" => $upperBound, "tries" => $tries, "boundsError" => $boundsError , "number" => false]);
        $_SESSION =  [ "guessANumber" => serialize($guessANumber)];
    }
} else if(filter_input(INPUT_POST, "guessbutton")){
    $guessANumber = unserialize($_SESSION["guessANumber"]);

    $guess = filter_input(INPUT_POST,"guess");

    $gamesRess = $guessANumber->gameRes($guess);
    if ($gamesRess[0] == 1) {
        echo $blade->run('endgame', [ "mensaje" => "You win", "number" => $guessANumber->getNumber()]);

    }else if($gamesRess[0] == -1){
        echo $blade->run('endgame', [ "mensaje" => "You loose", "number" => $guessANumber->getNumber()]);
    }else if($gamesRess[0] == 0){
        echo $blade->run('guess', [ "lowerBound" => $guessANumber->getMinNumber() , "upperBound" => $guessANumber->getMaxNumber(), "tries" => $guessANumber->getLeftTries(), "guess" => $guess, "mensaje"=> $gamesRess[1]]);
    }
    $_SESSION =  [ "guessANumber" => serialize($guessANumber)];

}else if(filter_input(INPUT_POST, "endgamebutton")) {
    session_destroy();
    echo $blade->run("bounds");
}
?>