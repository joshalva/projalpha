#PROCEDURE CREATE

#1. REGISTRAZIONE UTENTE
		DELIMITER %%
			CREATE PROCEDURE NuovoUtente (IN nick VARCHAR(20),IN pass VARCHAR(20) ,IN datan DATE, IN cit VARCHAR(20), IN emailAdd VARCHAR(254),IN tip ENUM ('Semplice','Gestore'), OUT result VARCHAR(50) )
				BEGIN
		            START TRANSACTION;
		            	IF ((SELECT Nickname FROM ISCRITTO Where nick = Nickname)) THEN
		            		SET result = "Nick già in uso, non DISPONIBILE";
		            		SELECT ('Nickname gia in uso') AS '[ERRORE - NICK NON DISPONIBILE]';	            		
		            	ELSE
	                    	INSERT INTO ISCRITTO(Nickname,Password,DataNascita,Citta,Email,Tipo) VALUES(nick,pass,datan,cit,emailAdd,tip);
	                    	SET result = "Registrazione avvenuta con successo";
		            	END IF;
		            	commit;
		        END;
			%%
	    DELIMITER ;




		DELIMITER %%
			CREATE PROCEDURE NuovoGestore (IN nick VARCHAR(20),IN cit VARCHAR(20) ,IN nomeAtt VARCHAR(30), IN tel VARCHAR(12), IN codAvv VARCHAR(5),IN strada VARCHAR(50),IN civic VARCHAR(50), IN sito VARCHAR(50), OUT risposta VARCHAR(50))
				BEGIN
		            START TRANSACTION;
		            	
	                    INSERT INTO GESTORE(Nickname,Citta,NomeAttivita,Telefono,CAP,Via,Civico,SitoWeb) VALUES(nick,cit,nomeAtt,tel,codAvv,strada,civic,sito);

		            	commit;
		        END;
			%%
	    DELIMITER ;













#1.1 creazione citta 
			DELIMITER %%
			CREATE PROCEDURE NuovaCitta (IN cit VARCHAR(30),IN reg VARCHAR(20) ,IN paese VARCHAR(20), OUT risposta VARCHAR(50)) 
				BEGIN
		            START TRANSACTION;
		            	IF ((SELECT count(*) FROM CITTA Where (Nome = cit) AND (Regione=reg))!=0) THEN
		            		SET risposta = "La citta e' gia' presente nel sistema";	            		
		            	ELSE
	                    INSERT INTO CITTA(Nome,Regione,Stato) VALUES(cit,reg,paese);
	                    	SET risposta= "La tua citta' e' stata inserita con successo";
		            	END IF;
		            	commit;
		        END;
			%%
	    DELIMITER ;



#2. LOGIN UTENTE???

#3. INSERIMENTO ATTRATTIVA
			DELIMITER %%
			CREATE PROCEDURE NuovaAttrattiva (IN nomeAtt VARCHAR(20),IN city VARCHAR(20),IN strada VARCHAR(30) ,IN numciv VARCHAR(5), IN CodiceAvviamento INT(5), IN Lat FLOAT( 10, 6 ),IN Lon FLOAT( 10, 6 ), OUT risposta VARCHAR(50) )
				BEGIN
		            START TRANSACTION;
		            	IF 	((SELECT count(*) FROM ATTRATTIVA Where (Nome = nomeAtt) AND (Via = strada) AND (CAP=CodiceAvviamento) ) !=0) THEN
		            		SET risposta = "Attrattiva gia' in sistema");	            		
		            	ELSE
	                    INSERT INTO ATTRATTIVA(Nome,Citta,Via,Civico,CAP,Latitudine,Longitudine) VALUES (nomeAtt,city,strada,numciv,CodiceAvviamento,Lat,Lon);
	                    	SET risposta = "Attrattiva inserita con successo");
		            	END IF;
		            	commit;
		       END








#5. INVIO MESSAGGIO
			DELIMITER %%
				CREATE PROCEDURE NuovoMessaggio(IN Dest VARCHAR(30),IN Mitt VARCHAR(30), IN Tito VARCHAR(20), IN dataInv DATE, IN testo VARCHAR (3000), OUT risposta VARCHAR(50))  --inserisci mittente
					BEGIN
						START TRANSACTION; --mittente diverso da destinatario metti un if
							IF (Dest != Mitt) THEN
								INSERT INTO MESSAGGIO(Titolo,Data,Descrizione,Destinatario,Mittente) VALUES (Tito,NOW(),testo,Dest,Mitt);
							ELSE
								SET risposta = "Non puoi mandare un messaggio a te stesso";
							END IF;
							commit;
						END;
					%%
				DELIMITER; 


#6. COMMENTO ATTRATTIVA

		DELIMITER %%
				CREATE PROCEDURE NuovoCommento(IN nick VARCHAR(20),IN visibil ENUM('Pubblica','Privata'),IN dat DATE,IN voto ENUM('1','2','3','4','5'), IN idAtt INT, OUT rispsota VARCHAR(50) )
					BEGIN
						START TRANSACTION;
							INSERT