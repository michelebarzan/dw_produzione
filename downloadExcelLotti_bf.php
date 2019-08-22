<?php

	include "session.php";
	
	$commessa=$_POST['commessa'];
	$nVersioni=$_POST['nVersioni'];
	$lotto=$_POST['lotto'];
	$id_lotto=$_POST['id_lotto'];
		
	//$file = 'C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'SCHEDA_PRODUZIONE_'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'.xlsx';
	//$file2 = 'C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'etichette_'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'.pdf';
		
	$output1 = shell_exec('C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\rar a "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'scheda_etichette_bf_'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'" "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'SCHEDA_PRODUZIONE_'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'.xlsx" 2>&1');
	$output2 = shell_exec('C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\rar a "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'scheda_etichette_bf_'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'" "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_Assemblaggio_elettrico_BF'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'.pdf" 2>&1');
	$output2 = shell_exec('C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\rar a "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'scheda_etichette_bf_'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'" "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_LineaPannelli_BF'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'.pdf" 2>&1');
	$output2 = shell_exec('C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\rar a "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'scheda_etichette_bf_'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'" "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_Punzonatura_BF'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'.pdf" 2>&1');
	$output2 = shell_exec('C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\rar a "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'scheda_etichette_bf_'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'" "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_Cesoiatura_BFs'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'.pdf" 2>&1');
	
	$output3 = shell_exec('cd "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'scheda_etichette_bf_'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'.rar" 2>&1');
	
	if (strpos($output3, 'Impossibile') !== false) 
	{
		echo "1:".$output1."<br><br>";
		echo "2:".$output2."<br><br>";
		echo "3:".$output3."<br><br>";
		echo "<b style='color:red'>Errore: impossibile copiare i file nell' archivio</b><br><br>";
		die();
	}
	
	$rar='C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'scheda_etichette_bf_'.$commessa.'_'.$lotto.'_Versione'.$nVersioni.'.rar';
	
	if (file_exists($rar)) 
	{
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($rar).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($rar));
		readfile($rar);
		exit;
	}
	else
		echo "file $rar non trovato";
	
?>