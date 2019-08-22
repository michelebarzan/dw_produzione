<?php

	include "Session.php";
	include "connessione.php";

	$query="SELECT codele,[desc],id FROM elementi_elet";
	
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
		echo "<b style='color:red'>Error retrieving table</b>";
		die();
	}
	else
	{
		$i=0;
		echo '<table id="myTableTabelleGestisciTabelle">';
			echo '<tr>';
				echo '<th style="max-width:20%;width:20%">Codice elemento</th>';
				echo '<th>Descrizione</th>';
				echo '<th style="max-width:20%;width:20%">Azione</th>';
			echo '</tr>';
			while($row=sqlsrv_fetch_array($result))
			{
				echo '<tr>';
					echo '<td id="codele'.$i.'" style="max-width:20%;width:20%" contenteditable>'.$row['codele'].'</td>';
					echo '<td id="desc'.$i.'" contenteditable>'.$row['desc'].'</td>';
					echo '<td style="max-width:20%;width:20%">';
						echo '<input type="button" id="btnModificaComponente" value="Modifica" onclick="modificaComponente('.$i.','.$row['id'].')" />';
						echo '<input type="button" style="margin-left:10px;color:red" id="btnEliminaComponente" value="Elimina" onclick="eliminaComponente('.$row['id'].')" />';
					echo '</td>';
				echo '</tr>';
				$i++;
			}
			echo '<tr>';
				echo '<td id="codele'.$i.'" style="max-width:20%;width:20%" contenteditable></td>';
				echo '<td id="desc'.$i.'" contenteditable></td>';
				echo '<td style="max-width:20%;width:20%">';
					echo '<input type="button" id="btnInserisciComponente" value="Inserisci" onclick="inserisciComponente('.$i.')" />';
				echo '</td>';
			echo '</tr>';
		echo "</table>";
		echo '<div id="push"></div>';
	}
	
?>