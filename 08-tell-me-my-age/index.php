<?PHP 
    function esBisiesto($year) {
        return ($year % 4 == 0 && $year % 100 != 0) || ($year%400==0);
    }
    //variables 1
    $error = $res = "";
    $currentDate = new DateTime();
    $dateofbirth = filter_input(INPUT_POST, "dateofbirth");
    $birth = new DateTime($dateofbirth);
    $age = false;
    //variables 2
    $errorText = $resText = "";
    $currentDateYear = $currentDate->format('Y');
    $currentDateMonth = $currentDate->format('m');
    $currentDateDay = $currentDate->format('d');
    $dateofbirthText = filter_input(INPUT_POST, "dateofbirthText");
    $ageText = false;
    $dataOfBirth= false;


    //logica 1
    $age = date_diff($currentDate, $birth)->format('%Y');
    if(!empty($_POST)){
        if (!$dateofbirth) {
            $error = "The date of birth is compulsary";
            $age = false;
        }else if (!filter_var($dateofbirth, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/"))) || $birth > $currentDate) {
            $error='Incorrect date of birth format';
            $age = false;
        }
    }else $age = false;

    //logica 2
    if(!empty($_POST)){
        if (!$dateofbirthText) $errorText    = "The date of birth is compulsary";

        else if (preg_match("/^[0-9][0-9]\/[0-9][0-9]\/[0-9][0-9][0-9][0-9]$/", $dateofbirthText)) {
            $dataOfBirth = explode("/", $dateofbirthText);

            if($dataOfBirth[2] > $currentDateYear) $errorText = "Incorrect date of birth";
            else if($dataOfBirth[2] == $currentDateYear && $dataOfBirth[1] > $currentDateMonth) $errorText = "Incorrect date of birth";
            else if($dataOfBirth[2] == $currentDateYear && $dataOfBirth[1] == $currentDateMonth && $currentDateDay > $dataOfBirth[0]) $errorText = "Incorrect date of birth";
            else if($dataOfBirth[1] < 1 || $dataOfBirth[1]>12) $errorText = "Incorrect date of birth format";
            else if ($dataOfBirth[0] < 1) $errorText = "Incorrect date of birth format";
            else if(in_array($dataOfBirth[1],[1, 3, 5, 7, 8, 10, 12]) && $dataOfBirth[0]>31) $errorText = "Incorrect date of birth format";
            else if( in_array($dataOfBirth[1],[4, 6, 9, 11]) && $dataOfBirth[0]>30) $errorText = "Incorrect date of birth format";
            else if( $dataOfBirth[1] == 2 && esBisiesto($dataOfBirth[2]) && $dataOfBirth[0]>29) $errorText = "Incorrect date of birth format";
            else if( $dataOfBirth[1] == 2 && !esBisiesto($dataOfBirth[2]) && $dataOfBirth[0]>28) $errorText = "Incorrect date of birth format";
            else{
                $ageText = $currentDateYear-$dataOfBirth[2]-1;
                if ($currentDateMonth>$dataOfBirth[1]) $ageText++;
                if ($currentDateMonth==$dataOfBirth[1] && $currentDateDay>=$dataOfBirth[0]) $ageText++;
            }
        }else $errorText = "Incorrect date of birth format";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>TELL ME MY AGE</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
            <div class="flex-page">
                <h1>TELL ME MY AGE</h1>
                <form class="form-font capaform" name="registerform" 
                        action="index.php" method="POST">
                    <div class="flex-outer">
                        <!-- 1 -->
                        <div class="form-section">
                        <label for="dateofbirth">Introduce your age: </label>
                        <input id="dateofbirth" type="date" name="dateofbirth" placeholder="Date of birth" value="<?php echo $dateofbirth?>"><span class="error"><?php echo $error?></span>
                        </div>
                        <!-- 1.1 -->
                        <div class="form-section">
                        <label for="dateofbirth">Your age: </label>
                        <span><?php echo $age;?></span>
                        </div>
                        <!-- 2 -->
                        <div class="form-section">
                        <label for="dateofbirthText">Introduce your age: </label>
                        <input id="dateofbirthText" type="text" name="dateofbirthText" placeholder="Date of birth ej:11/11/2000" value="<?php echo $dateofbirthText?>"><span class="error"><?php echo $errorText?></span>
                        </div>
                        <!-- 2.1 -->
                        <div class="form-section">
                        <label for="dateofbirthText">Your age: </label>
                        <span><?php echo $ageText;?></span>
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