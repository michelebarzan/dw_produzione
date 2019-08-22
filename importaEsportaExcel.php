<?php
	include "Session.php";
	include "connessione.php";
	
	$pageName="Importa/Esporta Excel";
	$appName="Produzione";
?>
<html>
	<head>
		<title><?php echo $appName."&nbsp&#8594&nbsp".$pageName; ?></title>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
		<link rel="stylesheet" href="css/styleV12.css" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<script src="struttura.js"></script>
		<script>
			function clicca()
			{
				window.alert("Funzione temporaneamente disabilitata");
				/*var r = confirm("Non sarà possibile importare un General numbering con colonne diverse da quelle contenute nel database. Se il file che si sta cercando di caricare contiene nuove colonne scegliere 'Annulla' e aggiungerne una nuova dall' apposito menù, altrimenti scegliere 'Ok' e continuare");
				if (r == true) 
				{
					document.getElementById("btnFileImporta").click();
				}*/
				/*else
				{
					window.location = 'inserisciColonne.php';
				}	*/					
			}
			function importa()
			{
				
				//disabilito il bottone per esportare
				/*document.getElementById("esportaExcel").disabled = true;
				
				//mostro il loading
				document.getElementById("btnLoading").style.color="green";
				var intestazione=document.getElementById("statoImportazioneEsportazione").innerHTML;
				
				setTimeout(function()
				{ 
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() 
					{
						if (this.status == 200) 
						{
							if(this.responseText.indexOf("General numbering importato correttamente")>0)
							{
								setTimeout(function()
								{ 
									//rimetto tutto allo stato iniziale e l' importazione e avvenuta senza errori
									document.getElementById("btnLoading").style.color="white";
									document.getElementById("statoImportazioneEsportazione").innerHTML='<b style="color:black;font-size:110%;">Progresso importazione/esportazione:</b><br><br>';
									//abilito il bottone per esportare
									document.getElementById("esportaExcel").disabled = false;
								}, 2000);
							}
							if(this.responseText.indexOf("Errore:")>0)
							{
								setTimeout(function()
								{ 
									//rimetto tutto allo stato iniziale e l' importazione e avvenuta senza errori
									document.getElementById("btnLoading").style.color="white";
									//document.getElementById("statoImportazioneEsportazione").innerHTML='<b style="color:black;font-size:110%;">Progresso importazione/esportazione:</b><br><br>';
									//abilito il bottone per esportare
									document.getElementById("esportaExcel").disabled = false;
								}, 2000);
							}
							//stampo i messaggi
							document.getElementById("statoImportazioneEsportazione").innerHTML = intestazione+this.responseText;
						}
					};
					xmlhttp.open("POST", "importaExcel.php?" , true);
					xmlhttp.send();
				}, 1000);*/
			}
			function scegliCommessa()
			{
				document.getElementById("commessaEsporta").style.height="40px";
				document.getElementById("commessaEsporta").style.width="100px";
				//document.getElementById("commessaEsporta").style.marginLeft="20px";
			}
			function esporta()
			{
				//window.alert("Funzione temporaneamente disabilitata");
				//disabilito il bottone per importare
				document.getElementById("importaExcel").disabled = true;
				
				var commessa=document.getElementById("commessaEsporta").value;
				
				//nascondo il menu commessa
				document.getElementById("commessaEsporta").style.height="0px";
				document.getElementById("commessaEsporta").style.width="0px";
				document.getElementById("commessaEsporta").value='';
				
				//mostro il loading
				document.getElementById("btnLoading").style.color="green";
				var intestazione=document.getElementById("statoImportazioneEsportazione").innerHTML;
				
				setTimeout(function()
				{ 
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() 
					{
						if (this.status == 200) 
						{
							if(this.responseText.indexOf("Excel generato correttamente")>0)
							{
								//inizio il download
								document.downloadForm.submit();
							}
							
							//stampo i messaggi
							document.getElementById("statoImportazioneEsportazione").innerHTML = intestazione+this.responseText;
							setTimeout(function()
							{
								//rimetto tutto allo stato iniziale
								document.getElementById("btnLoading").style.color="#EBEBEB";
								document.getElementById("statoImportazioneEsportazione").innerHTML='<b style="color:black;font-size:110%;">Progresso importazione/esportazione:</b><br><br>';
								//abilito il bottone per importare
								document.getElementById("importaExcel").disabled = false;
								//cancellaFile();
							}, 7000);
						}
					};
					xmlhttp.open("POST", "esportaExcel.php?commessa=" + commessa , true);
					xmlhttp.send();
				}, 1000);
			}
			function cancellaFile()
			{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{};
				xmlhttp.open("POST", "cancellaFile.php?", true);
				xmlhttp.send();
			}
			function topFunction() 
			{
				document.body.scrollTop = 0;
				document.documentElement.scrollTop = 0;
			}
		</script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
			@import url(http://fonts.googleapis.com/css?family=Exo:100,200,400);
			@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);
			
			/* width */
			::-webkit-scrollbar {
				width: 10px;
			}

			/* Track */
			::-webkit-scrollbar-track {
				background: #f1f1f1; 
			}
			 
			/* Handle */
			::-webkit-scrollbar-thumb {
				background: #888; 
			}

			/* Handle on hover */
			::-webkit-scrollbar-thumb:hover {
				background: #555; 
			}
		</style>
	</head>
	<body>
		<?php include('struttura.php'); ?>
		<div id="container">
			<div id="content">
				<div id="immagineLogo" class="immagineLogo" ></div>
				<div id="bottoniImportaEsporta" class="bottoniImportaEsporta">
					<input type="button" id="importaExcel" value="Importa" onclick="clicca()" />
					<button id='btnLoading' class='btnLoading' ><br><b class="fa fa-circle-o-notch fa-spin"></b></button>
					<input type="button" id="esportaExcel" value="Esporta" onclick="scegliCommessa()" />
					<?php
					echo "<select name='commessaEsporta' id='commessaEsporta' class='commessaEsporta' onchange='esporta()'>";
					echo "<option value='' disabled selected>Commessa</option>";
					$query="SELECT DISTINCT commesse.id_commessa, commesse.commessa FROM commesse,general_numbering WHERE general_numbering.commessa = commesse.id_commessa ORDER BY commessa";
					$result=sqlsrv_query($conn,$query);
					if($result==FALSE)
					{
						$query=str_replace("'","*APICE*",$query);
						$testoErrore=print_r(sqlsrv_errors(),TRUE);
						$testoErrore=str_replace("'","*APICE*",$testoErrore);
						$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
						$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$query','".$testoErrore."','".$_SESSION['Username']."')";
						$resultErrori=sqlsrv_query($conn,$queryErrori);
						$query=str_replace("*APICE*","'",$query);
						echo "<br><br>Errore esecuzione query<br>Query: ".$query."<br>Errore: ";
						die(print_r(sqlsrv_errors(),TRUE));
					}
					else
					{
						while($row=sqlsrv_fetch_array($result))
						{
							echo "<option value='".$row['commessa']."|".$row['id_commessa']."'>".$row['commessa']."</option>";
						}
					}
					echo "</select>";
					?>
					
					<form action="caricaExcel.php" method="POST" enctype="multipart/form-data"><input type="file" id="btnFileImporta" name="btnFileImporta" style="display:none" accept=".xlsx" onchange="this.form.submit();" /></form>
					
					<form action="downloadExcelGN.php" method="POST" id="downloadForm" name="downloadForm" style="display:none"></form>
				</div>
				<div id="statoImportazioneEsportazione">
					<b style="color:black;font-size:110%;">Progresso importazione/esportazione:</b><br><br>
					<?php
					if(isset($_SESSION['risultato']))
					{
						if($_SESSION['risultato']=="OK")
						{
							echo "File caricato<br><br>";
							echo "<script>importa();</script>";
							$_SESSION['risultato']=NULL;
						}
						else
						{
							echo "<b style='color:red'>Impossibile caricare il file</b><br><br>";
							$_SESSION['risultato']=NULL;
						}
					}
					?>
				</div>
			</div>
		</div>
		<div id="push"></div>
		<div id="footer">
			<!--<hr size='1' style='border-color:white;'>-->
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>

