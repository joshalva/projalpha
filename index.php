<?php
session_start();

if (!isset($_SESSION['nickname'])) {
    $_SESSION['msg'] = "Devi effettuare il login";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['nickname']);
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SeeMyCity - Home</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="navcont">
            <nav id="navbar">
                <ul>
                    <li id="nav1"><a href="home.html"><img src="images/logohome.PNG" alt="logo" width="100px" height="50px"></a></li>
                    <li id="nav2"><em>Benvenuto<strong> <?php echo $_SESSION['nickname']; ?></strong>!</em></li>
                    <li id="nav3"><img id="userph" src="images/user.png" width="45px" height="45px" ></li>
                </ul>
            </nav>
        </div>
        <div class="contar">  <h1 id="titlehome"><em>Choose your destination</em></h1>
        </div>
        <br>
        
        <form action="/action_page.php" method ='POST'>City name!<br>
            <input type="text" name="nomecitta">
        </form>
        <div class="content">

            <!-- notification message -->
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="error success" >
                    <h3>
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </h3>
                </div>
            <?php endif ?>

            <!-- logged in user information -->
            <?php if (isset($_SESSION['nickname'])) : ?>
                <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
            <?php endif ?>
        </div>

    </body>
</html>