<?php
	include "connessione.php";
	include "Session.php";
	
	$nomeColonna=$_REQUEST['nomeColonna'];
	$valore=$_REQUEST['valore'];
	$id=$_REQUEST['id'];
	
	$q="UPDATE lotti_bf SET [$nomeColonna]='$valore' WHERE id_lotto=$id";
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
		echo "<b style='color:green'>Column '$nomeColonna' updated successfully</b>";
	}
	?>