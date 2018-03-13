<?php

session_start();

// $nickname = "";
// $email = "";
// $citta="";
// $datanascita=date("d,m,Y");
$errors = array();
$_SESSION['success'] = "";
//connessione al db
try{
    $hostname = "localhost";
    $dbname = "alpha";
    $user = "root";
    $db = new PDO ("mysql:host=$hostname;dbname=$dbname", $user );
    }
    catch (PDOException $e) {
        echo "Errore: " . $e->getMessage();
        die();
    }


//registrazione di un utente
if (isset($_POST["reg_user"])) {
    

    if (empty($_POST["nickname"])) {
        array_push($errors, "Inserire nickname");
    }
    if (empty($_POST["password_1"])) {
        array_push($errors, "Inserire password");
    }
    if (empty($_POST["email"])||empty($_POST["citta"])||empty($_POST["datanascita"])){
        array_push($errors, "Dati mancanti");
    }
    if ($_POST["password_1"] != $_POST["password_2"]) {
        array_push($errors, "Le due password non corrispondono");
    }

    if (count($errors) == 0) {
        //cripto la password
        $tipo="Semplice";
        $nick= "diocane";

        $password = md5($_POST["password_1"]);
        $result=$db->prepare("CALL NuovoUtente(?,?,?,?,?,?)");
        $result->bindParam(1, $_POST["nickname"], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 20);
        $result->bindParam(2, $password, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 15);
        $result->bindParam(3, $_POST["datanascita"], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $result->bindParam(4, $_POST["citta"], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 20);
        $result->bindParam(5, $_POST["email"], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 250);
        $result->bindParam(6, $tipo, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);

        $result->execute();

        $message = "wrong answer";
    echo "<script type='text/javascript'>alert('$message');</script>";

        $_SESSION['nickname'] = $nick;
        $_SESSION['success'] = "You are now logged in";

        header('location: index.php');
    }
}
//
//    PDO::prepare


// ... 
// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}
?>