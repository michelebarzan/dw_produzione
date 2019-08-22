<?php
	include "connessione.php";
	include "Session.php";

	echo "Inizio l' importazione del file...<br><br>";
	ob_end_flush();
	flush();
	usleep(2000000);
	
	if(set_time_limit(120))
	{
	
		exec( '"C:\\xampp\\htdocs\\dw_produzione\\files\\importazioneGN\\importaGN.accdb"');
		
		//Messaggi_importazione_GN
		$query="SELECT * FROM Messaggi_importazione_GN";
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
				switch($row['Messaggio'])
				{
					case $row['Messaggio']=="General numbering importato correttamente":
						echo "<b style='color:green'>General numbering importato correttamente</b><br><br>";
						break;
					case strrpos($row['Messaggio'],"Errore:")==true:
						echo "<b style='color:red'>".$row['Messaggio']."</b><br><br>";
						break;
					default:
						echo $row['Messaggio']."<br><br>";
						break;
				}
			}
			aggiornaNull($conn);
		}
	}
	else
		echo "<b style='color:red'>Errore di sistema</b>. Contattare l' amministratore";
	
	function aggiornaNull($conn)
	{
		$query="EXEC [dbo].[aggiornaNull]";
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
?>