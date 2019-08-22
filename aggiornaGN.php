<?php
	include "connessione.php";
	include "Session.php";
	
	$nomeColonna=$_REQUEST['nomeColonna'];
	$valore=$_REQUEST['valore'];
	$id=$_REQUEST['id'];
	
	if($nomeColonna=="Lotto")
	{
		$valore = preg_replace("/[^0-9,.]/", "", $valore );
	}
	
	$q="UPDATE general_numbering SET [$nomeColonna]='$valore' WHERE id_gn=$id";
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