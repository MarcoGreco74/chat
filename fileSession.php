<?php
session_start();
if($_SESSION['myUser']){	
	header("Location:fileAccess.php");
	}else{
		echo "<script>alert('errore')</script>";
		header("Location:fileRegister.php");
	}
?>