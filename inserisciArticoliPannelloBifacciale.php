<?php
	include "connessione.php";
	include "Session.php";
	
	$query=$_REQUEST['query'];
	
	$r=sqlsrv_query($conn,$query);
	if($r==FALSE)
	{
		echo "error";
		echo "<br><br>Errore esecuzione query<br>Query: ".$query."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo "ok";
	}
	
?>




























