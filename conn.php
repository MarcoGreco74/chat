<?php
$type = 'mysql';
$server = 'localhost';
$db = 'dati_utenti';
$port = '3306';
$charset = 'utf8mb4'; // nel DB è utf8mb4_unicode_ci
//$dsn = "$type:host=$server;dbname=$db;port=$port;charset=$charset";
$dsn = "$type:host=$server;dbname=$db";
$username = 'root';         
$password = 'vanigliaecacao';         
$options = [             // facoltativi           
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, // dice come gestire gli errori incontrati dall'oggetto PDO e lancia un oggetto eccezione. Di default da PHP 8.
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, // dice al PDO come rendere disponibile ogni riga di un set di risultati
    PDO::ATTR_EMULATE_PREPARES=>false, // controlla la modalita di emulazione. False per garantire che i tipi per numeri interi del DB vengano restituiti come INT nel PHP. SE true invece come stringa.
]; 

try{
$conn = new PDO($dsn, $username, $password, $options);
//$conn = new PDO($dsn, $username, $password);
	}
catch(PDOException $e){
	 //echo $e->getMessage();
	 throw new PDOException($e->getMessage(), $e->getLine());
	}

///////////////
// esempio di una query
/*try{
   //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // nel caso non fossero aggiunte come parametro nell'istanza dell'oggetto PDO.
	$stmt = $conn->prepare("SELECT uName, uPass, LivelloUser FROM users WHERE uName = :user and AttivazioneAccount=true");
	$stmt->bindParam(':user',$user,PDO::PARAM_STR);
	$stmt->execute();
  //set the resulting array to associative
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
	foreach($stmt->fetchAll() as $k) {
  //Gestione della data da inglese ad italiano
	$password=$k['uPass'];
	$profilo=$k['LivelloUser'];
		}
	}
catch(PDOException $e){
  // notifica in caso di errore nel tentativo di connessione
  echo $e->getMessage();
}*/
/*
$stmt1 = $connessione->prepare("SELECT * FROM users where Uid=$IDaziendaPromo and Cap_att=$cap");
								$stmt1->execute();
								//Reupero foto e denominazione del locale
								$stmt1->setFetchMode(PDO::FETCH_ASSOC); 																																					
								foreach($stmt1->fetchAll() as $k1){	
									//Dati da tabella users
									$idutente=$IDaziendaPromo; 
								}
*/

/*
try{
				// Apro la connessione PDO
				$connessione = new PDO("mysql:host=$host;dbname=$db", $user, $password);
				$connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				// prepare sql and bind parameters

				$STH = $connessione->prepare("INSERT INTO users(Uname, Upass, CryptoPass, Nome, Cognome, Email, LivelloUser, CryptActivate, AttivazioneAccount) VALUES (:Uname, :Upass, :CryptoPass, :Nome, :Cognome, :Email, :LivelloUser, :CryptActivate, :AttivazioneAccount)");
				$STH->bindParam(':Uname', $username_);
				$STH->bindParam(':Upass', $strEncryptedPassword_);
				$STH->bindParam(':CryptoPass', $CryptoPass_);
				$STH->bindParam(':Nome', $nome_);
				$STH->bindParam(':Cognome', $cognome_);
				$STH->bindParam(':Email', $email_);
				$STH->bindParam(':LivelloUser', $LivelloUser_);
				$STH->bindParam(':CryptActivate', $attivazione_);
				$STH->bindParam(':AttivazioneAccount', $attivazioneDef_);
				$username_ = $email;
				$strEncryptedPassword_ = $strEncryptedPassword;
				$CryptoPass_ = 'MD5';
				$nome_ = $nome;
				$cognome_ = $cognome;
				$email_ = $email;
				$LivelloUser_ = 2;
				$attivazione_ = $strEncryptedPassword;
				$attivazioneDef_ = 1;
				$STH->execute();
				echo "Eseguito inserimento";
				$LAST_ID = $connessione->lastInsertId();
		
	}

catch(PDOException $e){

		// echo "Error: " . $e->getMessage();

	}
*/
?>
