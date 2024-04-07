<?php
session_start();
require('fileConnessione.php');
$myPassword='';
$messagePsw='';
$messageCk='';
function resistenzaPassword($myPassword){
	if(mb_strlen($myPassword)>=8 && preg_match('/[A-Z]/', $myPassword) && preg_match('/[a-z]/', $myPassword) && preg_match('/[0-9]/', $myPassword)){
		return true;
	}else{
		return false;
	}
}
if(isset($_POST['register'])){
	$name = mysqli_real_escape_string($conn, $_POST['myName']);
	$surName = mysqli_real_escape_string($conn, $_POST['mySurname']);
	$myUser = mysqli_real_escape_string($conn, $_POST['myUser']);
	$myPassword = mysqli_real_escape_string($conn, $_POST['myPassword']);
	$valid= resistenzaPassword($myPassword);
	$messagePsw = $valid ? 'Password Valida' : 'Password Non Valida';
	if(empty($name) || empty($surName) || empty($myUser) || empty($myPassword)){
		echo "Compila i campi richiesti !"."<br>";
	}else{
		htmlspecialchars($name);
		htmlspecialchars($surName);
		htmlspecialchars($myUser);
		htmlspecialchars($myPassword); // $valid ???		
		//htmlspecialchars($valid); 
		$queryVer = "SELECT utenti.id FROM utenti WHERE username = '".$myUser."'";		
		$resultVer = mysqli_query($conn,$queryVer);
		if(mysqli_num_rows($resultVer) > 0){
			echo "<h3<user already exists</h3>";
		}else{		
			if(!$valid){
			   echo '<h3>'.$messagePsw.'</h3>';
				}else{
			      $passHash =hash('sha256',$myPassword); // $valid ????											
			      $queryIns = "INSERT INTO utenti (id,nome,cognome,username,password) VALUES(NULL,'$name','$surName','$myUser','$passHash')";						
			      if(mysqli_query($conn,$queryIns)){					
				    $_SESSION['myUser']= $myUser;				
			        header("Location:fileSession.php"); 
			      //header("Location:chatConAjax.php"); // bisogna gestire una session_destroy() per evitare che il login automatico lo faccia con il dato in sessione.			    
			         }else{
				       echo "There was a problem ! Try again !";
			        }
			   }		   
		 }
	}
	/*$remember = (isset($_POST['remember']) && $_POST['remember']== true) ? true : false;
	$ookie = $remember ? $_COOKIE['myUser'] : '';
	setcookie('myUser',$myUser,time()+60*60,'/','',false,true);*/
$msgWelcome = "$name $surName si è aggiunto alla chat";
$queryVer1 = "SELECT utenti.id FROM utenti WHERE username = '".$myUser."'";
$resultVer1 = mysqli_query($conn,$queryVer1);
$row = mysqli_fetch_array($resultVer1,MYSQLI_BOTH);
$idNuovo = $row['id'];
$arrDest = [];
$queryVer3 = "SELECT DISTINCT tabella_messaggi.idDestinatario FROM tabella_messaggi INNER JOIN utenti ON tabella_messaggi.idDestinatario=utenti.id";
$resultVer3 = mysqli_query($conn,$queryVer3);
while($row = mysqli_fetch_array($resultVer3,MYSQLI_BOTH)){ 
		//echo $row['idDestinatario']."<br>";
		$idDest = $row['idDestinatario'];
		array_push($arrDest,$idDest);				
	} // ho tutti gli idDestinatario DISTINCT
foreach($arrDest as $destinatario){
  $stmt3 = $conn->prepare("INSERT INTO tabella_messaggi (testo, idMittente, idDestinatario, letto, ricevuto) VALUES('$msgWelcome',$idNuovo,$destinatario,0,1)");
  $stmt3->execute();	
	}
$arrMitt = [];
$queryVer4 = "SELECT DISTINCT tabella_messaggi.idMittente FROM tabella_messaggi INNER JOIN utenti ON tabella_messaggi.idMittente=utenti.id";
$resultVer4 = mysqli_query($conn,$queryVer4);	
while($row = mysqli_fetch_array($resultVer4,MYSQLI_BOTH)){ 
	//echo $row['idMittente']."<br>";
	$idMitt = $row['idMittente'];
	array_push($arrMitt,$idMitt);	
} // ho tutti gli idMittente DISTINCT
foreach($arrMitt as $mittente){
	$stmt4 = $conn->prepare("INSERT INTO tabella_messaggi (idMittente, idDestinatario, letto, ricevuto) VALUES($mittente,$idNuovo,1,0)");
    $stmt4->execute();
   }	
// con questa query i nuovi registrati riescono a vedere tutti i contatti (ho modificato il campo testo impostando NULL)
}	
?>
<!doctype html>
<html>
<head>
<title>Register</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial scale=1.0">
<link href="../bootstrap/bootstrap-grid.css" rel="stylesheet"></link>
<link href="../bootstrap/bootstrap.min.css" rel="stylesheet"></link>
<link href="../bootstrap/bootstrap.css" rel="stylesheet"></link>
<script src="bootstrap.js"></script>
<style>
	body {
		margin: 0;
		background-color:#a2a6aa;
		align-content:center;
		}
	.form-control{
		width:400px;
	}
</style>
</head>
<body>
	<form method="POST" action="">
	<!-- Nome input -->
	<div class="form-outline mb-4">
    <input type="text" name='myName' id="form2Example1" class="form-control"/>
    <label class="form-label" for="form2Example1">Your Name</label>
  </div>
  <!-- Cognome input -->
	<div class="form-outline mb-4">
    <input type="text" name='mySurname' id="form2Example1" class="form-control"/>
    <label class="form-label" for="form2Example1">Your Surname</label>
  </div>
  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="text" name='myUser' id="form2Example1" class="form-control" />
    <label class="form-label" for="form2Example1">Your user</label>
  </div>
  <!-- Password input -->
  <div class="form-outline mb-4">
    <input type="password" name ='myPassword' id="form2Example2" class="form-control" />
    <label class="form-label" for="form2Example2">Password</label>
  </div>
  <div class="row mb-4">
    <div class="col d-flex justify-content-center">
      <!-- Checkbox -->
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name='remember' value="true" id="form2Example31" checked />
        <label class="form-check-label" for="form2Example31"> Remember me </label>
      </div>
    </div>
    <div class="col">
      <a href="#!">Forgot password?</a>
    </div>
  </div>
  <!-- Submit button -->
  <input type="submit" name ='register' class="btn btn-primary btn-block mb-4" value="Register">
</form>
</body>
</html>