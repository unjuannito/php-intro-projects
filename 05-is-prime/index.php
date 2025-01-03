<?PHP 

    //variables
    $number = false;
    $number = filter_input(INPUT_POST, "number");
    $error = $res = "";
    //logica
    if(!empty($_POST)){
        if (!$number) $error = "Debes introducir un numero";
        else if ($number < 0) $error = "Debes introducir un numero positivo"; 
        else{
            switch ($number) {
                case 1:
                case 4:
                case 0:
                    $res = "No es primo";
                    break;
                case 2:
                case 3:
                case 5:
                    $res = "Es primo";
                    break;
                
                default:
                    if($number%2 == 0 || $number%3 == 0) $res = "No es primo";
                    for ($i=6; $i < sqrt($number) && $res == ""; $i+=6) { 
                        if($number%($i-1) == 0 || $number%($i+1) == 0) $res = "No es primo";
                    }
                    if ($res == "") $res = "Es primo";
                    break;
            }        
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>ES PRIMO?</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
            <div class="flex-page">
                <h1>ES PRIMO?</h1>
                <form class="form-font capaform" name="registerform" 
                        action="index.php" method="POST">
                    <div class="flex-outer">
                        <!-- 1 -->
                        <div class="form-section">
                        <label for="number">Inserte un número para ver si es primo: </label>
                        <input id="number" type="number" step="1" name="number" placeholder="Number" value="<?php echo $number?>">
                        <span>&nbsp;&nbsp; <?php echo $res?></span>
                        </div>
                        <span class="error"><?php echo $error?></span>
                        <div class="form-section">
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