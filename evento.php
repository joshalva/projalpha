	<?php include('server.php') ?>
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
        <title>SeeMyCity - <?php echo $_SESSION['cittaUtente']; ?></title>
        <link rel="stylesheet" type="text/css" href="style.css">
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    </head>
    <body>
        <div class="grid-container-citta">
            <div class="navcont">
                <nav id="navbar">
                    <ul>
                        <li id="nav1"><a href="index.php"><img src="images/logohome.PNG" alt="logo" width="100px" height="50px"></a></li>
                        <li id="nav2"><?php 
                                    $q=$dbalpha->prepare("SELECT * from Evento where id = '" .$_GET['idEv']."'" );
                                    $q->execute();
                                    $result=$q->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($result as $row){
                                        $titolo=$row['Titolo'];
                                        $orario=$row['Orario'];
                                        $dataIn=$row['DataInizio'];
                                        $organizzatore=$row['Organizzatore'];
                                        $capacita=$row['Capacita'];
                                        $riga='<p>'.$titolo.'</p>';
                                        print $riga;
                                    }?>
                        </li>
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
        
            <div class="fotoEv" style="background-image:url(images/eventi.jpg)">                
            </div>
       
            <div class="grid-item contentTopSx">   
                  <?php
                    print '<p>Data inizio evento:<br> '.$dataIn.'</p>';
                  ?>
            </div>
              <div class="grid-item fotoTopDx">
                    <?php
                    print '<p>Orario :<br> '.$orario.'</p>';
                  ?>
            
            
            </div>
              <div class="grid-item fotoMidSx">
                    <?php
                  print '<p>Capacita: <br> ' .$capacita. '</p>';
                  ?>
            </div>
              <div class="grid-item contentMidDx">4 <?php
                 print '<p>Organizzatore: <br>' .$organizzatore. '</p>';
                  ?></div>            
              <div class="grid-item contentBot">
                        Partecipanti all'evento:
                          <?php
                                $q=$dbalpha->prepare("SELECT count(*) AS conto from partecipazione where IdEvento = '" .$_GET['idEv']."'" );
                                $q->execute();
                                $result=$q->fetchAll();
                                foreach($result as $row){
                                    $conto=$row['conto'];
                                }
                                if(empty($conto)){
                                        print "Non si è ancora iscritto nessuno!<br> Iscriviti tu per primo all'evento!";   
                                    }else{
                                        $q=$dbalpha->prepare("SELECT NickUtente from partecipazione where IdEvento = '" .$_GET['idEv']."'" );
                                        $q->execute();
                                        $result=$q->fetchAll();
                                        foreach($result as $row){
                                            $nickU=$row['NickUtente'];
                                            $riga='<p>' .$nickU. '</p>';
                                            print $riga;
                                        }            
                                    }
                          
                                $q=$dbalpha->prepare("SELECT count(*) as conto from partecipazione where IdEvento = '" .$_GET['idEv']. "' AND NickUtente='".$_SESSION['nickname']."' ");
                                $q->execute();
                                $result=$q->fetchAll();
                                    foreach($result as $row){
                                        $presenza=$row['conto'];
                                    }
                                if($presenza==0){
                                   if($conto<$capacita){
                                        print '<br><button type="button" name="subEvent">Iscriviti all evento!</button>';
                                        //inserisci il collegamento alla chiamata del db per iscrivere all-evento
                                    }                                
                                }else{
                                    print '<br><button type="button" name="unsubEvent">Disicriviti all evento, sfigato</button>';
                                }
                          ?>
                          
                        </div>    
    </div> 



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