<?php
session_start();
require "vendor/autoload.php";

use eftec\bladeone\BladeOne;

$views = __DIR__ . '\views'; // it uses the folder /views to read the templates
$cache = __DIR__ . '\cache'; // it uses the folder /cache to compile the result. 

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);


if (empty($_POST) || filter_input(INPUT_POST, "finalButton")) {// Si primer acceso a la aplicación
    echo $blade->run('teams');
}else if(filter_input(INPUT_POST, "teamsButton")) {
    $teams = filter_input(INPUT_POST,"teams");
    if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+(, [ a-zA-ZñÑáéíóúÁÉÍÓÚ]+)*$/', $teams)) {
        echo $blade->run("teams", [ "teams" => $teams, "error" => "Campo de equipos incorrecto" ]);
        }else {
        $teams = explode(",", $teams);
        foreach ($teams as $team) {
            $matchs[$team] = [];
            $rivalTeams = array_diff($teams, array($team));
            foreach ($rivalTeams as $rivalTeam) {
                array_push($matchs[$team], ["rivalTeam" => $rivalTeam, "score" => random_int(0, 5), "rivalScore" => random_int(0, 5)]);
            }
        }
        echo $blade->run("generate", [ "teams"=> $teams, "matchs" => $matchs ] );
    }
}else if (filter_input(INPUT_POST,"generateButton")) {

    $matchs = filter_input(INPUT_POST,"matchs", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    $teams = array_keys($matchs);

    foreach ($teams as $team) {
        $score[$team] = ["points" => 0, "goals" => 0, "rivalGoals" => 0 , "difference" => 0];
    }

    foreach($teams as $team) {
        $rivalTeams = array_diff($teams, array($team));
        foreach ($rivalTeams as $rivalTeam) {

            $actualMatch = $matchs[$team][$rivalTeam];
            
            $score[$team]["goals"] += $actualMatch["score"];
            $score[$team]["difference"] += $actualMatch["score"];
            $score[$rivalTeam]["goals"] += $actualMatch["rivalScore"];
            $score[$rivalTeam]["difference"] += $actualMatch["rivalScore"];
            $score[$team]["rivalGoals"] += $actualMatch["rivalScore"];
            $score[$team]["difference"] -= $actualMatch["rivalScore"];
            $score[$rivalTeam]["rivalGoals"] += $actualMatch["score"];
            $score[$rivalTeam]["difference"] -= $actualMatch["score"];
            if ($actualMatch["score"] > $actualMatch["rivalScore"] ) {
                $score[$team]["points"] += 3;
            }else if( $actualMatch["score"] < $actualMatch["rivalScore"] ) {
                $score[$rivalTeam]["points"] += 3;
            }else {
                $score[$team]["points"] += 1;
                $score[$rivalTeam]["points"] += 1;
            }
        }

    }

    $points = array_column($score, 'points');
    $difference = array_column($score, 'difference');
    array_multisort($points, SORT_DESC, $difference, SORT_DESC  , $teams);

    echo $blade->run("league", ["teams" => $teams, "score" => $score]);
}

?>