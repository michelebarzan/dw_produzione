<?php
	include "connessione.php";
	include "Session.php";
	
	$campo=$_REQUEST['campo'];
	$valore=$_REQUEST['valore'];
	$commessa=$_REQUEST['commessa'];
	
	if($commessa==NULL)
	{
		echo "<b style='color:red'>Scegli una commessa</b>";
		die();
	}
	$q="UPDATE commesse SET [$campo]='$valore' WHERE commessa='$commessa'";
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
	}
	else
	{
		echo "<b style='color:green'>Commessa aggiornata</b>";
	}
	?>