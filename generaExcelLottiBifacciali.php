<?php
	include "connessione.php";
	include "Session.php";
	
	$id_lotto=$_REQUEST['id_lotto'];
	
	
	$commessa=getCommessa($conn,$id_lotto);
	$id_commessa=getId_commessa($conn,$commessa);
	$lotto=getLotto($conn,$id_lotto);
	
	set_time_limit(240);
	
	flush();
	usleep(1000000);
	
	if(controllaLotto_corrente($conn))
	{
		//Riempio Lotto_corrente
		riempiLotto_corrente($conn,$id_lotto,$id_commessa,$lotto,$commessa);
		
		$nVersione=getVersione($conn,$id_lotto);
		
		//Cancello file excel
		exec('del "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\SCHEDA_PRODUZIONE_bf.xlsx"');
		
		//faccio partire excel 
		exec( '"C:\\Program Files (x86)\\Microsoft Office\\Office15\\EXCEL.EXE" "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\SCHEDA_PRODUZIONE_bf.xlsm"');
		
		//Copio il file excel e lo rinomino
		exec('copy "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\SCHEDA_PRODUZIONE_bf.xlsx" "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'SCHEDA_PRODUZIONE_'.$commessa.'_'.$lotto.'_Versione'.$nVersione.'.xlsx"');
		//Cancello file excel
		exec('del "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\SCHEDA_PRODUZIONE_bf.xlsx"');
		
		//faccio partire access 
		exec( '"C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\Etichette_bf.accdb"');
		
		//Copio il file pdf e lo rinomino
		exec('copy "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\Etichette_Assemblaggio_elettrico_BF.pdf" "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_Assemblaggio_elettrico_BF'.$commessa.'_'.$lotto.'_Versione'.$nVersione.'.pdf"');
		//Cancello file pdf
		exec('del "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\Etichette_Assemblaggio_elettrico_BF.pdf"');
		
		//Copio il file pdf e lo rinomino
		exec('copy "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\Etichette_LineaPannelli_BF.pdf" "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_LineaPannelli_BF'.$commessa.'_'.$lotto.'_Versione'.$nVersione.'.pdf"');
		//Cancello file pdf
		exec('del "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\Etichette_LineaPannelli_BF.pdf"');
		
		//Copio il file pdf e lo rinomino
		exec('copy "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\Etichette_Punzonatura_BF.pdf" "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_Punzonatura_BF'.$commessa.'_'.$lotto.'_Versione'.$nVersione.'.pdf"');
		//Cancello file pdf
		exec('del "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\Etichette_Punzonatura_BF.pdf"');
		
		//Copio il file pdf e lo rinomino
		exec('copy "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\Etichette_Cesoiatura_BF.pdf" "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_Cesoiatura_BFs'.$commessa.'_'.$lotto.'_Versione'.$nVersione.'.pdf"');
		//Cancello file pdf
		exec('del "C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\Etichette_Cesoiatura_BF.pdf"');
		
		incrementaNVersioni($conn,$id_lotto);
		setUltimaVersione($conn,$id_lotto);
		
		//Svuoto Lotto_corrente
		svuotaLotto_corrente($conn);
		
		$output2 = shell_exec('cd C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'SCHEDA_PRODUZIONE_'.$commessa.'_'.$lotto.'_Versione'.$nVersione.'.xlsx 2>&1');
		$output3 = shell_exec('cd C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_Assemblaggio_elettrico_BF'.$commessa.'_'.$lotto.'_Versione'.$nVersione.'.pdf 2>&1');
		$output4 = shell_exec('cd C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_LineaPannelli_BF'.$commessa.'_'.$lotto.'_Versione'.$nVersione.'.pdf 2>&1');
		$output5 = shell_exec('cd C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_Punzonatura_BF'.$commessa.'_'.$lotto.'_Versione'.$nVersione.'.pdf 2>&1');
		$output6 = shell_exec('cd C:\\xampp\\htdocs\\dw_produzione\\files\\lotti\\'.$id_lotto.'Etichette_Cesoiatura_BFs'.$commessa.'_'.$lotto.'_Versione'.$nVersione.'.pdf 2>&1');
	
		flush();
		usleep(1000000);
		
		if (strpos($output3, 'Impossibile') !== false && strpos($output2, 'Impossibile') !== false && strpos($output3, 'Impossibile') !== false && strpos($output4, 'Impossibile') !== false && strpos($output5, 'Impossibile') !== false && strpos($output6, 'Impossibile') !== false) 
			echo "<br><b style='color:red'>Errore: impossibile generare l' Excel</b><br>";
		else
		{
			rimuoviAlertRevisioni($conn,$id_lotto);
			echo "<br><b style='color:green'>Excel generato correttamente</b><br>";
		}
	}
	else
	{
		flush();
		usleep(1000000);
		echo "<br><b style='color:red'>Errore: impossibile generare l' Excel. Riprova tra 1 minuto</b>";
	}
		
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function rimuoviAlertRevisioni($conn,$id_lotto)
	{
		$query="UPDATE lotti_bf SET avvisoRevisioneCodcab='false' WHERE id_lotto=$id_lotto";
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
	}
	function incrementaNVersioni($conn,$id_lotto)
	{
		$query="UPDATE lotti_bf SET nVersioni=nVersioni+1 WHERE id_lotto=$id_lotto";
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
	}
	function getVersione($conn,$id_lotto)
	{
		$query="SELECT nVersioni FROM lotti_bf WHERE id_lotto=$id_lotto";
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
				return $row['nVersioni'];
			}
		}
	}
	function setUltimaVersione($conn,$id_lotto)
	{
		$query="UPDATE lotti_bf SET ultimaVersione=0 WHERE id_lotto=$id_lotto";
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
	}
	function getCommessa($conn,$id_lotto)
	{
		$query="SELECT commesse.commessa FROM lotti_bf,commesse WHERE lotti_bf.commessa=commesse.id_commessa AND id_lotto=$id_lotto";
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
				return $row['commessa'];
			}
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
	function getLotto($conn,$id_lotto)
	{
		$query="SELECT lotto FROM lotti_bf WHERE id_lotto=$id_lotto";
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
				return $row['lotto'];
			}
		}
	}
	function riempiLotto_corrente($conn,$id_lotto,$id_commessa,$lotto,$commessa)
	{
		$query="INSERT INTO Lotto_corrente_bf (id_lotto,id_commessa,lotto,commessa) VALUES ($id_lotto,$id_commessa,$lotto,'$commessa')";
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
	}
	function svuotaLotto_corrente($conn)
	{
		$query="DELETE Lotto_corrente_bf FROM Lotto_corrente_bf";
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
	}
	function controllaLotto_corrente($conn)
	{
		$query="SELECT COUNT(*) AS n FROM Lotto_corrente_bf";
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
				if($row['n']==0)
					return true;
				else
					return false;
			}
		}
	}
?>