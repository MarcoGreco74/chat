<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=utf-8");
require('fileConnessione.php');
    $idMitt=$_POST['idMittente'];
	$idDes=$_POST['idDestinatario'];
    $stmt = $conn->prepare("SELECT CONCAT(utenti.nome, ' ',utenti.cognome) AS nominativo, utenti.nome, tabella_messaggi.idDestinatario, tabella_messaggi.idMittente, tabella_messaggi.testo, tabella_messaggi.data, tabella_messaggi.letto FROM tabella_messaggi INNER JOIN utenti ON tabella_messaggi.idDestinatario = utenti.id WHERE tabella_messaggi.testo IS NOT NULL AND (idDestinatario=$idDes AND idMittente=$idMitt) OR (idDestinatario=$idMitt AND idMittente=$idDes)"); 
	$stmt->execute();
	$result = $stmt->get_result();
	$outp = $result->fetch_all(MYSQLI_ASSOC); 
	$objOutp = json_encode($outp); 
	$stmt1 = $conn->prepare("UPDATE tabella_messaggi SET letto = 1, ricevuto = 0 WHERE idMittente = $idDes"); 
	$stmt1->execute();
	echo $objOutp;
?>
