<?php
try {
    $hostname = "localhost";
    $dbname = "alpha";
    $user = "root";
    $dbalpha = new PDO("mysql:host=$hostname;dbname=$dbname", $user);
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
    die();
}

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
        <link rel="stylesheet" type="text/css" href="newstyle.css">
    </head>
    <body>
        <div class="grid-container">
            <div class="navcont">
                <nav id="navbar">
                    <ul>
                        <li id="nav1"><a href="index.php"><img src="images/logohome.PNG" alt="logo" width="100px" height="50px"></a></li>
                        <li id="nav2"><em>Benvenuto<strong> <?php echo $_SESSION['nickname']; ?></strong>!</em></li>
                        <li id="nav3"><img id="userph" src="images/user.png" width="45px" height="45px" ></li>
                    </ul>
                </nav>
            </div>
        
            <div class="fotoMid">  
                <h1 id="titlehome"><em>Choose your destination</em></h1>
                <form action="/action_page.php" method ='POST'>City name!<br>
                    <input type="text" name="nomecitta">
                </form>
            </div>
       
            <div class="grid-item sideCont">   
                  <?php
                  //recupero la citta' dell'utente
                    $city = $dbalpha->prepare("SELECT citta FROM iscritto WHERE Nickname ='" .$_SESSION['nickname']."'");
                    $city->execute();
                    $citta=$city->fetch();
                   //ricerco gli eventi
                  $events = $dbalpha->prepare("SELECT id,titolo,datainizio,organizzatore FROM evento WHERE organizzatore IN (SELECT nickname FROM gestore WHERE citta ='" . $citta['citta'] . "') LIMIT 5 ");
                      $events->execute();
                      $result=$events->fetchAll(PDO::FETCH_ASSOC);        
                      foreach($result as $row){
                          $idE=$row['id'];
                          $titolo=$row['titolo'];
                        $data=$row['datainizio'];
                        $organizzatore=$row['organizzatore'];
                        $riga='<p>'.$titolo.'   '.$data.'    '.$organizzatore.' </p>';
                          print $riga;
                      }
                  ?>
            </div>
              <div class="grid-item fotoTopGrid">2
                    
            
            
            </div>
              <div class="grid-item contentSx">3</div>
              <div class="grid-item contentDx">4 <?php
                  //recupero la citta' dell'utente
                    $city = $dbalpha->prepare("SELECT citta FROM iscritto WHERE Nickname ='" .$_SESSION['nickname']."'");
                    $city->execute();
                    $citta=$city->fetch();
                   //ricerco le attrattive piu popolari
                  $events = $dbalpha->prepare("SELECT id,titolo,datainizio,organizzatore FROM evento WHERE organizzatore IN (SELECT nickname FROM gestore WHERE citta ='" . $citta['citta'] . "') LIMIT 5 ");
                      $events->execute();
                      $result=$events->fetchAll(PDO::FETCH_ASSOC);
                    
                      foreach($result as $row){
                          $idE=$row['id'];
                          $titolo=$row['titolo'];
                        $data=$row['datainizio'];
                        $organizzatore=$row['organizzatore'];
                        $riga='<p>'.$titolo.'   '.$data.'    '.$organizzatore.' </p>';
                          print $riga;
                      }
                  ?></div>
        
    </div> 
<!--        chiudo il grid container-->
        
        
        <div class="content">    
<!--     php closing       -->
            
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