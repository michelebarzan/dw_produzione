<?php
	include "Session.php";
	include "connessione.php";
	
	$pageName="Visualizza lotti bifacciali";
	$appName="Produzione";
?>
<html>
	<head>
		<title><?php echo $appName."&nbsp&#8594&nbsp".$pageName; ?></title>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
		<link rel="stylesheet" href="css/styleV12.css" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
		<link rel="stylesheet" href="fontawesomepro/css/fontawesomepro.css" />
		<script src="spinner.js"></script>
		<link rel="stylesheet" href="css/spinner.css" />
		<script src="struttura.js"></script>
		<script>
			function showTableLotti(id)
			{
				var commessa=document.getElementById("filtroCommessaLotto").value;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("myTableLotti").innerHTML  =  this.responseText;
						setTimeout(function()
						{ 
							if(id!=0)
							{
								try
								{
									document.getElementById("downloadButton"+id).click();
								}
								catch(e)
								{
									window.alert(e.message+" downloadButton"+id);
								}
							}
						}, 1000);
					}
				};
				xmlhttp.open("POST", "tabellaLottiBifacciali.php?commessa=" + commessa, true);
				xmlhttp.send();
			}
			function versioni(id)
			{
				document.getElementById("btnElencoVersioni"+id).style.display="none";
				document.getElementById("versioni"+id).style.background="#3F3F3F";
				document.getElementById("versioni"+id).style.height="120px";
				document.getElementById("versioni"+id).style.width="100%";
				setTimeout(function()
				{ 
					document.getElementById("versioni"+id).style.overflowY="auto";
				}, 500);
			}
			function chiudiVersioni(id)
			{
				document.getElementById("versioni"+id).style.overflowY="hidden";
				document.getElementById("versioni"+id).style.background="transparent";
				document.getElementById("versioni"+id).style.height="0px";
				document.getElementById("versioni"+id).style.width="0px";
				document.getElementById("btnElencoVersioni"+id).style.display="inline-block";
			}
			function versioni2(id)
			{
				document.getElementById("versioni2"+id).style.display="block";
				//document.downloadForm.submit();
			}
			function chiudiVersioni2(id)
			{
				document.getElementById("versioni2"+id).style.display="none";
			}
			function genera(n,id)
			{
				document.getElementById("generaButton"+n).style.transform="rotate(360deg)";
				var interval1=setInterval(function()
				{  
					document.getElementById("generaButton"+n).style.transform="rotate(0deg)";
				}, 2000);
				var interval2=setInterval(function()
				{  
					document.getElementById("generaButton"+n).style.transform="rotate(360deg)";
				}, 4000);
				document.getElementById("stato"+n).style.background="#3F3F3F";
				document.getElementById("stato"+n).style.height="120px";
				document.getElementById("stato"+n).innerHTML  = "Inizio la generazione del file...<br>";
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("stato"+n).innerHTML  +=  this.responseText;
						
						if(this.responseText.indexOf("Excel generato correttamente")>0)
						{
							setTimeout(function()
							{ 
								showTableLotti(id);
							}, 3000);
						}
						setTimeout(function()
						{ 
							clearInterval(interval1);
							clearInterval(interval2);
							document.getElementById("stato"+n).innerHTML  ="";
							document.getElementById("stato"+n).style.background="transparent";
							document.getElementById("stato"+n).style.height="0px";
						}, 2000);
						
						if(this.responseText.indexOf("Excel generato correttamente")>0)
						{
							document.getElementById("risultato").innerHTML = "&nbspRisultato:&nbsp<b style='color:green'>Excel generato correttamente</b>";
						}
						else
							document.getElementById("risultato").innerHTML = "&nbspRisultato:&nbsp<b style='color:red'>Errore: impossibile generare l' Excel</b>";
					}
				};
				xmlhttp.open("POST", "generaExcelLottiBifacciali.php?id_lotto=" + id, true);
				xmlhttp.timeout = 120000; // Set timeout to 4 seconds (4000 milliseconds)
				xmlhttp.ontimeout = function () 
				{ 
					document.getElementById("risultato").innerHTML = "&nbspRisultato:&nbsp<b style='color:red'>Errore: impossibile generare l' Excel</b>";
					document.getElementById("stato"+n).innerHTML  += "<br><b style='color:red'>Errore: impossibile generare l' Excel</b><br>";
					svuotaLottoCorrenteTimeout();
					setTimeout(function()
					{ 
						clearInterval(interval1);
						clearInterval(interval2);
						document.getElementById("stato"+n).innerHTML  ="";
						document.getElementById("stato"+n).style.background="transparent";
						document.getElementById("stato"+n).style.height="0px";
					}, 2000);
				}
				xmlhttp.send();
			}
			function svuotaLottoCorrenteTimeout()
			{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						if(this.responseText!="ok")
							window.alert(this.responseText);
					}
				};
				xmlhttp.open("POST", "svuotaLottoBifaccialeCorrenteTimeout.php?", true);
				xmlhttp.send();
			}
			function modifica(riga,colonna,id)
			{
				var riga=riga;
				var colonna=colonna;
				var id=id;
				
				//var nomeColonna = "note";
				var nomeColonna =document.getElementById("myTableLotti").rows[0].cells[colonna].innerHTML;
				
				//window.alert(colonna);
				
				try
				{
					var valore = document.getElementById("myTableLotti").rows[riga].cells[colonna].innerHTML;
				}
				catch(err)
				{
					window.alert(err);
				}
				
				console.log(valore);
				
				var i;
				var count;
				
				i=0;
				count = (valore.match(/<div>/g) || []).length;
				for(i=0;i<count;i++)
				{
					valore = valore.replace('<div>', '');
					valore = valore.replace('</div>', '');
				}
				i=0;
				count = (valore.match(/<br>/g) || []).length;
				for(i=0;i<count;i++)
				{
					valore = valore.replace('<br>', ' ');
				}
				i=0;
				count = (valore.match(/nbps/g) || []).length;
				for(i=0;i<count;i++)
				{
					valore = valore.replace('&nbps;', ' ');
				}
				
				console.log(valore);
				
				//window.alert("nomeColonna: "+nomeColonna+" valore: "+valore);
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("risultato").innerHTML = "&nbspRisultato:&nbsp" +  this.responseText;
					}
				};
				xmlhttp.open("POST", "aggiornaNoteBifacciale.php?nomeColonna=" + nomeColonna + "&valore=" + valore + "&id=" + id, true);
				xmlhttp.send();
			}
			function erroreGenerabile(lotto,commessa)
			{
				console.log(lotto);
				console.log(commessa);
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						window.alert(this.responseText);
					}
				};
				xmlhttp.open("POST", "erroreGenerabileBifacciale.php?lotto=" + lotto + "&commessa=" + commessa, true);
				xmlhttp.send();
			}
			function controlloIntegritaLotti()
			{
				newCircleSpinner("Controllo integrita lotti in corso...");
				
				$.post("controlloIntegritaLotti_bf.php",
				function(response, status)
				{
					if(status=="success")
					{
						if(response.indexOf("ok")>-1)
						{
							Swal.fire
							({
								type: 'success',
								title: 'Controllo integrita lotti bifacciali completato'
							})
							showTableLotti(0);
							removeCircleSpinner();
						}
						else
						{
							Swal.fire({
							  type: 'error',
							  title: 'Errore',
							  text: "Impossibile controllare l'integrita dei lotti bifacciali"
							})
						}
					}
					else
						console.log(status);
				});
			}
		</script>
		<style>
			@import url(http://fonts.googleapis.com/css?family=Exo:100,200,400);
			@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);
			.swal2-title
			{
				font-family:'Montserrat',sans-serif;
				font-size:18px;
			}
			.swal2-content
			{
				font-family:'Montserrat',sans-serif;
				font-size:13px;
			}
			.swal2-confirm,.swal2-cancel
			{
				font-family:'Montserrat',sans-serif;
				font-size:13px;
			}
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
	<body onload="controlloIntegritaLotti()">
		<button onclick="topFunction()" id="btnGoTop" title="Go to top"></button>
		<script>
		// When the user scrolls down 20px from the top of the document, show the button
			window.onscroll = function() {scrollFunction()};

			function scrollFunction() 
			{
				if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) 
				{
					document.getElementById("btnGoTop").style.width = "48px";
					document.getElementById("btnGoTop").style.height = "48px";
					document.getElementById("btnGoTop").style.opacity = "1";
				} 
				else 
				{
					document.getElementById("btnGoTop").style.width = "0px";
					document.getElementById("btnGoTop").style.height = "0px";
					document.getElementById("btnGoTop").style.opacity = "0";
				}
			}

			// When the user clicks on the button, scroll to the top of the document
			function topFunction() 
			{
				document.body.scrollTop = 0;
				document.documentElement.scrollTop = 0;
			}
		</script>
		<?php include('struttura.php'); ?>
		<div id="container">
			<div id="content">
				<div id="immagineLogo" class="immagineLogo" style="margin-bottom:20px;" ></div>
				<div id="risultato" class="risultato" >&nbspRisultato:&nbsp</div>
				<div id="righe" class="righe">Lotti&nbspdella&nbspcommessa&nbsp
					<?php
					echo "<select name='filtroCommessaLotto' id='filtroCommessaLotto' onchange='showTableLotti(0);'>";
					echo "<option value='%'>*</option>";
					$queryCommessa2="SELECT DISTINCT commesse.commessa FROM commesse,lotti_bf WHERE lotti_bf.commessa=commesse.id_commessa";
					$resultCommessa2=sqlsrv_query($conn,$queryCommessa2);
					if($resultCommessa2==FALSE)
					{
						$queryCommessa2=str_replace("'","*APICE*",$queryCommessa2);
						$testoErrore=print_r(sqlsrv_errors(),TRUE);
						$testoErrore=str_replace("'","*APICE*",$testoErrore);
						$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
						$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$queryCommessa2','".$testoErrore."','".$_SESSION['Username']."')";
						$resultErrori=sqlsrv_query($conn,$queryErrori);
						$queryCommessa2=str_replace("*APICE*","'",$queryCommessa2);
						echo "<br><br>Errore esecuzione query<br>Query: ".$queryCommessa2."<br>Errore: ";
						die(print_r(sqlsrv_errors(),TRUE));
					}
					else
					{
						while($rowCommessa2=sqlsrv_fetch_array($resultCommessa2))
						{
							echo "<option value='".$rowCommessa2['commessa']."'>".$rowCommessa2['commessa']."</option>";
						}
					}
					echo "</select>";
					?>
				</div>
				<table id="myTableLotti">
				</table>
			</div>
		</div>
		<div id="push"></div>
		<div id="footer">
			<!--<hr size='1' style='border-color:white;'>-->
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>

