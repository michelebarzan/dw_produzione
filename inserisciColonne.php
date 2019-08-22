<?php
	include "Session.php";
	include "connessione.php";
	
	$pageName="Gestisci tabelle";
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
			function elencoColonne()
			{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("elencoColonne").innerHTML  =  this.responseText;
					}
				};
				xmlhttp.open("POST", "elencoColonne.php?", true);
				xmlhttp.send();
			}
			function eliminaColonna(nome)
			{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("risultato").innerHTML  =  "Risultato:&nbsp"+this.responseText;
						elencoColonne();
					}
				};
				xmlhttp.open("POST", "eliminaColonna.php?nome="+nome, true);
				xmlhttp.send();
			}
			function inserisciColonna()
			{
				var nome=document.getElementById("nuovaColonna").value;
				var tipo=document.getElementById("tipoNuovaColonna").value;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("risultato").innerHTML  =  "Risultato:&nbsp"+this.responseText;
						elencoColonne();
					}
				};
				xmlhttp.open("POST", "inserisciColonna.php?nome="+nome + "&tipo=" + tipo, true);
				xmlhttp.send();
				document.getElementById("nuovaColonna").value="";
				document.getElementById("tipoNuovaColonna").value="";
			}
			function chiudiNB()
			{
				document.getElementById("NB").innerHTML="";
				document.getElementById("NB").style.width="0px";
				setTimeout(function()
				{
					document.getElementById("NB").style.height="0px";
					document.getElementById("NB").style.marginBottom="0px";
				}, 600);
				//document.getElementById("NB").style.marginBottom="0px";
			}
			function compilaDati()
			{
				var commessa=document.getElementById("Scommesse").value;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("contenutoDescrizione").innerHTML  = this.responseText;
					}
				};
				xmlhttp.open("POST", "getDescrizioneCommessa.php?commessa="+commessa, true);
				xmlhttp.send();
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("contenutoCantiere").innerHTML  = this.responseText;
					}
				};
				xmlhttp.open("POST", "getCantiereCommessa.php?commessa="+commessa, true);
				xmlhttp.send();
			}
			function modifica(campo,elem)
			{
				var valore = document.getElementById(elem).innerHTML;
				var commessa = document.getElementById("Scommesse").value;
				
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
				
				//window.alert("ciao");
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("risultato").innerHTML = "Risultato:&nbsp" +  this.responseText;
					}
				};
				xmlhttp.open("POST", "modificaCommessa.php?campo=" + campo + "&valore=" + valore + "&commessa=" + commessa, true);
				xmlhttp.send();
			}
			function piuMeno(id,idBtn)
			{
				var stato=document.getElementById(id).style.display;
				if(stato=="none")
				{
					document.getElementById(id).style.display="";
					document.getElementById(idBtn).value="-";
				}
				else
				{
					document.getElementById(id).style.display="none";
					document.getElementById(idBtn).value="+";
				}
			}
			function resetstyle()
			{
				document.getElementById("risultato").innerHTML = "Risultato:&nbsp";
				document.getElementById("modificaGNDiv").style.display="none";
				document.getElementById("modificaCommesseDiv").style.display="none";
				document.getElementById("componentiElettrici").style.display="none";
				var all = document.getElementsByClassName("btnIntestazioneGestisciTabelle");
				for (var i = 0; i < all.length; i++) 
				{
					all[i].style.color = 'black';
					all[i].style.boxShadow="";
				}
			}
			function colonneGN()
			{
				document.getElementById('btnColonneGN').style.color="#3367d6";
				document.getElementById('btnColonneGN').style.boxShadow=" 5px 5px 10px #9c9e9f";
				document.getElementById("modificaGNDiv").style.display="inline-block";
			}
			function datiCommesse()
			{
				document.getElementById('btnDatiCommesse').style.color="#3367d6";
				document.getElementById('btnDatiCommesse').style.boxShadow=" 5px 5px 10px #9c9e9f";
				document.getElementById("modificaCommesseDiv").style.display="inline-block";
			}
			function componentiElettrici()
			{
				document.getElementById('btnComponentiElettrici').style.color="#3367d6";
				document.getElementById('btnComponentiElettrici').style.boxShadow=" 5px 5px 10px #9c9e9f";
				document.getElementById("componentiElettrici").style.display="inline-block";
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("componentiElettrici").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("POST", "componentiElettrici.php?", true);
				xmlhttp.send();
			}
			function modificaComponente(i,id)
			{
				var codele=document.getElementById('codele'+i).innerHTML;
				var desc=document.getElementById('desc'+i).innerHTML;
				if(codele=='' || codele==null)
					document.getElementById("risultato").innerHTML = "Risultato:&nbsp<b style='color:red'>Errore: modifica annullata (il codice elemento non puo essere vuoto)</b>";
				else
				{
					if(codele.indexOf('<br>')>0 || desc.indexOf('<br>')>0)
						document.getElementById("risultato").innerHTML = "Risultato:&nbsp<b style='color:red'>Errore: modifica annullata (carattere a capo non consentito)</b>";
					else
					{
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function() 
						{
							if (this.readyState == 4 && this.status == 200) 
							{
								document.getElementById("risultato").innerHTML = "Risultato:&nbsp" +  this.responseText;
								setTimeout(function()
								{ 
									componentiElettrici();
								}, 500);
								if(this.responseText.indexOf("annullat")==-1)
									SPElettrificazione();
							}
						};
						xmlhttp.open("POST", "modificaComponente.php?codele="+codele+"&desc="+desc+"&id="+id, true);
						xmlhttp.send();
					}
				}
			}
			function eliminaComponente(id)
			{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("risultato").innerHTML = "Risultato:&nbsp" +  this.responseText;
						setTimeout(function()
						{ 
							componentiElettrici();
						}, 500);
						if(this.responseText.indexOf("annullat")==-1)
							SPElettrificazione();
					}
				};
				xmlhttp.open("POST", "eliminaComponente.php?id="+id, true);
				xmlhttp.send();
			}
			function inserisciComponente(i)
			{
				var codele=document.getElementById('codele'+i).innerHTML;
				var desc=document.getElementById('desc'+i).innerHTML;
				if(codele=='' || codele==null)
					document.getElementById("risultato").innerHTML = "Risultato:&nbsp<b style='color:red'>Errore: inserimento annullato (il codice elemento non puo essere vuoto)</b>";
				else
				{
					if(codele.indexOf('<br>')>0 || desc.indexOf('<br>')>0)
						document.getElementById("risultato").innerHTML = "Risultato:&nbsp<b style='color:red'>Errore: inserimento annullato (carattere a capo non consentito)</b>";
					else
					{
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function() 
						{
							if (this.readyState == 4 && this.status == 200) 
							{
								document.getElementById("risultato").innerHTML = "Risultato:&nbsp" +  this.responseText;
								setTimeout(function()
								{ 
									componentiElettrici();
								}, 500);
								if(this.responseText.indexOf("annullat")==-1)
									SPElettrificazione();
							}
						};
						xmlhttp.open("POST", "inserisciComponente.php?codele="+codele+"&desc="+desc, true);
						xmlhttp.send();
					}
				}
			}
			function SPElettrificazione()
			{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						if(this.responseText!='ok')
							document.getElementById("risultato").innerHTML = "Risultato:&nbsp" +  this.responseText;
						//window.alert( this.responseText);
					}
				};
				xmlhttp.open("POST", "SPElettrificazione.php?", true);
				xmlhttp.send();
			}
			function topFunction() 
			{
				document.body.scrollTop = 0;
				document.documentElement.scrollTop = 0;
			}
		</script>
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
	<body onload="elencoColonne();colonneGN()">
		<?php include('struttura.php'); ?>
		<div id="container">
			<div id="content">
				<div id="immagineLogo" class="immagineLogo" ></div>
				<div id="intestazioneGestisciTabelle">
					<td><input type="button" id="btnColonneGN" class="btnIntestazioneGestisciTabelle" onclick="resetstyle();colonneGN()" value="Colonne GN" /></td>
					<td><input type="button" id="btnDatiCommesse" class="btnIntestazioneGestisciTabelle" onclick="resetstyle();datiCommesse()" value="Dati commesse" /></td>
					<td><input type="button" id="btnComponentiElettrici" class="btnIntestazioneGestisciTabelle" onclick="resetstyle();componentiElettrici()" value="Componenti elettrici" /></td>
				</div>
				<div id="tabelleGestisciLinea">
					<div id="risultato" class="risultato" style="margin-left:5px;" >Risultato:&nbsp</div>
					<div id="modificaGNDiv">
						<div id="NB">
							<input type="button" value=" " id="exclamationPoint" />Le colonne inserite nel General Numbering <b>NON</b> verranno visualizzate nella maschera di consultazione.<div id="chiudiNB" onclick="chiudiNB()">X</div>
						</div>
						<div id="elencoColonne">
						</div>
						<hr size='1' style='border-color:#E6E6E6;margin-left:250px;margin-right:250px'><br>
						<input type="text" id="nuovaColonna" class="nuovaColonna" name="nuovaColonna" placeholder="Nome colonna" />&nbsp&nbsp
						<select name="tipoNuovaColonna" id="tipoNuovaColonna" class="nuovaColonna"></b> 
							<option value="" disabled selected>Tipo di  dati</option>
							<option value="int">int (dati numerici interi)</option>
							<option value="varchar(MAX)">varchar (dati di tipo testo, nessun limite di lunghezza)</option>
							<option value="float">float (dati numerici decimali)</option>
						</select>
						<input type="button" id="btnNuovaColonna" class="btnNuovaColonna" value=" " onclick="inserisciColonna()" /><br><br>
						<div id="push"></div>
					</div>
					
					<div id="modificaCommesseDiv">
						<?php
							echo "<select name='Scommesse' id='Scommesse' onchange='compilaDati()'>";
							echo "<option value='' disabled selected>Scegli commessa</option>";
							$query="SELECT * FROM commesse ORDER BY commesse.commessa ";
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
									echo "<option value='".$row['commessa']."'>".$row['commessa']."</option>";
								}
							}
							echo "</select>";
						?>
						<br><br>
						<div id="contenuto">
							<div style="font-weight:bold;font-family: 'Exo', sans-serif;display:inline-block;font-size:100%; text-align:left;float:left;color:#3367d6;margin-left:2%;width:15%;" >Descrizione: </div>
							<div id="contenutoDescrizione" style="height:60px;max-height:60px;width:81%;max-width:81%;margin-right:2%;float:right;color:gray;overflow:auto;text-align:left;" onkeyup="modifica('descrizione','contenutoDescrizione')" contenteditable>
							</div>
						</div>
						<br>
						<div id="contenuto">
							<div style="font-weight:bold;font-family: 'Exo', sans-serif;display:inline-block;font-size:100%; text-align:left;float:left;color:#3367d6;margin-left:2%;width:15%;" >Cantiere: </div>
							<div id="contenutoCantiere" style="height:60px;max-height:60px;width:81%;max-width:81%;margin-right:2%;float:right;color:gray;overflow:auto;text-align:left;" onkeyup="modifica('cantiere','contenutoCantiere')" contenteditable>
							</div>
						</div>
					</div>
					<div id="componentiElettrici"></div>
				</div>
			</div>
		</div>
		<div id="push"></div>
		<div id="footer">
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>

