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
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    </head>
    <body>
        <div class="grid-container-citta">
            <div class="navcont">
                <nav id="navbar">
                    <ul>
                        <li id="nav1"><a href="index.php"><img src="images/logohome.PNG" alt="logo" width="100px" height="50px"></a></li>
                        <li id="nav2"><em>Benvenuto<strong> <?php echo $_SESSION['nickname']; ?></strong>!</em></li>
                        <li id="nav3"> 
                            <div class="dropdown">
                              <button onclick="myFunction()" class="dropbtn"></button>
                                  <div id="myDropdown" class="dropdown-content">
                                        <a href="#">Link 1</a>
                                        <a href="#">Link 2</a>
                                        <div>            
                                            <!-- logged in user information -->
                                            <?php if (isset($_SESSION['nickname'])) : ?>
                                                <a href="index.php?logout='1'" style="color: red;">logout</a>
                                            <?php endif ?>
                                        </div>
                                  </div>
                            </div> 
                        </li>
                    </ul>
                </nav>
            </div>
        
            <div class="fotoMid">  
                <h1 id="titlehome"><em>Nome della citta con foto della città </em></h1>
                
            </div>
       
            <div class="grid-item contentTopSx">   Lista 5 attrattive più popolari in citta selezionata
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
              <div class="grid-item fotoTopDx"> foto della prima attrattiva della lista accanto
            </div>
              <div class="grid-item fotoMidSx">foto citta random</div>
              <div class="grid-item contentMidDx">eventi della citta <?php
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
                      <div class="grid-item contentBot">lista percorsi piu popolari. in ogni div con liste va implementato bottone per visione di tutto l'elenco completo</div>    
    </div> 
<!--        chiudo il grid container-->
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

        


        <script>function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
} </script>
        
    </body>
</html>
