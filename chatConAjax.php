<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial scale=1.0">
<link href="../bootstrap/bootstrap-grid.css" rel="stylesheet"></link>
<link href="../bootstrap/bootstrap.min.css" rel="stylesheet"></link>
<link href="../bootstrap/bootstrap.css" rel="stylesheet"></link>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">  
<script src="../bootstrap/bootstrap.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript"></script>
<style>
.ms-n5 {
    margin-left: -40px;
	}
#formScrivi {
	display:none;
}
.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}
#sezione2 {
  display: flex;
  flex-direction: column-reverse;
  max-height: 100vh;
  overflow: auto;
}
.divIn {
	background-color:'#dcefdd' !important;
	border:2px solid grey; 
	margin-top:10px; 
	padding:10px;
	float:right;
}
.green-color {
	color:#26e218;
	font-size:30px;
}
.grey-color {
	color:grey;
	font-size:30px;
}

</style>
</head>
<body>
<div style='position:sticky; top:0;'>
<div class="container text-center">
  <div class="row" style='border:1px solid red; overflow:auto; background-color:#f2f6fc;'>
    <div class="col-sm-3">
	<div class="col-4 col-sm-6">
	   <a href="fileLogout.php"><img src="lgout (1).png" style="width:50px; height:15px;"></a><!-- implemento un file logout che contiene un unset session ed un header(location:fileAccess.php) -->
       <img src='../immagini/frecciaSlideSX.png' style='width:20px;' id='clk' onClick="window.location.reload();">
	   <b>Profilo di <?php echo $_SESSION['myName']; echo ' '; echo $_SESSION['mySurname'];?></b>
        </div>
    </div>
    <div class="col-sm-9">
      <div class="row">
        <div id='demo2' class="col-8 col-sm-6">
          <!---->
			 
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container text-center" style='background-color:#b7bfba; float-bottom:50px;'>
  <div class="row">
    <div class="col">
      <button type="button" name ='btnMsg' onClick="window.location.reload();" class="btn btn-primary position-relative"><!--window.location.reload();-->
		Message
		<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
			<div id='num'></div>
		<span class="visually-hidden">unread messages</span>
		</span>
		</button>
    </div>
    <div class="col"> <!-- div da verificare -->
    </div>
    <div class="col">
	   <div class="container">
	   <div class="row">
	   <div class="col-md-5 mx-auto">
	   <div class="small fw-light">Cerca tra i contatti</div>
	   <div class="input-group">
	  
	   <form id='formContatti' name='formContatti' action='file3.php' method='POST'>
	   <input type="text" id="idInfo" name="idInfo">
	   <input type='submit' id='btnContatti' name='btnContatti' value='Cerca'>	  
	   </form>
	   
	   <span class="input-group-append">	   
	   <i class="fa fas-search"></i>	   
	   </span>
	   </div>
	   </div>
	   </div>
	   </div>
    </div>
  </div>
</div>
</div>
<div id='contenitore' class='container-container-fluid'>
<div class="row ">
<div id = 'idSide' class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark col-2" style="width: 280px;">
<section id='sezione'>
</section>
</div>
<section id = 'sezione2' class="col bg-success p-2 text-dark bg-opacity-25">
<div id ='sezione3' style='background-color:white; border:1px solid black; border-radius:20px; padding:10px;'>

<div class="container">
<div class="row">
<div class="col-md-5 mx-auto">

<form action="scriviMsg.php" id="formScrivi" name="formScrivi" method="POST">
<input type="hidden" id="idDestin" name="idDestin" /><!--destinatario<br>-->
<input type="hidden" id="idContatto" name="idContatto"><!--mittente-->
<input type="text" name="messaggio" id="messaggio" placeholder="scrivi messaggio" style="width: 100%;"/>
<input type="submit" id="invia" name="invia" value='Invia'>
</form>

</div>
</div>
</div>

<script>

let displayMsg = $("#sezione3");
let arr = [];
let ciclo = setInterval(conteggio, 5000);
let num = document.getElementById('num');

