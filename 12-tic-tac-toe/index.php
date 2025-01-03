<?php
function haGanado($comprobacion, $board, $x, $y) {
    if($comprobacion == "draw"){
        $respuesta = !in_array("", array_merge(...$board));
    }else {

        $fila = $board[$x];
        $columna = array_column($board, $y);
        if (array_unique($columna) == [$comprobacion] || array_unique($fila) == [$comprobacion]) $respuesta = true;
        else if (($board[0][0] == $comprobacion && $board[1][1] == $comprobacion && $board[2][2] == $comprobacion)) $respuesta = true;        
        else if (($board[0][2] == $comprobacion && $board[1][1] == $comprobacion && $board[2][0] == $comprobacion)) $respuesta = true;
        else $respuesta = false;
    }
    return $respuesta;
}

session_start();
require "vendor/autoload.php";

use eftec\bladeone\BladeOne;

$views = __DIR__ . '\views'; // it uses the folder /views to read the templates
$cache = __DIR__ . '\cache'; // it uses the folder /cache to compile the result. 

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

$PATH_PLAYER_PIC = '.\public\assets\img\circle.jpg';
$PATH_COMPUTER_PIC = '.\public\assets\img\cross.jpeg';

$BOARD_SIZE = 3;

if (empty($_POST)) {// Si primer acceso a la aplicación

    $_SESSION['board'] = [
        ["", "", ""],
        ["", "", ""],
        ["", "", ""]
    ];

    echo $blade->run("move", ["BOARD_SIZE"=> $BOARD_SIZE, "PATH_PLAYER_PIC" => $PATH_PLAYER_PIC, "PATH_COMPUTER_PIC" => $PATH_COMPUTER_PIC]);

}else {
    $board = $_SESSION["board"];
    
    $x = filter_input(INPUT_POST,"x");
    $y = filter_input(INPUT_POST,"y");

    //modificamos
    $board[$x][$y] = "o";

    if(haGanado("o", $board, $x, $y)){ //gana jugador
        $respuesta = [
            "gameRes" => 1,

        ];
    }else if(haGanado("draw", $board, $x, $y)){ //empate
        $respuesta = [
            "gameRes" => 0,
        ];
    }else{
        //mover maquina
        $posicionLibre = false;
        while(!$posicionLibre){
            $xMandar = random_int(0, 2);
            $yMandar = random_int(0, 2);
            if($board[$xMandar][$yMandar] == ""){
                $posicionLibre = true;
            }
        }
        $board[$xMandar][$yMandar] = "x";  
        if (haGanado("x", $board, $xMandar, $yMandar)) { //gana maquina
            $respuesta = [
                "x" => $xMandar,
                "y" => $yMandar,
                "gameRes" => -1
            ];
        }
        else{ //se sigue jugando
            $respuesta = [
                "x" => $xMandar,
                "y" => $yMandar
            ];
        }

    }

    $_SESSION["board"] = $board;
    echo json_encode($respuesta);

}   

?>