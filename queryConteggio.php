<?php
header("Content-Type:application/json, charset=utf-8");
include 'fileConnessione.php';
/////////////////////////
$datoPost = file_get_contents('php://input');
$dato = json_decode($datoPost,true);
$contatto = json_encode($dato['idDestinatario']);
$stmt = $conn->prepare("SELECT idDestinatario, COUNT(ALL id) AS Conteggio FROM tabella_messaggi WHERE letto = 0 AND ricevuto <> 0 AND idDestinatario=$contatto"); 
$stmt->execute();
$result = $stmt->get_result();
$outp = $result->fetch_all(MYSQLI_ASSOC); 
$objOutp = json_encode($outp); 
echo $objOutp;
?>
