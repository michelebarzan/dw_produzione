<?php
	include "connessione.php";
	include "Session.php";
	
	$target_dir="files/importazioneGN/";
	$target_file = $target_dir . basename($_FILES["btnFileImporta"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	if (move_uploaded_file($_FILES["btnFileImporta"]["tmp_name"], $target_file)) 
	{
		$_SESSION['risultato']="OK";
		exec('copy "C:\\xampp\\htdocs\\dw_produzione\\files\\importazioneGN\\'.basename($_FILES["btnFileImporta"]["name"]).'" "C:\\xampp\\htdocs\\dw_produzione\\files\\importazioneGN\\gn.xlsx"');
		if(basename($_FILES["btnFileImporta"]["name"])!="gn.xlsx")
			exec('del "C:\\xampp\\htdocs\\dw_produzione\\files\\importazioneGN\\'.basename($_FILES["btnFileImporta"]["name"]));
	} 
	else 
	{
		$_SESSION['risultato']="KO";
	}
	echo "<script>window.location = 'importaEsportaExcel.php' </script>";
?>