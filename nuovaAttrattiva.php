<?php include('server.php') ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add new attrattiva</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKeZsMmhJzgfgSFFsSzvjIjfsRrt8sSzY" type="text/javascript"></script> 
        

    </head>
    

    <body>
        <div class="header">
            <h2>Insert new Attrattiva</h2>
        </div>

        <form method="post" id="form1" action="nuovaAttrattiva.php">

            <?php include('errors.php'); ?>

            <div class="input-group">
                <label>Nome Attrattiva</label>
                <input type="text" name="nomeAtt">
            </div>
            <div class="input-group">
                <label>Via</label>
                <input type="text" name="via" id="via">
            </div>
            <div class="input-group">
                <label>Civico</label>
                <input type="text" name="civico" id="civico">
            </div>
            <div class="input-group">
                <label>CAP</label>
                <input type="int" name="codAvv" id="codAvv">
            </div>
     
            
            <div class="input-group" style="display: inline-block;margin-left: 40%;">
                <button type="button" class="btn" name="insert" id="insert" >Insert</button>
            </div>         

        </form>
        
            !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        ///!!!!!!!!!!!!!!!FUNZIONA CAZZOO!!!!!!!!!!!!!!
        !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            <script>  
            $("#insert").click(function() {   
                    
                
                //creazione di una stringa composta 
                    var input_address = $("#via").val() + " "+$("#civico").val() + " "+ $("#codAvv").val();  
                    console.log(input_address);
                    var geocoder = new google.maps.Geocoder();  
                    geocoder.geocode( { address: input_address }, function(results, status) {  
                        if (status == google.maps.GeocoderStatus.OK) {  
                            var lat = results[0].geometry.location.lat();  
                            var lng = results[0].geometry.location.lng();  
                            alert(lat + ' ' + lng);
                            alert.show();                            }  
                        else {  
                            alert("Google Maps not found address!");  
                            alert.show();
                            }  
                        });  
                    });   
        </script>  
        
        
        
    </body>
    
    
    
</html>