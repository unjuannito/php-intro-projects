<!DOCTYPE html>
<html>
    <head>
        <title>Register Form</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <?php
    $name = $password = $email = $dateofbirth = $telephone = $shop = $age = $subscription = "";
    ?>
    <body>
            <div class="flex-page">
                <h1>Customer Registration</h1>
                <form class="form-font capaform" name="registerform" 
                        action="procesaformulario.php" method="POST">
                    <div class="flex-outer">
                        <div class="form-section">
                            <label for="name">Name:</label> 
                            <input id="name" type="text" name="name" placeholder="Enter your name:"/>
                        </div>
                        <div class="form-section">
                            <label for="password">Contraseña:</Label> 
                            <input id="password" type="password" name="password" placeholder="Enter your password:"/>
                        </div>
                        <div class="form-section">
                            <label for="email">Email:</Label> 
                            <input id="email" type="text"  name="email" placeholder="Enter your email">
                        </div>
                        <div class="form-section">
                            <label for="dateofbirth">Date of Birth:</Label> 
                            <input id="dateofbirth" type="date" name="dateofbirth" placeholder="Enter your date of birth">
                        </div>
                        <div class="form-section">
                            <label for="telephone">Telefono Móvil:</Label> 
                            <input id="telephone" type="tel" name="tel" placeholder="Enter your telephone">
                        </div>
                        <div class="form-section">
                            <label for="shop">Closest Shop:</Label> 
                            <select id="shop" name="shop">
                                <option value="Madrid">Madrid</option>
                                <option value="Barcelona">Barcelona</option>
                                <option value="Valencia">Valencia</option>
                            </select> 
                        </div>
                        <div class="form-section">
                            <label>Age:</label>
                            <div class="select-section">
                                <div>
                                    <input id="-25" type="radio" name="age" value="-25" /> 
                                    <label for="-25">Younger than 25</label>
                                </div>
                                <div>
                                    <input id="25-50" type="radio" name="age" value="25-50" /> 
                                    <label for="25-50">Between 25 and 50</label>
                                </div>
                                <div>
                                    <input id="50-" type="radio" name="age" value="50-" />
                                    <label for="50-">Older than 50</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-section">
                            <label for="subscription">Newsletter subscription:</label>
                            <input id="subscription" type="checkbox"  name="subscription"/> 
                        </div>
                        <div class="form-section">
                            <div class="submit-section">
                                <input class="submit" type="submit" 
                                        value="Send" name="sendbutton" /> 
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </body>
</html>