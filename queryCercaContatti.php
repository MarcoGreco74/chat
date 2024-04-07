<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json, charset=utf-8");
include 'fileConnessione.php';
///////////////////////////
if(isset($_POST)){
	$dato = file_get_contents('php://input');
	$datoTrasf = json_decode($dato,true);
	$contatto = $datoTrasf['nome'];
	$destinatario = $datoTrasf['idDestinatario'];
	$stmt = $conn->prepare("SELECT CONCAT(utenti.nome, ' ',utenti.cognome) AS nominativo, utenti.nome, tabella_messaggi.idMittente, tabella_messaggi.idDestinatario, tabella_messaggi.testo, tabella_messaggi.data, SUM(tabella_messaggi.ricevuto) AS singolo_conteggio FROM utenti INNER JOIN tabella_messaggi ON utenti.id=tabella_messaggi.idMittente WHERE tabella_messaggi.idDestinatario = $destinatario GROUP BY tabella_messaggi.idMittente ORDER BY (CASE WHEN utenti.nome LIKE'%$contatto%' THEN 'select name' ELSE 'select a valid name' END) DESC"); 
	$stmt->execute();
	$result = $stmt->get_result();
	$outp = $result->fetch_all(MYSQLI_ASSOC); 
	$objOutp = json_encode($outp); 
	echo $objOutp;
}
?>