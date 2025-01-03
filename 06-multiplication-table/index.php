<?PHP 


    //variables
    $error = $res = $stringPosted = "";
    $stringPosted = filter_input(INPUT_POST, "stringPosted");
    $finalNumbers = false;
    $tables = "";
    //logica
    if(!empty($_POST)){
        if (!$stringPosted) $error = "Debes introducir un numero"; 
        else if(!preg_match("/^(([1-9])|([1-9]-[1-9]))((,[1-9])|(,[1-9]-[1-9]))*$/", $stringPosted)) $error = "Solo se puede introducir una cadena que contiene números del 1 al 9 separados por comas o con guiones";
        else{
            $strings = explode(",", $stringPosted);
            $allNumbers = array();
            foreach ($strings as $eachString) {
                if (strpos($eachString, "-")){
                    $rangos = explode("-", $eachString);
                        for ($i=$rangos[0]; $i <= $rangos[1] ; $i++) { 
                            array_push($allNumbers, $i);
                        }
                }else {
                    array_push($allNumbers, $eachString);
                }
            }
            $finalNumbers = array_unique($allNumbers);
            sort($finalNumbers);
            $tables ="<table class='tables'>";
            foreach ($finalNumbers as $finalNumber) {
                $tables .=  "<table class='table'>
                                <tr>
                                    <th>Tabla del ".$finalNumber."</th>
                                </tr>";
                for ($i=1; $i <= 10; $i++) { 
                    $tables.=   "<tr>
                                    <td>".$finalNumber." x ".$i." = ".$finalNumber*$i."</th>
                                </tr>";
                }
                $tables .=  "</table>";
            }
            $tables .="</table>";

        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Tablas de multiplicar</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>

            <div class="flex-page">
                <h1>Tablas de multiplicar</h1>
                <form class="form-font capaform" name="registerform" 
                        action="index.php" method="POST">
                    <div class="flex-outer">
                        <div class="form-section">
                        <h3>Introduce una cadena que contiene números del 1 al 9 separados por comas o con guiones para representar rangos: </h3>
                        </div>
                        <div class="form-section">
                        <input id="stringPosted" type="text" step="1" name="stringPosted" placeholder="Numbers" value="<?php echo $stringPosted?>">
                        <span>&nbsp;&nbsp; <?php echo $res?></span>
                        </div>
                        <span class="error"><?php echo $error?></span>
                        <div class="form-section">
                        <?php echo $tables;?>
                        </div>
                        <div class="form-section">
                            <div class="submit-section">
                                <input class="submit" type="submit" 
                                        value="Send" name="sendbutton"/> 
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </body>
</html>