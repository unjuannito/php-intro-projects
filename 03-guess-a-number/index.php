<?PHP 
    $error = $inPlay = false;
    $numberError = $guessesError = $guessError = $mensaje =  "";

    //Comprueba que no sea POST
    if(!empty($_POST)){
        
        $minNumber = filter_input(INPUT_POST, "minN");
        $maxNumber = filter_input(INPUT_POST, "maxN");
        if(!$minNumber || !$maxNumber){
            $numberError = "You must introduce bouth numbers";
        }else if($minNumber > $maxNumber){
            $numberError = "The maximun number must be higher than the minimum";
        }else if($minNumber < 1 || $maxNumber < 2){
            $numberError = "Both number must be higher 0";
        }
        $guesses = filter_input(INPUT_POST, "nGuesses");
        $guess = filter_input(INPUT_POST, "guess");
        if(!$guesses)$guessesError = "You must introduce the number of guesses";
        else if($guesses < 1) $guessesError = "The number of guesses must be higuer than 0";
        
        $number = filter_input(INPUT_POST, "number");
        //Buscar errores

        $error = !$numberError=="" || !$guessesError == "";

        //generar numero
        if (!$error) {
            $inPlay = true;
            if(!$number){
                $number = random_int($minNumber, $maxNumber);
                $guess = false;
            }else{
                if(!$guess)$guessError = "You must introduce a guess";
                if($inPlay && $guessError == "") $guesses--;
            }

        }
        if ($number == $guess && $inPlay) {
            $mensaje = "You win";
            $minNumber = $maxNumber = $guesses = $inPlay = $number = false;
        }else if ($guesses <= 0 && $inPlay){
            $mensaje = "Game over, try again";
            $minNumber = $maxNumber = $guesses = $inPlay = $number = false;
        }else if ($guess > $number && $guess != false ) $mensaje = "The number is lower";
        else if ($guess < $number && $guess != false) $mensaje = "The number is higher";
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Guess a number</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
            <div class="flex-page">
                <h1>Guess a number</h1>
                <form class="form-font capaform" name="registerform" 
                        action="index.php" method="POST">
                    <div class="flex-outer">
                        <!-- 1 -->
                        <div class="form-section">
                            <label for="minNguess">Minimun possible number:</label> 
                            <input id="minNguess" type="number" name="minN" placeholder="Minimum number" value="<?php echo $minNumber?>" <?php echo ($inPlay) ?  "readonly" : "";?>> <span class="error" ><?php echo $numberError?></span> 
                        </div>
                        <!-- 2 -->
                        <div class="form-section">
                            <label for="maxN">Max possible number:</Label> 
                            <input id="maxN" type="number" name="maxN" placeholder="Maximun number" value="<?php echo $maxNumber?>" <?php echo ($inPlay) ?  "readonly" : "";?>> <span class="error" ><?php echo $numberError?></span> 
                        </div>
                        <!-- 3 -->
                        <div class="form-section">
                            <label for="nGuesses">Number of guesses:</Label> 
                            <input id="nGuesses" type="number"  name="nGuesses" placeholder="Number of guesses" value="<?php echo $guesses?>" <?php echo ($inPlay) ?  "readonly" : "";?>> <span class="error" ><?php echo $guessesError?></span> 
                        </div>
                        <!-- guess -->
                        <div class="form-section">
                            <label for="guess" <?php echo ($inPlay) ?  "" : "hidden";?>>Your guess:</Label> 
                            <input id="guess" type="number" name="guess" placeholder="Enter your guess" value="<?php echo $guess?>" <?php echo ($inPlay) ?  "" : "hidden";?>> <span class="error" ><?php echo $guessError?></span>
                        </div>
                        <!-- num -->
                        <div class="form-section">
                            <input id="number" type="number" name="number" value="<?php echo $number;?>" hidden>
                        </div>
                        <span class="mensaje"><?php echo $mensaje;?></span>

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