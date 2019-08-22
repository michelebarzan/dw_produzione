<?php
	include "connessione.php";
	include "Session.php";
	
	$q="SELECT COUNT(id_gn) AS n FROM general_numbering";
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
		echo "<b style='color:red'>Error deleting row</b>";
		die();
		/*echo "<b style='color:red'>Error during query execution<br>Query: $q</b><br>";
		die(print_r(sqlsrv_errors(),TRUE));*/
	}
	else
	{
		while($row=sqlsrv_fetch_array($r))
			echo $row['n'];
	}
	?>