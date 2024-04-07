<?php
session_start();
unset($_SESSION["myUser"]);
if(!$_SESSION['myUser']){	
	header("Location:fileAccess.php");
	}else{
		echo "<script>alert('errore')</script>";
		header("Location:fileRegister.php"); // da cambiare con qualcosa di più utile
	}
?>