<?php
session_start();
require('fileConnessione.php');
///////////////
if(isset($_POST['login'])){	
	$user = mysqli_real_escape_string($conn, $_POST['myUser']);
	$passWord = mysqli_real_escape_string($conn, $_POST['myPassword']);
	if(empty($user) || empty($passWord)){
		echo "Compila i campi richiesti !"."<br>";
	}else{
		$myUser = htmlspecialchars($user);
		$myPassword = htmlspecialchars($passWord);
		$passHash = hash('sha256',$myPassword);
		$queryLI="SELECT * FROM utenti WHERE username='$myUser' AND password='$passHash' " ;
		$resultLI = mysqli_query($conn,$queryLI);
		if(mysqli_num_rows($resultLI)!=0){
		while($row=mysqli_fetch_array($resultLI,MYSQLI_BOTH)){	
		    $_SESSION['id_contatto'] = $row['id'];			
			$_SESSION['myUser'] = $row['username'];
			$_SESSION['myName'] = $row['nome'];
	        $_SESSION['mySurname'] = $row['cognome'];			
			if($_SESSION['myUser']){
	        header("Location:chatConAjax.php");
	            }				
			}	
		}else{
		  echo '<h3>User o password errati</h3>';
		}
	}
	/*$remember = (isset($_POST['remember']) && $_POST['remember']== true) ? true : false;
	$ookie = $remember ? $_COOKIE['myPassword'] : '';
	setcookie('myUser',$myUser,time()+60*60,'/','',false,true);*/
}
?>