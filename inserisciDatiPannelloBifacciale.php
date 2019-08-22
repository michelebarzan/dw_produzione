<?php
	include "connessione.php";
	include "Session.php";
	
	$data=json_decode($_REQUEST['JSONdata']);
	$columns=json_decode($_REQUEST['JSONcolumns']);
	$commessa=$_REQUEST['commessa'];
	$codice_cabina=$_REQUEST['nomeCabina'];
	$revisione_cabina=$_REQUEST['revisioneCabina'];
	$descrizione_kit=$_REQUEST['descrizione'];
	
	$id_commessa=getIdCommessa($conn,$commessa);
	if($id_commessa==0)
	{
		die("commessainesistente");
	}
	
	$id_utente=getIdUtente($conn,$_SESSION['Username']);
	
	$articoli=[];
	
	$i=0;
	foreach ($data as $key => $value)
	{
		$row = json_decode(json_encode($value), True);
		$j=0;
		foreach ($row as $rowItem)
		{
			if($columns[$j]=="Art.")
				array_push($articoli,$rowItem);
			$j++;
		}
		$i++;
	}
	
	$articoli=array_unique($articoli);
	
	$coloriMancanti=checkFiniture($conn,$data);
	if(count($coloriMancanti)>0)
		die("finiture");
	
	$articoliMancanti=checkArticoli($conn,$articoli);
	if(count($articoliMancanti)==0)
	{
		rimuoviDuplicati($conn,$codice_cabina,$revisione_cabina);
		$q="INSERT INTO [dbo].[produzione_bf_kit_bifacciali]
           ([numero_pannello]
           ,[articolo]
           ,[larghezza]
           ,[altezza]
           ,[colore]
           ,[numero_documento]
           ,[revisione_pannello]
           ,[fogli]
           ,[codice_cabina]
           ,[revisione_cabina]
           ,[descrizione_kit]
           ,[data_importazione]
           ,[utente]
           ,[certificato]
           ,[quantita]
           ,[commessa]) ";
		   
		foreach ($data as $rowItem)
		{
			$row = json_decode(json_encode($rowItem), True);
			$q.="SELECT '".$row['N° pann.']."'
           ,produzione_bf_delta_articoli.id_articolo
           ,'".$row['Largh.']."'
           ,'".$row['Altezza']."'
           ,'".$row['Colore']."'
           ,'".$row['N° doc.']."'
           ,'".$row['Rev.']."'
           ,'".$row['Fogli']."'
           ,'$codice_cabina'
           ,'$revisione_cabina'
           ,'$descrizione_kit'
           ,GETDATE()
           ,$id_utente
           ,'".$row['Cert.']."'
           ,'".$row['Q.tà']."'
           ,$id_commessa FROM dbo.produzione_bf_delta_articoli
			WHERE (produzione_bf_delta_articoli.articolo = '".$row['Art.']."') UNION ALL ";
		}
		$q=substr($q, 0, -11);
		$r=sqlsrv_query($conn,$q);
		if($r==FALSE)
		{
			die("error");
		}
		else
		{
			echo "ok";
		}
	}
	else
	{
		echo json_encode($articoliMancanti);
	}
	
	function getIdCommessa($conn,$commessa)
	{
		$q="SELECT id_commessa FROM [dbo].[commesse] WHERE commessa='$commessa'";
		$r=sqlsrv_query($conn,$q);
		if($r==FALSE)
		{
			die("error");
		}
		else
		{
			while($row=sqlsrv_fetch_array($r))
			{
				return $row["id_commessa"];
			}
			return 0;
		}
	}
	
	function getIdUtente($conn,$username) 
	{
		$q="SELECT id_utente FROM utenti WHERE username='$username'";
		$r=sqlsrv_query($conn,$q);
		if($r==FALSE)
		{
			die("error");
		}
		else
		{
			while($row=sqlsrv_fetch_array($r))
			{
				return $row['id_utente'];
			}
		}
	}
	
	function checkFiniture($conn,$data)
	{
		$coloriMancanti=[];
		$coloriDb=[];
		$colori=[];
		foreach ($data as $rowItem)
		{
			$row = json_decode(json_encode($rowItem), True);
			array_push($colori,$row['Colore']);
		}
		$colori=array_unique($colori);
		$q="SELECT distinct colore FROM [dbo].[produzione_bf_finiture]";
		$r=sqlsrv_query($conn,$q);
		if($r==FALSE)
		{
			/*echo "<br><br>Errore esecuzione query<br>Query: ".$q."<br>Errore: ";
				die(print_r(sqlsrv_errors(),TRUE));*/
			die("error");
		}
		else
		{
			while($row2=sqlsrv_fetch_array($r))
			{
				array_push($coloriDb,$row2["colore"]);
			}
			$coloriMancanti=array_diff($colori,$coloriDb);
			return $coloriMancanti;
		}
	}
	
	function checkArticoli($conn,$articoli)
	{
		$articoliMancanti=[];
		$articoliEsistenti=[];
		$q="SELECT DISTINCT [articolo] FROM [dbo].[produzione_bf_delta_articoli]";
		$r=sqlsrv_query($conn,$q);
		if($r==FALSE)
		{
			die("error");
		}
		else
		{
			while($row=sqlsrv_fetch_array($r))
			{
				array_push($articoliEsistenti,$row["articolo"]);
			}
			$articoliMancanti=array_diff($articoli,$articoliEsistenti);
			return $articoliMancanti;
		}
	}
	
	function rimuoviDuplicati($conn,$codice_cabina,$revisione_cabina)
	{
		$q="DELETE [dbo].[produzione_bf_kit_bifacciali] FROM [dbo].[produzione_bf_delta_articoli] WHERE codice_cabina='$codice_cabina' AND revisione_cabina='$revisione_cabina'";
		$r=sqlsrv_query($conn,$q);
		if($r==FALSE)
		{
			die("error");
		}
	}
	
?>




