//(es..Marco->Matteo)idDestinatario = 1 / idMittente = 4.
async function contatti(){
 let sezione = document.getElementById('sezione');
 let idProfilo = '<?php echo $_SESSION['id_contatto']; ?>';
 let idNumProfilo = +idProfilo;
 let url = 'queryVisualizzaContatti.php';
 let response = await fetch(url, {
	 method:'POST',
	 headers: new Headers({
            'Content-type': 'application/json; charset=UTF-8'
        }),
	 body: JSON.stringify({"idDestinatario":idNumProfilo})
 });
 let richiestoObj = await response.json();
 //console.log(richiestoObj);
 let arrDiv = [];
 let arrNode = [];
 $.each(richiestoObj, function(key,value){
	 //console.log(richiestoObj);
	let datiRichiesti = richiestoObj[key];
	//console.log(datiRichiesti);
	let name = datiRichiesti.nominativo;
	let onlyName = datiRichiesti.nome;
	//console.log(typeof(onlyName));
	let idMit = datiRichiesti.idMittente;
	let idDes = datiRichiesti.idDestinatario;
	let idProfilo = '<?php echo $_SESSION['id_contatto']; ?>';
	//console.log(idProfilo); // string
	let idNumProfilo = +idProfilo; // number
	//console.log(idMit);
	let nomeDest = datiRichiesti.nomeDestinatario;
	//console.log(nomeDest);
	//console.log(idMit);
	let singoloConteggio = datiRichiesti.singolo_conteggio;
	console.log(singoloConteggio);
	let msg = datiRichiesti.testo;
	let orario = datiRichiesti.data;
	arr.push(singoloConteggio);
	let newDiv = $("<div></div>").css({'border':'2px solid red','margin-top':'10px','padding':'10px','background-color':'#a2a6aa'});
	$(newDiv).attr('class', 'd-flex flex-column flex-shrink-0 p-3 text-bg-dark');
	$(newDiv).attr('id',idMit);
	$(newDiv).html('<ul id="lista" class="nav nav-pills flex-column mb-auto"><li class="nav-item d-flex "><a href="#" class="nav-link text-white" onclick="visualizzaMsg('+idDes+','+idMit+');"><img src="utente.jfif" style="width:30px;" id="foto"><svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg><h3>'+name+'<span class="badge text-bg-danger"><div id="badgeSingolo"></div></span></h3></a></li></ul>');
	$(newDiv).appendTo(sezione); 
	arrDiv.push(newDiv);
		});
		 let badgeSingolo =document.querySelectorAll('#badgeSingolo');
		 $.each(richiestoObj, function(key,value){
			 //console.log(richiestoObj[key]);
			 $.each(badgeSingolo, function(chiave,valore){
				 if(key==chiave){
					 //$(badgeSingolo[chiave]).html(''+arr[key]+''+badgeSingolo[chiave]); // DA RISOLVERE CON JQUERY
					 badgeSingolo[chiave].innerHTML = ''+arr[key]+''+badgeSingolo[chiave].innerHTML;
				 }
			 });
		 });
}

contatti();

let formContatti = document.getElementById('formContatti');
formContatti.addEventListener('submit', function(evento){
	evento.preventDefault();
	$(sezione).html('');
	let formattedFormData = new FormData(formContatti);
	selezionaContatti(formattedFormData);
});

