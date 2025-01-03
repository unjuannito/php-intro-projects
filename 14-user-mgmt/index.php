<?php
session_start();
require "vendor/autoload.php";
require "user.php";

use eftec\bladeone\BladeOne;

use function PHPSTORM_META\type;

$views = __DIR__ . '\views'; // it uses the folder /views to read the templates
$cache = __DIR__ . '\cache'; // it uses the folder /cache to compile the result. 

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);
$requireds = [];

//INICIAR BDD
$error = false;
try {
    $bdd = new PDO("mysql:host=localhost;dbname=usermgmt", "root", "");
} catch (PDOException $error) {
    $errorCode = $error->getCode();
    $error = ["message" => "Los servidores o bases de datos necesarios no han sido capaces de iniciarse.", "errorCode" => $errorCode];
}

//Comprobar si se ha iniciado sesion
if(!empty($_SESSION["user"])){
    $user = unserialize($_SESSION["user"]);
}else $user = null;


//Logica

$submitButton = filter_input(INPUT_POST, "submitButton");
$nav = filter_input(INPUT_POST, "nav");

if (!empty($error)) { //Comprueba que no ha habido ningun error
    echo $blade->run('error', ["error" => $error["message"], "errorCode" => $error["errorCode"]]);
    
}else if (empty($_POST) && $user !== null) { //Comprueba si el usuario esta acreditado
    if (filter_input(INPUT_GET, "img")) {//mira si el usuario ha apretado en una de las imagenes para ver mas información
        $imgId = filter_input(INPUT_GET, "img");
        echo $blade->run('img', ["painting" => User::getClickedPainting($bdd, $imgId)]);
        
    }else echo $blade->run('main', ["userName" => $user->getUserName(), "favouritePaintings" => $user->getFavouritePaintings($bdd)]);//redirige al inicio

} else if (empty($_POST) ) {// Si es el primer acceso a la aplicación y no esta acreditado
    echo $blade->run('login');

}else if($submitButton){ //Si se ha hecho un submit en alguno de los botones
    switch ($submitButton) {
        case "Go to register":
            $userName = filter_input(INPUT_POST, "userName");
            $password = filter_input(INPUT_POST, "password");
            echo $blade->run('register', ["userName" => $userName, "password" => $password, "painters" => User::getAllPainters($bdd)]);
            break;

        case "Go to login":
            $userName = filter_input(INPUT_POST, "userName");
            $password = filter_input(INPUT_POST, "password");
            echo $blade->run('login', ["userName" => $userName, "password" => $password]);
            break;

        case "Login":
            //buscamos los datos introducidos
            if (!$userName = filter_input(INPUT_POST, "userName")) $requireds["0"] = "Required";
            if (!$password = filter_input(INPUT_POST, "password")) $requireds["1"] = "Required";

            //Procesamos los datos
            if (!empty($requireds)) echo $blade->run('login', ["userName" => $userName, "password" => $password, "requireds" => $requireds]);
            else{
                $user = User::getUser($bdd, $userName, $password);
                if ($user === -1) {
                    echo $blade->run('login', ["userName" => $userName, "password" => $password, "error" => "Usuario incorrecto, si no tienes un usario registrate"]);
                }else if($user === 0){
                    echo $blade->run('login', ["userName" => $userName, "password" => $password, "error" =>  "Contraseña incorrecta"]);
                }else{
                    echo $blade->run('main', ["userName" => $userName, "favouritePaintings" => $user->getFavouritePaintings($bdd)]);
                }
            }
            break;

        case "Register":
            //buscamos los datos introducidos
            if (!$userName = filter_input(INPUT_POST, "userName")) $requireds["0"] = "Required";
            if (!$email = filter_input(INPUT_POST, "email")) $requireds["2"] = "Required";
            if (!$password = filter_input(INPUT_POST, "password")) $requireds["1"] = "Required";
            if (!$pintor = filter_input(INPUT_POST, "pintor")) $requireds["3"] = "Required";
            $pintorSelected[$pintor] = "selected='true'";

            //Procesamos los datos
            if (!empty($requireds)) echo $blade->run('register', ["userName" => $userName, "password" => $password, "email" => $email, "pintorSelected" => $pintorSelected, "requireds" => $requireds, "painters" => User::getAllPainters($bdd)]);
            else{
                $user = User::getUser($bdd, $userName, $password);
                if ($user instanceof User || $user === 0) {
                    echo $blade->run('register', ["userName" => $userName, "password" => $password, "email"=> $email, "pintorSelected" => $pintorSelected,"error" => "Este usuario ya existe ve al  login"]);
                }else {
                    $user = User::register($bdd, $userName, $password, $email, $pintor, User::getNewID($bdd));
                    if ($user instanceof User) {
                        echo $blade->run('main', ["userName" => $userName, "favouritePaintings" => $user->getFavouritePaintings($bdd)]);
                    }else echo $blade->run('error', ["error" => $error["message"], "errorCode" => $error["errorCode"]]);
                }
            }
            break;

        case 'Cambiar datos':
            //buscamos los datos introducidos
            if (!$userName = filter_input(INPUT_POST, "userName")) $requireds["0"] = "Required";
            if (!$email = filter_input(INPUT_POST, "email")) $requireds["2"] = "Required";
            if (!$password = filter_input(INPUT_POST, "password")) $requireds["1"] = "Required";
            if (!$pintor = filter_input(INPUT_POST, "pintor")) $requireds["3"] = "Required";

            //Procesamos los datos
            if (!empty($requireds)) echo $blade->run('perfil', ["userName" => $userName, "password" => $password, "email" => $email, "pintor" => $pintor, "requireds" => $requireds, "painters" => User::getAllPainters($bdd)]);
            else{
                $user->changueData($bdd, $userName, $password, $email, $pintor);
                $pintorSelected[$user->getPainter()] = "selected='true'";
                echo $blade->run('perfil', ["userName" => $user->getUserName(), "password" => $user->getPassword(), "email" => $user->getEmail(), "pintorSelected" => $pintorSelected, "painters" => User::getAllPainters($bdd)]);
            }  
            break;

        case 'Volver al inicio':
            echo $blade->run('main', ["userName" => $user->getUserName(), "favouritePaintings" => $user->getFavouritePaintings($bdd)]);
            break;
            
        case 'Cerrar sesión':
            session_destroy();
            echo $blade->run('login');
            break;

        case 'Eliminar cuenta':
            if (User::getUser($bdd, $user->getUserName(), filter_input(INPUT_POST, "password")) === 0) {
                echo $blade->run('baja', ["userName" => "paco", "error" => "Contraseña incorrecta"]);
            }else{
                $user->delateUser($bdd);
                session_destroy();
                echo $blade->run('login');    
            }
            break;
    }
}else if($nav){
    switch ($nav) {
        case -1:
            echo $blade->run('main', ["userName" => $user->getUserName(), "favouritePaintings" => $user->getFavouritePaintings($bdd)]);
            break;
        case 1:
            $pintorSelected[$user->getPainter()] = "selected='true'";
            echo $blade->run('perfil', ["userName" => $user->getUserName(), "password" => $user->getPassword(), "email" => $user->getEmail(), "pintorSelected" => $pintorSelected, "painters" => User::getAllPainters($bdd)]);
            break;
        case 2:
            echo $blade->run('logout');
            break;
        case 3:
            echo $blade->run('baja');
            break;
    }
}

//Guardar el user
if (!empty($user) && $user instanceof User) {
    $_SESSION["user"] = serialize($user);
}
?>