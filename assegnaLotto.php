<?php
	include "connessione.php";
	include "Session.php";
	
	$id_gn_array=json_decode($_REQUEST['JSONid_gn_array']);
	$lotto=$_REQUEST['lotto'];
	$acronimo=$_REQUEST['acronimo'];
	
	$last_id_gn=end($id_gn_array);
	array_pop($id_gn_array);
	
	set_time_limit(240);
		
	if ( sqlsrv_begin_transaction( $conn ) === false ) 
		die("error");

	/*$q1="ALTER TABLE general_numbering DISABLE TRIGGER aggiornaLotti";
	$r1=sqlsrv_query($conn,$q1);
	$q2="ALTER TABLE general_numbering DISABLE TRIGGER aggiornaLotti_bf";
	$r2=sqlsrv_query($conn,$q2);*/
	$q3="ALTER TABLE general_numbering DISABLE TRIGGER pulisciVuoti";
	$r3=sqlsrv_query($conn,$q3);
	
	$q4="UPDATE general_numbering SET lotto".$acronimo."='$lotto' WHERE id_gn IN ('".implode("','",$id_gn_array)."')";

	$r4=sqlsrv_query($conn,$q4);
	
	/*$q5="ALTER TABLE general_numbering ENABLE TRIGGER aggiornaLotti";
	$r5=sqlsrv_query($conn,$q5);
	$q6="ALTER TABLE general_numbering ENABLE TRIGGER aggiornaLotti_bf";
	$r6=sqlsrv_query($conn,$q6);*/
	$q7="ALTER TABLE general_numbering ENABLE TRIGGER pulisciVuoti";
	$r7=sqlsrv_query($conn,$q7);
	$r5=true;
	$r6=true;
	$r1=true;
	$r2=true;
	
	$q8="UPDATE general_numbering SET lotto".$acronimo."='$lotto' WHERE id_gn = $last_id_gn";

	$r8=sqlsrv_query($conn,$q8);
	
	if( $r1 && $r2 && $r3 && $r4 && $r5 && $r6 && $r7 && $r8)
	{
		sqlsrv_commit( $conn );
		echo "ok";
	}
	else
	{
		sqlsrv_rollback( $conn );
		die("error");
	}
	
?>