<?php
	include "connessione.php";
	include "Session.php";
	
	$idSessione=session_id();
	$commessa_id=$_REQUEST['commessa'];
	$commessa_id=explode("|", $commessa_id);
	$commessa=$commessa_id[0];
	$id_commessa=$commessa_id[1];
	
	svuotaTmpCommessa($conn,$idSessione);
	riempiTmpCommessa($id_commessa,$commessa,$conn,$idSessione);
		
	echo "Inizio la generazione del file per la commessa $commessa...<br><br>";
	
	//Copip il file e lo rinomino
	exec('copy "C:\\xampp\\htdocs\\dw_produzione\\files\\esportazioneGN\\esportazioneGN.xlsm" "C:\\xampp\\htdocs\\dw_produzione\\files\\esportazioneGN\\esportazioneGN'.$idSessione.'.xlsm"');
	
	ob_end_flush();
	flush();
	usleep(1000000);
	
	//faccio partire excel sul file rinominato
	exec( '"C:\\Program Files (x86)\\Microsoft Office\\Office15\\EXCEL.EXE" "C:\\xampp\\htdocs\\dw_produzione\\files\\esportazioneGN\\esportazioneGN'.$idSessione.'.xlsm"');
	
	//controllo che il file sia stato generato
	$output3 = shell_exec('cd C:\\xampp\\htdocs\\dw_produzione\\files\\esportazioneGN\\esportazioneGN'.$idSessione.'.xlsx 2>&1');
	
	flush();
	usleep(1000000);
	
	if (strpos($output3, 'cannot find') !== false) 
		echo "<b style='color:red'>Errore: impossibile generare l' Excel</b><br><br>";
	else
		echo "<b style='color:green'>Excel generato correttamente</b><br><br>";
	
	
	//------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function svuotaTmpCommessa($conn,$idSessione)
	{
		$query="DELETE tmpCommessa FROM tmpCommessa WHERE utente='$idSessione'";
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
	}
	
	function riempiTmpCommessa($id_commessa,$commessa,$conn,$idSessione)
	{
		$query="INSERT INTO tmpCommessa (id_commessa,commessa,utente) VALUES ($id_commessa,'$commessa','$idSessione')";
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
	}
?>