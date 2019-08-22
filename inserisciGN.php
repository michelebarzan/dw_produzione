<?php
	include "connessione.php";
	include "Session.php";
	
	$q="INSERT INTO general_numbering (commessa,ponte,firezone,tipo,verso,lato_nave,kit_cabina,finitura_A,finitura_B,finitura_C,settimana,numero_cabina,lotto) VALUES (".implode(",",$_REQUEST).")";
	$r=sqlsrv_query($conn,$q);
	if($r==FALSE)
	{
		$q=str_replace("'","*APICE*",$q);
		$testoErrore=print_r(sqlsrv_errors(),TRUE);
		$testoErrore=str_replace("'","*APICE*",$testoErrore);
		$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
		$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$q','".$testoErrore."','".$_SESSION['Username']."')";
		$resultErrori=sqlsrv_query($conn,$queryErrori);
		$q=str_replace("*APICE*","'",$q);
		echo "<b style='color:red'>Error executing query</b>";
		die();
		//echo "<b style='color:red'>Error during query execution<br>Query: $q</b><br>";
		//die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo "<b style='color:green'>Row inserted successfully</b>";
	}
	?>