<?php

session_start();
$errorsalpha = array();
$infoSession = false;
$_SESSION['success'] = "";
//connessione al db
try {
    $hostname = "localhost";
    $dbname = "alpha";
    $user = "root";
    $dbalpha = new PDO("mysql:host=$hostname;dbname=$dbname", $user);
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
    die();
}

function updateSession() {
    $nick = $_POST["nickname"];
    $message = "wrong answer";
    echo "<script type='text/javascript'>alert('$message');</script>";
    $_SESSION['nickname'] = $nick;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.php');
}

//iscrizione generica
function setIscritto($t, $database) {
    global $errorsalpha;
    global $infoSession;
    $db = $database;
    if (empty($_POST["nickname"])) {
        array_push($errorsalpha, "Inserire nickname");
    }
    if (empty($_POST["password_1"])) {
        array_push($errorsalpha, "Inserire password");
    }
    if (empty($_POST["email"]) || empty($_POST["citta"]) || empty($_POST["datanascita"])) {
        array_push($errorsalpha, "Dati mancanti");
    }
    if ($_POST["password_1"] != $_POST["password_2"]) {
        array_push($errorsalpha, "Le due password non corrispondono");
    }
    if ($_POST["scelta"]=="presente") {
    	if (count($errorsalpha) == 0) {
    		
    			$tipo = $t;
        		$password =$_POST["password_1"];
        		$result = $db->prepare("CALL NuovoUtente(?,?,?,?,?,?,@esito)");
        		$result->bindParam(1, $_POST["nickname"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 20);
        		$result->bindParam(2, $password, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 15);
        		$result->bindParam(3, $_POST["datanascita"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
        		$result->bindParam(4, $_POST["citta"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 20);
        		$result->bindParam(5, $_POST["email"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 250);
        		$result->bindParam(6, $tipo, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
        		$result->execute();
        		$result->closeCursor();
                $risultato=$db->query("select @esito");
        		$row=$risultato->fetch(); 
                if ($row['@esito']==9){
           			$infoSession = true;    
        		} else {
            		array_push($errorsalpha, "Errore! Registrazione non valida!");
        		}	
    	}
	}
	else if($_POST["scelta"]=="nonpresente"){
		if (empty($_POST["newcity"]) || empty($_POST["regione"]) || empty($_POST["stato"])) {
        	array_push($errorsalpha, "Dati città mancanti");
    	}
    	if (count($errorsalpha) == 0) {
    		$cityquery=$db->prepare("INSERT INTO citta(Nome, Regione, Stato) VALUES ('".$_POST["newcity"]."', '".$_POST["regione"]."', '".$_POST["stato"]."')");
    		$cityquery->execute();
    		$tipo = $t;
        	$password =$_POST["password_1"];
        	$resultc = $db->prepare("CALL NuovoUtente(?,?,?,?,?,?,@esito)");
        	$resultc->bindParam(1, $_POST["nickname"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 20);
        	$resultc->bindParam(2, $password, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 15);
        	$resultc->bindParam(3, $_POST["datanascita"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
        	$resultc->bindParam(4, $_POST["newcity"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 20);
        	$resultc->bindParam(5, $_POST["email"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 250);
        	$resultc->bindParam(6, $tipo, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
        	$resultc->execute();
        	$resultc->closeCursor();
            $risultato=$db->query("select @esito");
        	$row=$risultato->fetch(); 
            if ($row['@esito']==9){
           		$infoSession = true;    
        	} else {
            	array_push($errorsalpha, "Errore! Registrazione non valida!");
        	}
    	}
	}
}

//registrazixone utente semplice
if (isset($_POST["reg_user"])) {
    setIscritto('Semplice', $dbalpha);
    if ($infoSession == true) {
        updateSession();
    }
}
//registrazione utente gestore
if (isset($_POST["sub_gestore"])) {
    //$errori=$errorsalpha;
    $data = $dbalpha;
    if (empty($_POST["nomeAtt"])) {
        array_push($errorsalpha, "Inserire nome dell'attivita");
    }
    if (empty($_POST["tel"])) {
        array_push($errorsalpha, "Inserire numero di telefono");
    }
    if (empty($_POST["codAvv"])) {
        array_push($errorsalpha, "Inserire CAP");
    }
    if (empty($_POST["via"])) {
        array_push($errorsalpha, "Inserire via");
    }
    if (empty($_POST["civico"])) {
        array_push($errorsalpha, "Inserire numero civico");
    }
    if (empty($_POST["sitoweb"])) {
        array_push($errorsalpha, "Inserire sito web");
    }
    if (count($errorsalpha) == 0) {
        setIscritto('Gestore', $dbalpha);
        if ($infoSession == true) {
            $result = $data->prepare("CALL NuovoGestore(?,?,?,?,?,?,?,?)");
            $result->bindParam(1, $_POST["nickname"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 20);
            $result->bindParam(2, $_POST["citta"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 20);
            $result->bindParam(3, $_POST["nomeAtt"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 30);
            $result->bindParam(4, $_POST["tel"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 12);
            $result->bindParam(5, $_POST["codAvv"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 5);
            $result->bindParam(6, $_POST["via"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $result->bindParam(7, $_POST["civico"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $result->bindParam(8, $_POST["sitoweb"], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $result->execute();
            $nick = $_POST["nickname"];
            $message = "wrong answer";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $_SESSION['nickname'] = $nick;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }
    }
}

//login di un utente
if (isset($_POST['login_user'])) {
    if (empty($_POST["nick"]) || empty($_POST["psw"])) {
        array_push($errorsalpha, "Dati di login mancanti");
    }
    //DA MYSQLI A PDO
    $name = $_POST["nick"];
    $pass=$_POST["psw"];
    $query = $dbalpha->prepare("SELECT Nickname,Password FROM iscritto WHERE (Nickname=:nick) AND (Password=:pass)");
    $query->bindParam("nick", $name, PDO::PARAM_STR);
    $query->bindParam("pass", $pass, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $provaCaso = $query->fetch(PDO::FETCH_OBJ);
        $_SESSION['nickname'] = $name;
        $_SESSION['success'] = "You are now logged in " + $provaCaso;
        header('location: index.php');
    } else {
        $message = "wrong answer";
        $cacca=$query->rowCount();
        echo "<script type='text/javascript'>alert('$pass'+ non valida);</script>";
    }

//    foreach ($ris as $row) {
//        if($row['nickname']==$name && $row['password']==$psw){
//            $_SESSION['nickname'] = $name;
//            $_SESSION['success'] = "You are now logged in";
//            header('location: index.php');
//        }
//        else{
//            $message = "wrong answer";
//            echo "<script type='text/javascript'>alert('$message');</script>";
//            break;
//        }
//    }
//    
//    if (count($errors) == 0) {
//        $password = md5($password);
//        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
//        $results = mysqli_query($db, $query);
//
//        if (mysqli_num_rows($results) == 1) {
//            $_SESSION['username'] = $username;
//            $_SESSION['success'] = "You are now logged in";
//            header('location: index.php');
//        } else {
//            array_push($errors, "Wrong username/password combination");
//        }
//    }
}
?>