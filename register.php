<?php include('server.php') ?>

<!DOCTYPE html>
<html>
    <head>
        <title>SeeMyCity - registrazione utente</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body style="background: url(images/sfondologin.jpg) no-repeat center center fixed;
        -moz-background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        background-attachment:fixed;">
        
        <script>
            window.onload = function() {
                  $("#gestore").hide();
                  $("#show-me").hide();
            };

        </script>        
        
        <div class="header">
            <h2>Registrazione</h2>
        </div>

        <form method="post" id="form1" action="register.php">

            <?php include('errors.php'); ?>

            <div class="input-group">
                <label>Nickname</label>
                <input type="text" name="nickname">
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email">
            </div>
            <div class="input-group" id="cities">
                <label>Citt&agrave</label>
                <select name="citta">
                <?php
                    try {
                        $hostname = "localhost";
                        $dbname = "alpha";
                        $user = "root";
                        $connection = new PDO("mysql:host=$hostname;dbname=$dbname", $user);
                    } catch (PDOException $e) {
                        echo "Errore: " . $e->getMessage();
                        die();
                    }
                    $option="";
                    $city = $connection->prepare("SELECT nome FROM citta");
                    $city->execute();
                    $result = $city->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $row){
                        $id = $row['nome'];
                        $option='<option value="'.$id.'">'.$id.'</option>';
                        print $option;
                    }
                ?>
                </select>
            </div>
            <p style="font-size: 12px; float: right;">
                Citt&agrave non presente <input type="radio" name="scelta" id="watch-me" value="nonpresente"> Citt&agrave presente <input type="radio" name="scelta" value="presente" checked>
                </p>
            <div class="input-group" id="show-me">
                <label>Citta</label>
                <input type="text" name="newcity">
                <label>Regione</label>
                <input type="text" name="regione">
                <label>Stato</label>
                <input type="text" name="stato">
            </div>
            <div class="input-group">
                <label>Data di nascita</label>
                <input type="date" name="datanascita">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_1">
            </div >
            <div class="input-group">
                <label>Conferma password</label>
                <input type="password" name="password_2">
            </div>
            <div class="input-group"  >
                <label>Scegli il tuo tipo di account</label>
                <select name='type' id='type' style="display: inline-block;margin-left: 40%;" >
                        <option value='semplice' >Semplice</option>
                        <option value='gestore' >Gestore</option>
                </select>   
            </div>
            <div class="input-group" style="display: inline-block;margin-left: 40%;">
                <button type="submit" class="btn" id="reg_user" name="reg_user">Registrati</button>
            </div>
            
            <div id="gestore">
                 <p><b>Inserisci i dati della tua attivit&agrave;</b></p>
                
                <div class="input-group">
                    <label>Nome Attivita</label>
                    <input type="text" name="nomeAtt">
                </div>
                <div class="input-group">
                    <label>Telefono</label>
                    <input type="text" name="tel">
                </div>
                <div class="input-group">
                    <label>CAP</label>
                    <input type="text" name="codAvv" >
                </div>      
                <div class="input-group">
                    <label>Via</label>
                    <input type="text" name="via" >
                </div>      
                <div class="input-group">
                    <label>Civico</label>
                    <input type="text" name="civico" >
                </div>      
                <div class="input-group">
                    <label>Sito Web</label>
                    <input type="text" name="sitoweb" >
                </div>  
                <div class="input-group" style="display: inline-block;margin-left: 40%;">
                    <button type="submit" class="btn" name="sub_gestore">Registrati</button>
                </div>
            </div>


            <p style="font-size: 9px;float: right;">
                Sei gi&agrave; iscritto? <a href="login.php">Sign in</a>
            </p>    
    
           

<form name="semplice" id="semplice" style="display:none">
</form>


<script type="text/javascript">
$("#type").on("change", function() {
    
    if($('#type').val() == 'semplice') {
          
        
            $("#form1")[0].scrollIntoView({
                behavior:"smooth",
                block:"start"
            });
            $("#gestore").hide(); 
            $("#reg_user").show();
        } else {
            
            
            
              $("#" + $(this).val()).show();
            $("#gestore")[0].scrollIntoView({
                behavior:"smooth",
                block:"end"
            });
            $("#reg_user").hide();
                 
        } 
})
</script>
<script type="text/javascript">
    $(document).ready(function() {
   $('input[type="radio"]').click(function() {
       if($(this).attr('id') == 'watch-me') {
            $('#show-me').show();   
            $('#cities').hide();        
       }

       else {
            $('#show-me').hide();
            $('#cities').show();  
       }
   });
});
</script>
        </form>
    </body>
</html>