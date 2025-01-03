<?PHP 

    //Divisas basadas en el euro
    $EUR = 1.0;
    $USD = 0.95;
    $GBP = 1.16;
    $CNY = 0.13;
    //variables
    $error = "";
    $value1 = $value2 = false;
    $c1 = $c2 = $c3 = $c4 = $c5 = $c6 = $c7 = $c8 = "";
    $currency1 = filter_input(INPUT_POST, "cu1");
    $currency2 = filter_input(INPUT_POST, "cu2");
    $value1 = filter_input(INPUT_POST, "value1");

    //logica
    if(!empty($_POST)){
        
        if(!$value1){
            $error = "You must introduce a value";
            $value1 = 0;
        }
        switch ($currency1) {
            case 'EUR':
                $value2=$value1*$EUR;
                $c1 = "SELECTED";
                break;
            
            case 'USD':
                $value2=$value1*$USD;
                $c2 = "SELECTED";
                break;
            
            case 'GBP':
                $value2=$value1*$GBP;
                $c3 = "SELECTED";
                break;
            
            case 'CNY':
                $value2=$value1*$CNY;
                $c4 = "SELECTED";
                break;
            
            default:
                break;
        }
        switch ($currency2) {
            case 'EUR':
                $value2=$value2/$EUR;
                $c5 = "SELECTED";
                break;
            
            case 'USD':
                $value2=$value2/$USD;
                $c6 = "SELECTED";
                break;
            
            case 'GBP':
                $value2=$value2/$GBP;
                $c7 = "SELECTED";
                break;
            
            case 'CNY':
                $value2=$value2/$CNY;
                $c8 = "SELECTED";
                break;
            
            default:
                break;
        }
        $value2= number_format($value2, 2);
    }


?>
<!DOCTYPE html>
<html>
    <head>
        <title>EXCHANGUE</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
            <div class="flex-page">
                <h1>EXCHANGUE</h1>
                <form class="form-font capaform" name="registerform" 
                        action="index.php" method="POST">
                    <div class="flex-outer">
                        <!-- 1 -->
                        <div class="form-section">
                        <select id="cu1" name="cu1">
                                <option value="EUR" <?php echo $c1?>>Euro</option>
                                <option value="USD" <?php echo $c2?>>Dolar estadounidense</option>
                                <option value="GBP" <?php echo $c3?>>Libra esterlina</option>
                                <option value="CNY" <?php echo $c4?>>Yuan</option>
                            </select> 
                        <input id="value1" type="number" step="0.01" name="value1" placeholder="Amount" value="<?php echo $value1?>"> <span class="error" ><?php echo $error?></span>
                        </div>
                        <!-- 2 -->
                        <div class="form-section">
                        <select id="cu2" name="cu2">
                                <option value="EUR" <?php echo $c5?>>Euro</option>
                                <option value="USD" <?php echo $c6?>>Dolar estadounidense</option>
                                <option value="GBP" <?php echo $c7?>>Libra esterlina</option>
                                <option value="CNY" <?php echo $c8?>>Yuan</option>
                            </select> 
                        <input id="value2" type="number" step="0.01" name="value2"  value="<?php echo $value2?>" readonly>
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