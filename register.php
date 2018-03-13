<?php include('server.php') ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registration system PHP and MySQL</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <script>
                        $("#gestore").hide();
        </script>        
        
        <div class="header">
            <h2>Register</h2>
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
            <div class="input-group">
                <label>Citt&agrave</label>
                <input type="text" name="citta" >
            </div>
            <div class="input-group">
                <label>Data di nascita</label>
                <input type="date" name="datanascita" value="<?php echo $datanascita; ?>">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_1">
            </div >
            <div class="input-group">
                <label>Confirm password</label>
                <input type="password" name="password_2">
            </div>
            <div class="input-group"  >
                <label>Scegli il tuo tipo di account!!!</label>
                <select name='type' id='type' style="display: inline-block;margin-left: 40%;" >
                        <option value='semplice' >Semplice</option>
                        <option value='gestore' >Gestore</option>
                </select>   
            </div>
            <div class="input-group" style="display: inline-block;margin-left: 40%;">
                <button type="submit" class="btn" id="reg_user" name="reg_user">Register</button>
            </div>
            
            <div id="gestore">
                 <p > <b>Inserisci i dati della tua attivit&agrave;!</b></p>
                
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
                    <label>SitoWeb</label>
                    <input type="text" name="sitoweb" >
                </div>  
                <div class="input-group" style="display: inline-block;margin-left: 40%;">
                    <button type="submit" class="btn" name="sub_gestore">Submit</button>
                </div>
            </div>


            <p style="font-size: 9px;float: right;">
                Already a member? <a href="login.php">Sign in</a>
            </p>    
    
           
<!--
<form id="form-shower">
<select id="myselect">
<option value="form_name1">Form 1</option>
<option value="form_name2">Form 2</option>
<option value="form_name3">Form 3</option>
</select>
</form>
-->

<form name="semplice" id="semplice" style="display:none">
</form>

<!--
<form name="gestore" id="gestore" style="display:none">
    <p >Inserisci i dati della tua attivit&agrave;!</p>
    
    <?//php include('errors.php'); ?>

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
                <label>SitoWeb</label>
                <input type="text" name="sitoweb" >
            </div>  
            <div class="input-group" style="display: inline-block;margin-left: 40%;">
                <button type="submit" class="btn" name="sub_gestore">Submit</button>
            </div>
    
</form>
-->

<script>
$("#type").on("change", function() {
    
    if($('#type').val() == 'semplice') {
          
        
            $("#form1")[0].scrollIntoView({
                behavior:"smooth",
                block:"start"
            });
            $("#gestore").hide(); 
            $("reg_user").show();
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


            

        </form>
        

        
    </body>
</html>