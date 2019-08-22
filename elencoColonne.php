<?php
	include "connessione.php";
	include "Session.php";
	
	$q="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_CATALOG = 'dw_dati' AND TABLE_SCHEMA = 'dbo' AND TABLE_NAME = 'general_numbering'";
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
		echo "<b style='color:red'>Errore esecuzione query</b>";
		die();
		/*echo "<b style='color:red'>Error during query execution<br>Query: $q</b><br>";
		die(print_r(sqlsrv_errors(),TRUE));*/
	}
	else
	{
		$rowNum=1;
		while($row=sqlsrv_fetch_array($r))
		{
			if($rowNum==1)
				echo "<b style='color:red'>".$row['COLUMN_NAME']."</b><br>";
			if($rowNum>1 && $rowNum<15)
				echo "<b style='color:#3367d6'>".$row['COLUMN_NAME']."</b><br>";
			if($rowNum>14)
			{
				$query="SELECT COUNT ([".$row['COLUMN_NAME']."]) AS nRighe FROM general_numbering";
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
					while($row2=sqlsrv_fetch_array($result))
					{
						$nRighe=$row2['nRighe'];
					}
				}
				$colonna="'".$row['COLUMN_NAME']."'";
				if($nRighe==0)
					echo $row['COLUMN_NAME'].'&nbsp&nbsp<input type="button" id="eliminaColonna" value=" " onclick="eliminaColonna('.$colonna.')" /><br>';
				else
					echo $row['COLUMN_NAME'].'<br>';
			}
			$rowNum++;
		}
	}
	?>