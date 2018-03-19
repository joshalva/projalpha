<?php include('server.php') ?>
<!DOCTYPE html>
<html>
    <head>
        <title>SeeMyCity - Login</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body style="background: url(images/sfondologin.jpg) no-repeat center center fixed;
        -moz-background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        background-attachment:fixed;">
        
        <div class="header">
            <h1>Benvenuto in SeeMyCity</h1>
        </div>

        <div class="header">
            <h2>Login</h2>
        </div>

        <form method="post" action="login.php">

            <?php include('errors.php'); ?>

            <div class="input-group">
                <label>Nickname</label>
                <input type="text" name="nick" >
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="psw">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="login_user">Login</button>
            </div>
            <p>
                Non sei iscritto? <a href="register.php">Sign up</a>
            </p>
        </form>


    </body>
</html>