async function selezionaContatti(formattedFormData){
 let sezione = document.getElementById('sezione');	
 let formObj = Object.fromEntries(formattedFormData); 
 //console.log(formObj);
 let formObj2 = JSON.stringify(formObj);
 //console.log(formObj2);
 let inpContatto = $('#idInfo');
 let filter=inpContatto.val().toUpperCase();
 let contatto = formObj.idInfo;
 let idProfilo = '<?php echo $_SESSION['id_contatto']; ?>';
 let idNumProfilo = +idProfilo;
 let datiJsn = JSON.stringify({"nome":contatto, "idDestinatario":idNumProfilo});
 let url = 'queryCercaContatti.php';
 let response = await fetch(url, {
   method : 'POST' , 
   headers: new Headers({
            'Content-type': 'application/json; charset=UTF-8'
        }),
   body : datiJsn   
 });
 let richiestoObj = await response.json();
 //console.log(richiestoObj);
 let arrDiv = [];
 let arrNode = [];
 $.each(richiestoObj, function(key,value){
	let datiRichiesti = richiestoObj[key];
	let name = datiRichiesti.nome;
	let idMit = datiRichiesti.idMittente;
	let contatto = datiRichiesti.nominativo;
	//console.log(contatto);	
	let idDest = datiRichiesti.idDestinatario;
	//console.log(idDest);
	//console.log(idMit);
	let singoloConteggio = datiRichiesti.singolo_conteggio;
	let msg = datiRichiesti.testo;
	let orario = datiRichiesti.data;
	arr.push(singoloConteggio);
	//$(sezione).html('');
	let newDiv = $("<div></div>").css({'border':'2px solid red','margin-top':'10px','padding':'10px','background-color':'#a2a6aa'});
	$(newDiv).attr('class', 'd-flex flex-column flex-shrink-0 p-3 text-bg-dark');
	$(newDiv).attr('id',idMit);
	$(newDiv).html('<ul id="lista" class="nav nav-pills flex-column mb-auto"><li class="nav-item d-flex "><a href="#" class="nav-link text-white" onclick="visualizzaMsg('+idDest+','+idMit+');"><img src="utente.jfif" style="width:30px;" id="foto"><svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg><h3>'+contatto+'<span class="badge text-bg-danger"><div id="badgeSingolo"></div></span></h3></a></li></ul>');
	$(newDiv).appendTo(sezione); 
	arrDiv.push(newDiv);
		});
	let badgeSingolo =document.querySelectorAll('#badgeSingolo');
		 $.each(richiestoObj, function(key,value){
			 //console.log(richiestoObj[key]);
			 $.each(badgeSingolo, function(chiave,valore){
				 if(key==chiave){					 
					 badgeSingolo[chiave].innerHTML = ''+arr[key]+''+badgeSingolo[chiave].innerHTML;
				 }
			 });
		 });	
}
		
async function conteggio(contatto){
 let dato = '<?php echo $_SESSION['id_contatto']; ?>';
 contatto = +dato;
 //console.log(contatto);
 let url = 'queryConteggio.php';
 let response = await fetch(url, {
	 method:'POST',
	 body: JSON.stringify({"idDestinatario":contatto})
 });
 let countObj = await response.json();
 //console.log(countObj);
 $.each(countObj, function(key,value){
   let numCount = countObj[key];
   //console.log(numCount);
   let numBadge = numCount.Conteggio;	
   //console.log(numBadge);
	let control = numBadge;
	$(num).html(control);
	  });
}

//conteggio();

