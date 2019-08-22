<?php
	include "connessione.php";
	include "Session.php";
	
	$valori=$_REQUEST['valori'];
	$lotto=$_REQUEST['lotto'];
	
	set_time_limit(240);
	
	//$valoriSplit=array();
	$valoriSplit=explode("£",$valori);
	
	/* Begin the transaction. */
	if ( sqlsrv_begin_transaction( $conn ) === false ) 
	{
		echo "<b style='color:red'>Errore generale: impossibile avviare la transazione</b>";
		die();
		 //die( print_r( sqlsrv_errors(), true ));
	}

	$q2="ALTER TABLE general_numbering DISABLE TRIGGER aggiornaLotti";
	$r2=sqlsrv_query($conn,$q2);
	if($r2==FALSE)
	{
		$q2=str_replace("'","*APICE*",$q2);
		$testoErrore=print_r(sqlsrv_errors(),TRUE);
		$testoErrore=str_replace("'","*APICE*",$testoErrore);
		$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
		$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$q2','".$testoErrore."','".$_SESSION['Username']."')";
		$resultErrori=sqlsrv_query($conn,$queryErrori);
		$q2=str_replace("*APICE*","'",$q2);
	}

	$i=0;
	while($i<(count($valoriSplit)-2))
	{
		$element=$valoriSplit[$i];
		$commessa=explode("|",$element)[0];
		$numero_cabina=explode("|",$element)[1];
		
		$r1=setLotto($conn,$lotto,$commessa,$numero_cabina);
		if($r1==false)
			break;
		
		$i++;
	}
	
	/*$q3="ALTER TABLE general_numbering ENABLE TRIGGER aggiornaLotti";
	$r3=sqlsrv_query($conn,$q3);
	if($r3==FALSE)
	{
		$q3=str_replace("'","*APICE*",$q3);
		$testoErrore=print_r(sqlsrv_errors(),TRUE);
		$testoErrore=str_replace("'","*APICE*",$testoErrore);
		$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
		$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$q3','".$testoErrore."','".$_SESSION['Username']."')";
		$resultErrori=sqlsrv_query($conn,$queryErrori);
		$q3=str_replace("*APICE*","'",$q3);
	}*/
	$r3=true;
	
	$element=$valoriSplit[$i];
	$commessa=explode("|",$element)[0];
	$numero_cabina=explode("|",$element)[1];
	$r4=setLastLotto($conn,$lotto,$commessa,$numero_cabina);
	
	/* If all queries were successful, commit the transaction. */
	/* Otherwise, rollback the transaction. */
	if( $r1 && $r2 && $r3 && $r4 ) 
	{
		 sqlsrv_commit( $conn );
		 //echo "Transaction committed";
		 echo "<b style='color:green'>Aggiornamento lotti completato</b>";
	} 
	else 
	{
		 sqlsrv_rollback( $conn );
		 echo "<b style='color:red'>Errore aggiornamento lotti: transaction rolled back</b>";
	}
	
	function setLotto($conn,$lotto,$commessa,$numero_cabina)
	{
		$q="UPDATE general_numbering SET lotto='$lotto' WHERE numero_cabina='$numero_cabina' AND commessa=$commessa";
		//echo $q."\n";
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
			return false;
		}
		else
		{
			return true;
		}
	}
	function setLastLotto($conn,$lotto,$commessa,$numero_cabina)
	{
		$q="UPDATE general_numbering SET lotto='$lotto' WHERE numero_cabina='$numero_cabina' AND commessa=$commessa";
		//echo $q."\n";
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
			return false;
		}
		else
		{
			return true;
		}
	}
	
?>