<?php
header("Content-Type:application/json, charset=utf-8");
include 'fileConnessione.php';
///////////////////////
		$post_data = file_get_contents('php://input');
		$datiForm = json_decode($post_data,true);
		$newMsg = $datiForm['messaggio'];
		$idMitt = $datiForm['idContatto'];
		$idDes = $datiForm['idDestin'];	
		echo json_encode($datiForm);
		$stmt3 = $conn->prepare("INSERT INTO tabella_messaggi (id,testo,idMittente,idDestinatario,letto,ricevuto) VALUES(NULL,'$newMsg',$idMitt,$idDes,0,1)");
		$stmt3->execute();
?>