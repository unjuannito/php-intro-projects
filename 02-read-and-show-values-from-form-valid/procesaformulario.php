<?php
    //Comprueba que no sea POST
    if(empty($_POST)){
        header("Location: index.php");
    }


    $correctForm = true;
    $nameError = $passwordError = $emailError = $dateofbirthError = $telephoneError = $shopError = $ageError = $subscriptionError = "";
    $name = $password = $email = $dateofbirth = $telephone = $shop = $age = $subscription = "";
    $checked1 = $checked2 = $checked3 = $selected1 = $selected2 = $selected3= $checked = "";

    $name = filter_input(INPUT_POST, "name");
    if (!$name) {
        $nameError = "The name is compulsary.";
    } else if(!preg_match('/^(?=.*[A-ZÑ])(?=.*[a-zñ])(?=.*\s)[a-zñA-ZÑ\s]{3,25}$/', $name)){
        $nameError = 'Incorrect name format';
    }
    $password = filter_input(INPUT_POST, "password");
    if (!$password) {
        $passwordError = "The password is compulsary.";
    }else if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{6,8}$/', $password)){
        $passwordError = 'Incorrect password format';
    }
    $email = filter_input(INPUT_POST, "email");
    if (!$email) {
        $emailError = "The email is compulsary";
    }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError='Incorrect email format';
    }
    
    $currentDate = new DateTime();
    $dateofbirth = filter_input(INPUT_POST, "dateofbirth");
    $birth = new DateTime($dateofbirth);
    $age = date_diff($currentDate, $birth)->format('%Y');
    if (!$dateofbirth) {
        $dateofbirthError = "The date of birt is compulsary";
    }else if (!filter_var($dateofbirth, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/"))) || $birth > $currentDate) {
        $dateofbirthError='Incorrect date of birth format';
    }else if ($age < 18 ){
        $dateofbirthError='User must be an adult';
    }
    $telephone = filter_input(INPUT_POST, "tel");
    if (!$telephone) {
        $telephoneError = "The telephone is compulsary";
    }else if (!preg_match("/(6|7|9)[ -]*([0-9][ -]*){8}/", $telephone)) {
        $telephoneError='Incorrect telephone format';
    }
    $shop = filter_input(INPUT_POST, "shop");
    if (!$shop) {
        $shopError = "The shop is compulsary";
    } elseif ($shop == "Madrid"){
        $selected1="selected";
    }elseif ($shop == "Barcelona"){
        $selected2="selected";
    }elseif ($shop == "Valencia"){
        $selected3="selected";
    }
    $age = filter_input(INPUT_POST, "age");
    if ($age == "-25") {
        $age = "Younger than 25";
        $checked1="checked";
    }else if ($age == "25-50"){
        $age = "Between 25 and 50";
        $checked2="checked";
    }else if($age == "50-"){
        $age = "Older than 50";
        $checked3="checked";
    }else $ageError= "The age is compulsary";

    $subscription = filter_input(INPUT_POST, "subscription");
    if ($subscription == "on") {
        $subscription = "Subscribed";
        $checked = "checked";
    } else if ($subscription == "") {
        $subscription = "Unsubscribed";
    } else $correctSubscription = "Error selecting the subscription";

    $correctForm = $nameError=="" && $passwordError=="" && $emailError=="" && $dateofbirthError=="" && $telephoneError=="" && $shopError=="" && $ageError=="" && $subscriptionError=="";

if (!$correctForm) { ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Register Form</title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta name="viewport" content="width=device-width">
            <link rel="stylesheet" href="stylesheet.css">
        </head>
        <body>
                <div class="flex-page">
                    <h1>Customer Registration</h1>
                    <form class="form-font capaform" name="registerform" 
                          action="procesaformulario.php" method="POST">
                        <div class="flex-outer">
                            <div class="form-section">
                                <label for="name">Name:</label> 
                                <input id="name" type="text" name="name" placeholder="Enter your name:" value="<?php echo $name;?>" /> <span class="error"><?php echo $nameError?></span> 
                            </div>
                            <div class="form-section">
                                <label for="password">Contraseña:</Label> 
                                <input id="password" type="password" name="password" placeholder="Enter your password:" value="<?php echo $password;?>"/> <span class="error"><?php echo $passwordError?></span>
                            </div>
                            <div class="form-section">
                                <label for="email">Email:</Label> 
                                <input id="email" type="text"  name="email" placeholder="Enter your email" value="<?php echo $email;?>"> <span class="error"><?php echo $emailError?></span>
                            </div>
                            <div class="form-section">
                                <label for="dateofbirth">Date of Birth:</Label> 
                                <input id="dateofbirth" type="date" name="dateofbirth" placeholder="Enter your date of birth" value="<?php echo $dateofbirth;?>"> <span class="error"><?php echo $dateofbirthError?></span>
                            </div>
                            <div class="form-section">
                                <label for="telephone">Telefono Móvil:</Label> 
                                <input id="telephone" type="tel" name="tel" placeholder="Enter your telephone" value="<?php echo $telephone;?>"> <span class="error"><?php echo $telephoneError?></span>
                            </div>
                            <div class="form-section">
                                <label for="shop">Closest Shop:</Label> 
                                <select id="shop" name="shop">
                                    <option value="Madrid" <?php echo $selected1?>>Madrid</option>
                                    <option value="Barcelona" <?php echo $selected2?>>Barcelona</option> <span class="error"><?php echo $shopError?></span>
                                    <option value="Valencia" <?php echo $selected3?>>Valencia</option>
                                </select> 
                            </div>
                            <div class="form-section">
                                <label>Age:</label>
                                <div class="select-section">
                                    <div>
                                        <input id="-25" type="radio" name="age" value="-25" <?php echo $checked1?>/>
                                        <label for="-25">Younger than 25</label>
                                    </div>
                                    <div>
                                        <input id="25-50" type="radio" name="age" value="25-50" <?php echo $checked2?>/> 
                                        <label for="25-50">Between 25 and 50</label> <span class="error"><?php echo $ageError?></span>
                                    </div>
                                    <div>
                                        <input id="50-" type="radio" name="age" value="50-" <?php echo $checked3?>/>
                                        <label for="50-">Older than 50</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-section">
                                <label for="subscription">Newsletter subscription:</label>
                                <input id="subscription" type="checkbox"  name="subscription" <?php echo $checked?>/>  <span class="error"><?php echo $subscriptionError?></span>
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
    
<?php } else{ ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>User data</title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta name="viewport" content="width=device-width">
            <link rel="stylesheet" href="stylesheet.css">
        </head>
        <body>
                <div class="flex-page">
                    <h1>User data</h1>
                    <main class="form-font capaform" name="registerform" >
                        <div class="flex-outer">
                            <div class="form-section">
                                <label>Name:</label>
                                <?php echo $name?>
                            </div>
                            <div class="form-section">
                                <label>Contraseña:</Label>
                                <?php echo $password?>
                            </div>
                            <div class="form-section">
                                <label>Email:</Label>
                                <?php echo $email?>
                            </div>
                            <div class="form-section">
                                <label>Date of Birth:</Label>
                                <?php echo $dateofbirth?>
                            </div>
                            <div class="form-section">
                                <label>Telefono Móvil:</Label>
                                <?php echo $telephone?>
                            </div>
                            <div class="form-section">
                                <label>Closest Shop:</Label>
                                <?php echo $shop?> 
                            </div>
                            <div class="form-section">
                                <label>Age:</label>
                                <?php echo $age?>
                            </div>
                            <div class="form-section">
                                <label>Newsletter subscription:</label>
                                <?php echo $subscription?>
                            </div>
                        </div>
                    </main>
                </div>
        </body>
    </html>
<?php } ?>