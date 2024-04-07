<?php
header("Content-Type:application/json, charset=utf-8");
include 'fileConnessione.php';
///////////
$data = json_decode(file_get_contents( 'php://input' ), true );
$contatto = $data['idDestinatario'];
$qry = "SELECT CONCAT(utenti.nome, ' ',utenti.cognome) AS nominativo, utenti.nome, utenti.cognome, utenti.id, tabella_messaggi.idMittente, tabella_messaggi.idDestinatario, tabella_messaggi.testo, tabella_messaggi.data, SUM(tabella_messaggi.ricevuto) AS singolo_conteggio FROM utenti INNER JOIN tabella_messaggi ON utenti.id=tabella_messaggi.idMittente WHERE tabella_messaggi.idDestinatario = $contatto GROUP BY tabella_messaggi.idMittente ORDER BY singolo_conteggio DESC";
$stmt = $conn->prepare($qry);
$stmt->execute();
$result = $stmt->get_result();
$outp = $result->fetch_all(MYSQLI_ASSOC); 
$objOutp = json_encode($outp); 
echo $objOutp;
?>
