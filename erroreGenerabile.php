<?php
	include "connessione.php";
	include "Session.php";
	
	$lotto=$_REQUEST['lotto'];
	$commessa=$_REQUEST['commessa'];
	$id_commessa=getId_commessa($conn,$commessa);
	
	$q="SELECT * FROM Lotti_non_generabili WHERE lotto='$lotto' AND commessa=$id_commessa";
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
		echo "Error";
		die();
		/*echo "<b style='color:red'>Error during query execution<br>Query: $q</b><br>";
		die(print_r(sqlsrv_errors(),TRUE));*/
	}
	else
	{
		while($row=sqlsrv_fetch_array($r))
		{
			echo $row['Expr1'].": ".$row['kit_cabina'].", ".$row['numero_cabina']."\n";
		}
	}
	
	function getId_commessa($conn,$commessa)
	{
		$query="SELECT commesse.id_commessa FROM commesse WHERE commesse.commessa='$commessa'";
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
		else
		{
			while($row=sqlsrv_fetch_array($result))
			{
				return $row['id_commessa'];
			}
		}
	}
	?>