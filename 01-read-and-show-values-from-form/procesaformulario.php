<?php
    $name = filter_input(INPUT_POST, "name");
    if ($name == false) {
        $name = "Not known";
    }
    $password = filter_input(INPUT_POST, "password");
    if ($password == false) {
        $password = "Not known";
    }
    $email = filter_input(INPUT_POST, "email");
    if ($email == false) {
        $email = "Not known";
    }
    $dateofbirth = filter_input(INPUT_POST, "dateofbirth");
    if ($dateofbirth == false) {
        $dateofbirth = "Not known";
    }
    $telephone = filter_input(INPUT_POST, "tel");
    if ($telephone == false) {
        $telephone = "Not known";
    }

    $shop = filter_input(INPUT_POST, "shop");
    if ($shop == false) {
        $shop = "Not known";
    }

    $age = filter_input(INPUT_POST, "age");
    if ($age == "-25") {
        $age = "Younger than 25";
    }else if ($age == "25-50"){
        $age = "Between 25 and 50";
    }else if($age == "50-"){
        $age = "Older than 50";
    }else $age = "Not known";

    $subscription = filter_input(INPUT_POST, "subscription");
    if ($subscription == "on") {
        $subscription = "Suscribed";
    } else $subscription = "Unsuscribed";

?>
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
                            <?php 
                                echo $name;
                            ?>
                        </div>
                        <div class="form-section">
                            <label>Contraseña:</Label> 
                            <?php 
                                echo $password;
                            ?>
                        </div>
                        <div class="form-section">
                            <label>Email:</Label> 
                            <?php 
                                echo $email;
                            ?>
                        </div>
                        <div class="form-section">
                            <label>Date of Birth:</Label> 
                            <?php 
                                echo $dateofbirth;
                            ?>
                        </div>
                        <div class="form-section">
                            <label>Telefono Móvil:</Label> 
                            <?php 
                                echo $telephone;
                            ?>
                        </div>
                        <div class="form-section">
                            <label>Closest Shop:</Label> 
                            <?php 
                                echo $shop;
                            ?>
                        </div>
                        <div class="form-section">
                            <label>Age:</label>
                            <?php 
                                echo $age;
                            ?>
                        </div>
                        <div class="form-section">
                            <label>Newsletter subscription:</label>
                            <?php 
                                echo $subscription;
                            ?>
                        </div>
                    </div>
                </main>
            </div>
    </body>
</html>