function visualizzaMsg(idMitte,idDesti){ 
  //displayMsg.scroll(0, 800);
  console.log(idDesti); // number
  console.log(idMitte); // number  
  let jqxhr = $.ajax({
	  type : "POST",
	  url : "queryDisplayMsg.php",
	  data : "idMittente="+idMitte+"&idDestinatario="+idDesti
  });
  jqxhr.done(function(risposta){
	  //console.log('ciSono');
	  let visualizzaObj2 = Object.values(risposta);
	  //console.log(risposta);
	  let testoArrIn = [];
	  let testoArrOut = [];
	  let testoArr = [];
	  let dataArr = [];
	  $.each(visualizzaObj2, function(key,value){
		 let datiRichiesti = visualizzaObj2[key];
		 let message = datiRichiesti.testo;
		 let idDest = datiRichiesti.idDestinatario;
		 let nomin = datiRichiesti.nominativo;
		 console.log(nomin);
		 let letto = datiRichiesti.letto;
		 ////////// Qui si gestisce il div display che informa quale contatto si è cliccato per visualizzare i messaggi in ed out.
		if(idDest==idDesti){
		 //console.log(nomin);
		   $('#demo2').html('');
		   let contattoSelected = $("<div></div>");	
		   $(contattoSelected).css({'border':'10px solid grey','width':'100%','margin-top':'10px','padding':'10px','background-color':'#dcefdd','position':'sticky','top':'0'}); 
		   $(contattoSelected).html('<div class="container"><p><b>'+nomin+'</b></p></div>');  					         
		   $(contattoSelected).appendTo('#demo2'); 
		}
		////////////		 		 	 		 		 		 		 
		 let orario = datiRichiesti.data;
		 let nuovoOrario = new String(orario);
		 //console.log(nuovoOrario);
		 dataArr.push(nuovoOrario); 
		 //console.log(dataArr);
		 let formScrivi = document.getElementById('formScrivi');
		 document.getElementById('idDestin').value = idDesti;
		 document.getElementById('idContatto').value = idMitte;
		 formScrivi.style.display = "block";
		 formScrivi.scrollIntoView(false); // è come un'ancora al form
		 $(displayMsg).html(''); // svuoto il div per ripopolarlo					
			 let msg = '';		 		 
			  if(idDest==idDesti){	 		
				let spunta = letto==1 ? '<span class="bi bi-check green-color"></span>' : '<span class="bi bi-check grey-color"></span>';
				let msgOut = '<div class="container msgRight" style="border:10px solid grey; width:100%; margin-top:10px; padding:10px; background-color:#dcefdd"><p class="right">'+message+'</p><span class="badge text-bg-danger"><span class="time-left">'+nuovoOrario+'</span></span>'+spunta+'</div>';
				//console.log(msgOut);
				msg+=msgOut;
			    testoArr.push(msg);   
				//console.log(testoArr);
				$.each(testoArr, function(i,ele){
					//$(testoArr[i]).appendTo(displayMsg);	
					$(displayMsg).append(testoArr[i]);	
				  }); 
			 }			 	
			  if(idDest==idMitte){	
				if(message!= null){ // i msg NULL che servono a visualizzare tutti i contatti non vengono visualizzati
				let msgIn = '<div class="container msgLeft" style ="border:10px solid grey; width:100%; margin-top:10px; padding:10px; background-color:#b3d385"><p class="left"><b>'+message+'</b></p><p class="left"><span class="badge text-bg-danger"><span class="time-left">'+nuovoOrario+'</span></span></p></div>';			
				msg+=msgIn;
			    testoArr.push(msg);			      
				//console.log(testoArr);
				$.each(testoArr, function(i,ele){					
					//$(testoArr[i]).appendTo(displayMsg);	
				    $(displayMsg).append(testoArr[i]);			
				 });
				}				 
			 }	
	 $(formScrivi).appendTo(displayMsg);
	 //console.log(arr);	 	 
	  }); 	  
  }).fail(function(){ 
     alert("Chiamata fallita!!!");
   }); 
}

let formScrivi = document.getElementById('formScrivi');
formScrivi.addEventListener('submit', function(evento){
	evento.preventDefault();
	let formattedFormData2 = new FormData(formScrivi);
	scrivi(formattedFormData2);
});

async function scrivi(formattedFormData2){
 //console.log(formattedFormData2);
 let formObj = Object.fromEntries(formattedFormData2); 
 //console.log(formObj);
 let dati = new URLSearchParams(formattedFormData2);
 //console.log(dati);
 let formObj2 = JSON.stringify(formObj);
 //console.log(formObj2);
 let destinatario = Number(formObj.idDestin);
 let mittente = Number(formObj.idContatto);
 let msg = formObj.messaggio;
 let datiJsn = JSON.stringify({"idContatto":mittente,"idDestin":destinatario,"messaggio":msg});
 //console.log(datiJsn);
 let url = 'queryScriviMsg.php';
 let response = await fetch(url, {
   method : 'POST',
   body : datiJsn  
 });
let datiRichiesti = await response.json();
//console.log(datiRichiesti);
//console.log('ciao');
let messaggio = datiRichiesti.messaggio;
//console.log(messaggio);
let newDiv = $("<div></div>");
$(newDiv).css({'border':'2px solid grey','margin-top':'10px','padding':'10px','background-color':'#bbdd8b'});
let now = 'adesso';
$(newDiv).html('<div class="container"><p class="right"><b>'+messaggio+'</b></p><span class="badge text-bg-danger"><div><span class="time-right">'+now+'</span></div></span><span class="bi bi-check grey-color"></span></div>');
$(newDiv).appendTo(displayMsg);
}

</script>

</div>
</section>
</div>
</div>
</body>
</html>