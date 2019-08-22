<?php
	include "connessione.php";
	include "Session.php";
	
	$codele=$_REQUEST['codele'];
	$desc=$_REQUEST['desc'];
	
	$q="INSERT INTO elementi_elet (codele,[desc]) VALUES ('$codele','$desc')";
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
		echo "<b style='color:red'>Errore: inserimento annullato  (ricorda che il codice elemento deve essere univoco)</b>";
		die();
	}
	else
	{
		echo "<b style='color:green'>Inserimento completato</b>";
	}
	?>