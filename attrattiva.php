<?php session_start(); ?>
<html>
	<?php
		//connetto al database
		try {
    		$hostname = "localhost";
    		$dbname = "alpha";
    		$user = "root";
    		$database = new PDO("mysql:host=$hostname;dbname=$dbname", $user);
		} catch (PDOException $e) {
    		echo "Errore: " . $e->getMessage();
    		die();
		}
	?>
	<head>
		<style>
			.nomeAtt { grid-area: nomeattrattiva; }
			.tipoAtt { grid-area: tipoattrattiva; }
			.valutazione { grid-area: valutazione; }
			.fotoAtt { grid-area: fotoattrattiva; }
			.descrizione { grid-area: descrizione; }
			.footer { grid-area: footer; }

			.grid-container1 {
				margin-top: 50px;
				width: 100%;
  				display: grid;
  				grid-template-rows: 1fr 1fr 1fr;
  				grid-template-columns:1fr 1fr 1fr 1fr 1fr 1fr;
  				grid-template-areas:
    				'nomeattrattiva nomeattrattiva tipoattrattiva tipoattrattiva valutazione valutazione'
    				'fotoattrattiva fotoattrattiva descrizione descrizione descrizione descrizione'
    				'footer footer footer footer footer footer';
 			 	grid-gap: 0.3rem;
  				background-color: #2196F3;
  				padding: 0px;
			}
			.grid-container1 > div {
  				background-color: rgba(255, 255, 255, 0.8);
  				text-align: center;
  				padding: 20px 0;
  				font-size: 30px;
			}
		</style>
		<?php
			//ottengo la citta dell'utente in sessione
			$city = $database->prepare("SELECT citta FROM iscritto WHERE Nickname ='" .$_SESSION['nickname']."'");
        	$city->execute();
        	$citta=$city->fetch();
        	print '<title> Attrattiva in '.$citta['citta'].'</title>';
		?>
    	<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="navcont">
            <nav id="navbar">
                <ul>
                    <li id="nav1"><a href="index.php"><img src="images/logohome.PNG" alt="logo" width="100px" height="50px"></a></li>
                    <li id="nav2"><em>Attrattiva - <strong>"NOMEATTRATTIVA"</strong></em></li>
                    <li id="nav3"><img id="userph" src="images/user.png" width="45px" height="45px" ></li>
                </ul>
            </nav>
        </div>
        <div class="grid-container1">
        	<div class="nomeAtt">"NOMEATTRATTIVA"</div>
  			<div class="tipoAtt">"TIPOATTRATTIVA"</div>
  			<div class="valutazione">"VALUTAZIONE"</div>  
  			<div class="fotoAtt">"FOTO"</div>
  			<div class="descrizione">"DESCRIZIONE"</div>
  			<div class="footer">FOOTER (commenti)</div>
        </div>
	</body>
</html>
