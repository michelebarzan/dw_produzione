<?php

	include "session.php";
	
	$file = 'C:\\xampp\\htdocs\\dw_produzione\\files\\esportazioneGN\\esportazioneGN'.session_id().'.xlsx';
	
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
	
	/*ob_end_flush();
	flush();
	usleep(2000000);
	
	exec('del "C:\\xampp\\htdocs\\dw_produzione\\files\\esportazioneGN'.session_id().'.xlsm"');
	exec('del "C:\\xampp\\htdocs\\dw_produzione\\files\\esportazioneGN'.session_id().'.xlsx"');*/

?>