<?php
	include "Session.php";
	include "connessione.php";
	
	$pageName="Homepage";
	$appName="Produzione";
?>
<html>
	<head>
		<title><?php echo $appName."&nbsp&#8594&nbsp".$pageName; ?></title>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
		<link rel="stylesheet" href="css/styleV12.css" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link rel="stylesheet" href="fontawesomepro/css/fontawesomepro.css" />
		<script src="struttura.js"></script>
	</head>
	<body>
		<?php include('struttura.php'); ?>
		<div id="container">
			<div id="content">
				<div id="immagineLogo" class="immagineLogo" ></div>
				<!--<div id="actionList">
					<div class="linkList" onclick="gotopath('generalNumbering.php')" >Consulta e modifica la tabella General Numbering<input type="button" class="link" value=" " onclick="gotopath('generalNumbering.php')"/></div>
					<div class="linkList" onclick="gotopath('importaEsportaExcel.php')" >Importa un file excel nella tabella General Numbering<input type="button" class="link" value=" " onclick="gotopath('importaEsportaExcel.php')"/></div>
					<div class="linkList" onclick="gotopath('importaEsportaExcel.php')" >Esporta un file excel della tabella General Numbering<input type="button" class="link" value=" " onclick="gotopath('importaEsportaExcel.php')"/></div>
					<div class="linkList" onclick="gotopath('visualizzaLotti.php')" >Visualizza l'elenco dei lotti e scarica l' excel corrispondente<input type="button" class="link" value=" " onclick="gotopath('visualizzaLotti.php')"/></div>
					<div class="linkList" onclick="gotopath('gestionePannelloBifacciale.php')" >Gestisci e importa i pannelli bifacciali<input type="button" class="link" value=" " onclick="gotopath('gestionePannelloBifacciale.php')"/></div>
					<div class="linkList" onclick="gotopath('gestioneAnagrafiche.php')" >Gestisci le tabelle e le anagrafiche<input type="button" class="link" value=" " onclick="gotopath('gestioneAnagrafiche.php')"/></div>
				</div>-->
				<div class="homepageLinkContainer">
					<div class="homepageLink" title="Consulta e modifica la tabella General Numbering" onclick="gotopath('generalNumbering.php')">
						<i class="fal fa-table fa-2x"></i>
						<span>General<br>Numbering</span>
					</div>
					<div class="homepageLink" title="Visualizza l'elenco dei lotti e scarica l' excel corrispondente" onclick="gotopath('visualizzaLotti.php')">
						<i class="fal fa-th-list fa-2x"></i>
						<span>Visualizza<br>lotti</span>
					</div>
					<div class="homepageLink" title="Visualizza l'elenco dei lotti bifacciali e scarica l' excel corrispondente" onclick="gotopath('visualizzaLottiBifacciali.php')">
						<i class="fal fa-th-list fa-2x"></i>
						<span>Visualizza lotti<br>bifacciali</span>
					</div>
					<div class="homepageLink" title="Visualizza l'elenco dei lotti monobifacciali e scarica l' excel corrispondente" onclick="gotopath('visualizzaLottiMonobifacciali.php')">
						<i class="fal fa-th-list fa-2x"></i>
						<span>Visualizza lotti<br>monobifacciali</span>
					</div>
					<div class="homepageLink" title="Visualizza l'elenco dei lotti nuovibifacciali e scarica l' excel corrispondente" onclick="gotopath('visualizzaLottiNuovibifacciali.php')">
						<i class="fal fa-th-list fa-2x"></i>
						<span>Visualizza lotti<br>nuovibifacciali</span>
					</div>
					<div class="homepageLink" title="Gestisci e importa i pannelli bifacciali" onclick="gotopath('gestionePannelloBifacciale.php')">
						<i class="fal fa-file-excel fa-2x"></i>
						<span>Gestione pannello<br>bifacciale</span>
					</div>
					<div class="homepageLink" title="Gestisci le tabelle e le anagrafiche" onclick="gotopath('gestioneAnagrafiche.php')">
						<i class="fal fa-database fa-2x"></i>
						<span>Gestione<br>anagrafiche</span>
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>




