	<?php include('server.php') ?>
<?php
//try {
//    $hostname = "localhost";
//    $dbname = "alpha";
//    $user = "root";
//    $dbalpha = new PDO("mysql:host=$hostname;dbname=$dbname", $user);
//} catch (PDOException $e) {
////    echo "Errore: " . $e->getMessage();
////    die();
//}

//session_start();

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
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css">
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script> 
    </head>
    <body>
        <div class="grid-container">
            <div class="navcont">
                <nav id="navbar">
                    <ul>
                        <li id="nav1"><a href="index.php"><img src="images/logohome.PNG" alt="logo" width="100px" height="50px"></a></li>
                        <li id="nav2"><em>Benvenuto<strong> <?php echo $_SESSION['nickname']; ?></strong>!</em></li>
                        <li id="nav3"><div class="dropdown">
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
        
            <div class="fotoMid" class="ui-widget" >  
                <h1 id="titlehome"><em>Choose your destination</em></h1>
                <form id="citySearch"  action="server.php" method ='POST'>
                    <input type="text" class="autoC ui-autocomplete-input" placeholder="Insert here!" name="nomeCitta" id="nomeCitta" >
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
                        $riga='<p><a href="evento.php?idEv='.$idE.'">'.$titolo.'</a>   '.$data.'    '.$organizzatore.' </p>';
                          print $riga;
                      }
                  ?>
            </div>
              <div class="grid-item fotoTopGrid">
                    
            
            
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
                        $riga='<p><a link="evento.php?idEv='.$idE.'">'.$titolo.'</a>   '.$data.'    '.$organizzatore.' </p>';
                          print $riga;
                      }
                  ?></div>
        
    </div> 
<!--        chiudo il grid container-->
        
      
         <script>
            function myFunction() {
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
            }
                
                $(document).ready(function() {
                    //autocomplete
                    $(".autoC").autocomplete({
                        source: "server.php",
                        minLength: 1
                    });				
                });
        </script>
        
        
    </body>
</html>