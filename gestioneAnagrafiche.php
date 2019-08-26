<?php
	include "Session.php";
	include "connessione.php";
	
	$pageName="Gestione anagrafiche";
	$appName="Produzione";
?>
<html>
	<head>
		<title><?php echo $appName."&nbsp&#8594&nbsp".$pageName; ?></title>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
		<link rel="stylesheet" href="css/styleV12.css" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="editableTable/editableTable.js"></script>
		<link rel="stylesheet" href="editableTable/editableTable.css" />
		<script src="jquery.table2excel.js"></script>
		<link rel="stylesheet" href="fontawesomepro/css/fontawesomepro.css" />
		<script src="spinner.js"></script>
		<link rel="stylesheet" href="css/spinner.css" />
		<script src="struttura.js"></script>
		<script>
			function resetStyle(button)
			{
				var all = document.getElementsByClassName("functionListButton");
				for (var i = 0; i < all.length; i++) 
				{
					all[i].classList.remove("functionListButtonActive");
				}
				button.classList.add("functionListButtonActive");
			}
			function getTable(table,orderBy,orderType)
			{
				if(table=="produzione_bf_finiture")
				{
					getEditableTable
					({
						table:'produzione_bf_finiture',
						readOnlyColumns:['id_finitura','commessa'],
						noInsertColumns:['id_finitura'],
						container:'containerGestioneAnagrafiche',
						foreignKeys:[['commessa','commesse','id_commessa','commessa']],
						orderBy:orderBy,
						orderType:orderType
					});
				}
				if(table=="produzione_bf_delta_articoli")
				{
					getEditableTable
					({
						table:'produzione_bf_delta_articoli',
						readOnlyColumns:['id_articolo','commessa','utente','data_importazione'],
						noInsertColumns:['id_articolo'],
						noFilterColumns:['data_importazione'],
						container:'containerGestioneAnagrafiche',
						foreignKeys:[['utente','utenti','id_utente','username']],
						orderBy:orderBy,
						orderType:orderType
					});
				}	
				if(table=="produzione_bf_kit_bifacciali")
				{
					getEditableTable
					({
						table:'produzione_bf_kit_bifacciali',
						readOnlyColumns:['id_kit_bifacciale','utente','data_importazione','commessa'],
						noInsertColumns:['id_kit_bifacciale','utente','data_importazione'],
						noFilterColumns:['data_importazione'],
						container:'containerGestioneAnagrafiche',
						foreignKeys:[['commessa','commesse','id_commessa','commessa'],['utente','utenti','id_utente','username']],
						orderBy:orderBy,
						orderType:orderType
					});
				}
				if(table=="produzione_bf_lavorazioni_x_v")
				{
					getEditableTable
					({
						table:'produzione_bf_lavorazioni_x_v',
						readOnlyColumns:['id'],
						noInsertColumns:['id'],
						primaryKey:"id",
						container:'containerGestioneAnagrafiche',
						orderBy:orderBy,
						orderType:orderType
					});
				}
				if(table=="produzione_bf_lavorazioni_y_v")
				{
					getEditableTable
					({
						table:'produzione_bf_lavorazioni_y_v',
						readOnlyColumns:['id'],
						noInsertColumns:['id'],
						primaryKey:"id",
						container:'containerGestioneAnagrafiche',
						orderBy:orderBy,
						orderType:orderType
					});
				}
				if(table=="elementi_elet")
				{
					getEditableTable
					({
						table:'elementi_elet',
						readOnlyColumns:['id'],
						noInsertColumns:['id'],
						container:'containerGestioneAnagrafiche',
						orderBy:orderBy,
						orderType:orderType
					});
				}
			}
			function editableTableLoad()
			{}
		</script>
	</head>
	<body>
		<?php include('struttura.php'); ?>
		<div class="funcionListContainer" style="top:100;">
			<div class="functionList">
				<button class="functionListButton" onclick="resetStyle(this);getTable('elementi_elet')">Componenti elettrici</button>
				<button class="functionListButton" onclick="resetStyle(this);getTable('produzione_bf_finiture')">Finiture pannelli bifacciali</button>
				<button class="functionListButton" onclick="resetStyle(this);getTable('produzione_bf_delta_articoli')">Articoli pannelli bifacciali</button>
				<button class="functionListButton" onclick="resetStyle(this);getTable('produzione_bf_kit_bifacciali')">Pannelli bifacciali</button>
				<button class="functionListButton" onclick="resetStyle(this);getTable('produzione_bf_lavorazioni_x_v')">Lavorazioni x P. B.</button>
				<button class="functionListButton" onclick="resetStyle(this);getTable('produzione_bf_lavorazioni_y_v')">Lavorazioni y P. B.</button>
			</div>
		</div>
		<div class="absoluteActionBar">
			<div class="absoluteActionBarElement">Righe: <span id="rowsNumEditableTable"></span></div>
			<button class="absoluteActionBarButton" onclick="excelExport('containerGestioneAnagrafiche')">Esporta <i style="margin-left:5px;color:green" class="far fa-file-excel"></i></button>
			<button class="absoluteActionBarButton" onclick="resetFilters();getTable(selectetTable)">Ripristina <i style="margin-left:5px" class="fal fa-filter"></i></button>
		</div>
		<div id="containerGestioneAnagrafiche"></div>
		<div id="footer">
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>

