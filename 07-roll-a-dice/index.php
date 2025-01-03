<?PHP 


    //variables
    $error = $numberOfRolls = "";
    $mensaje = "";
    //logica
    if(!empty($_POST)){
        $numberOfRolls = filter_input(INPUT_POST, "numberOfRolls");
        if (!$numberOfRolls) $error = "Debes introducir un numero"; 
        else if( $numberOfRolls < 1) $error = "Se debe introducir un numero mayor o igual a unos";
        else{
            $numbersGenerated = array();

            for ($i=0; $i < $numberOfRolls ; $i++) { 
                array_push($numbersGenerated, random_int(1, 6));
            }
            $conteo = array_count_values($numbersGenerated);

            $mensaje = "<span>Han salido ".((empty($conteo[1]))?"0":$conteo[1])." uno(s).</span><br>
                        <span>Han salido ".((empty($conteo[2]))?"0":$conteo[2])." dos(es).</span><br>
                        <span>Han salido ".((empty($conteo[3]))?"0":$conteo[3])." tres(es).</span><br>
                        <span>Han salido ".((empty($conteo[4]))?"0":$conteo[4])." cuatr(os).</span><br>
                        <span>Han salido ".((empty($conteo[5]))?"0":$conteo[5])." cinco(s).</span><br>
                        <span>Han salido ".((empty($conteo[6]))?"0":$conteo[6])." seis(es).</span><br>";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>tira el dado</title>
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
                        <label>Introduce el numero de tiradas del dado: </label>
                        <input id="numberOfRolls" type="number" step="1" name="numberOfRolls" placeholder="Tiradas" value="<?php echo $numberOfRolls?>">
                        <span>
                        </div>
                        <span class="error"><?php echo $error?></span>
                        <div class="mensaje">
                        <?php echo $mensaje;?>
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
<!-- Numero mas alto que acepta mi navegador para numero de tiradas 8388608 -->