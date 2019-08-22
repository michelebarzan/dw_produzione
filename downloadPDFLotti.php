<?php

	include "session.php";
	
	$commessa=$_POST['commessa'];
	$nVersioni=$_POST['nVersioni'];
	$lotto=$_POST['lotto'];
	$id_lotto=$_POST['id_lotto'];
	
	$file = 'C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'etichette_'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'.pdf';
	
	if (file_exists($file)) 
	{
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($file).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		exit;
	}
	else
		echo "file '$file' non trovato";
	

?>