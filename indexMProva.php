<?php
include "Session.php";
include "connessione.php";
?>
<html>
	<head>
		<title>Homepage</title>
			<link rel="stylesheet" href="css/styleM.css" />
			<script>
				function detectmob() 
				{ 
					if( navigator.userAgent.match(/Android/i)
					|| navigator.userAgent.match(/webOS/i)
					|| navigator.userAgent.match(/iPhone/i)
					|| navigator.userAgent.match(/iPad/i)
					|| navigator.userAgent.match(/iPod/i)
					|| navigator.userAgent.match(/BlackBerry/i)
					|| navigator.userAgent.match(/Windows Phone/i)
					)
					{
						
					}
					else
						window.location = "index.php";
				
				}
				function dettagliUser()
				{
					document.getElementById('header').innerHTML='<input type="button" id="chiudiDettagliUser" value="" onclick="chiudiDettagliUser()" />';
				}
				function apri()
				{
					var body = document.body,html = document.documentElement;
					var offsetHeight = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
					document.getElementById('stato').innerHTML="Aperto";
					document.getElementById('navBar').style.width="300px";
					document.getElementById('nascondi2').style.display="inline-block";
					document.getElementById('navBar').style.height = offsetHeight+"px";
					var all = document.getElementsByClassName("btnGoToPath");
					for (var i = 0; i < all.length; i++) 
					{
						all[i].style.width = '100%';
						all[i].style.height='50px';
						all[i].style.borderBottom='1px solid #ddd';
					}
				}
				function chiudi()
				{
					document.getElementById('navBar').style.width = "0px";
					document.getElementById('stato').innerHTML="Chiuso";
					setTimeout(function()
					{ 
						document.getElementById('navBar').style.height = "0px";
						document.getElementById('nascondi2').style.display="none";
						var all = document.getElementsByClassName("btnGoToPath");
						for (var i = 0; i < all.length; i++) 
						{
							all[i].style.width = '0px';
							all[i].style.height='0px';
							all[i].style.borderBottom='';
						}
					}, 1000);
				}
				function logoutB()
				{
					window.location = 'logout.php';
				}
				function gotopath(path)
				{
					window.location = path;
				}
				function homepage()
				{
					window.location = 'index.php';
				}
				function nascondi()
				{
					var stato=document.getElementById('stato').innerHTML;
					if(stato=="Aperto")
					{
						chiudi();
					}
					else
					{
						apri();
					}
				}
				function goToPath(path)
				{
					window.location = path;
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
	<body onload="detectmob()">
		<div id="header" class="header" >
			<input type="button" id="nascondi" value="" onclick="nascondi()" />
			<div id="pageName" class="pageName">
				Homepage
			</div>
			<div id="user" class="user" onclick="dettagliUser()">
				<div id="username"><?php echo $_SESSION['Username']; ?></div>
				<input type="submit" value=" " id="btnUser">
			</div>
		</div>
		<div id="navBar">
			<input type="button" id="nascondi2" value="" onclick="nascondi()" data-toggle='tooltip' title='Chiudi menu' />
			<div id="stato" style="display:none">Chiuso</div>
			<input type="button" value="Homepage" data-toggle='tooltip' title='Homepage' class="btnGoToPath" onclick="goToPath('index.php')" />
			<input type="button" value="General Numbering" data-toggle='tooltip' title='General Numbering' class="btnGoToPath" onclick="goToPath('generalNumbering.php')" />
			<input type="button" value="Importa/Esporta Excel" data-toggle='tooltip' title='Importa/Esporta Excel' class="btnGoToPath" onclick="goToPath('importaEsportaExcel.php')" />
			<input type="button" value="Visualizza lotti" data-toggle='tooltip' title='Visualizza lotti' class="btnGoToPath" onclick="goToPath('visualizzaLotti.php')" />
			<input type="button" value="Gestisci tabelle" data-toggle='tooltip' title='Gestisci tabelle' class="btnGoToPath" onclick="goToPath('inserisciColonne.php')" />
		</div>
		<div id="content">
			<div id="immagineLogo" class="immagineLogo" ></div>
			<div id="actionList">
				<div class="linkList" onclick="gotopath('generalNumbering.php')" >Consulta e modifica la tabella General Numbering<input type="button" class="link" value=" " onclick="gotopath('generalNumbering.php')"/></div><br>
				<div class="linkList" onclick="gotopath('importaEsportaExcel.php')" >Importa un file excel nella tabella General Numbering<input type="button" class="link" value=" " onclick="gotopath('importaEsportaExcel.php')"/></div><br>
				<div class="linkList" onclick="gotopath('importaEsportaExcel.php')" >Esporta un file excel della tabella General Numbering<input type="button" class="link" value=" " onclick="gotopath('importaEsportaExcel.php')"/></div><br>
				<div class="linkList" onclick="gotopath('visualizzaLotti.php')" >Visualizza l'elenco dei lotti e scarica l' excel corrispondente<input type="button" class="link" value=" " onclick="gotopath('visualizzaLotti.php')"/></div><br>
				<div class="linkList" onclick="gotopath('inserisciColonne.php')" >Gestisci tabelle General Numbering, Commesse ecc...<input type="button" class="link" value=" " onclick="gotopath('inserisciColonne.php')"/></div>
			</div>
		</div>
		<div id="footer">
			<!--<hr size='1' style='border-color:white;'>-->
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>

