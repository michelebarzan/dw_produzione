<?php
	include "connessione.php";
	include "Session.php";
	
	$commessa=$_REQUEST['commessa'];
	
	echo '<tr class="myTableLottiRowHeader" >';
		echo '<th>Commessa</th>';
		echo '<th>TotPannelli</th>';
		echo '<th style="text-align:center">UltimaVersione</th>';
		echo '<th>Data</th>';
		echo '<th>Note</th>';
		echo '<th>Descrizione</th>';
		echo '<th>WBS</th>';
		echo '<th>ID Materiale</th>';
		echo '<th>NVersioni</th>';
		echo '<th>Lotto</th>';
		echo '<th style="text-align:center">Revisioni</th>';
		echo '<th style="text-align:center;width:150px;max-width:150px;">Genera</th>';
		echo '<th style="text-align:center;width:150px;max-width:150px;">Download</th>';
		//echo '<th>Generabile</th>';
	echo '</tr>';
		
		$queryRighe="SELECT lotti.*,commesse.commessa FROM lotti,commesse WHERE lotti.commessa=commesse.id_commessa AND commesse.commessa LIKE '$commessa' ORDER BY lotto DESC";//echo $queryRighe;
		$resultRighe=sqlsrv_query($conn,$queryRighe);
		if($resultRighe==FALSE)
		{
			$queryRighe=str_replace("'","*APICE*",$queryRighe);
			$testoErrore=print_r(sqlsrv_errors(),TRUE);
			$testoErrore=str_replace("'","*APICE*",$testoErrore);
			$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
			$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$queryRighe','".$testoErrore."','".$_SESSION['Username']."')";
			$resultErrori=sqlsrv_query($conn,$queryErrori);
			$queryRighe=str_replace("*APICE*","'",$queryRighe);
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryRighe."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			$rowNum=1;
			$generabili=0;
			while($rowRighe=sqlsrv_fetch_array($resultRighe))
			{
				echo '<tr class="myTableLottiRowNormal" >';
					echo "<td>".$rowRighe['commessa']."</td>";
					echo "<td>".$rowRighe['totPannelli']."</td>";
					if($rowRighe['ultimaVersione']=='-1')
						echo "<td style='color:red; background:#FFB6B6;font-weight:bold;font-family:Exo,San Serif;text-align:center'>X</td>";
					else
						echo "<td style='color:green; background:#80FF89;font-weight:bold;font-family:Exo,San Serif;text-align:center'>V</td>";
					echo "<td>".$rowRighe['data']->format('d/m/Y H:m:s')."</td>";
					echo "<td style='max-width:300px;word-wrap: break-word;' onfocusout='modifica(".$rowNum.",4,".$rowRighe['id_lotto'].")' contenteditable>".$rowRighe['note']."</td>";
					echo "<td style='max-width:300px;word-wrap: break-word;' onfocusout='modifica(".$rowNum.",5,".$rowRighe['id_lotto'].")' contenteditable>".$rowRighe['Descrizione']."</td>";
					echo "<td style='max-width:300px;word-wrap: break-word;' onfocusout='modifica(".$rowNum.",6,".$rowRighe['id_lotto'].")' contenteditable>".$rowRighe['WBS']."</td>";
					echo "<td style='max-width:300px;word-wrap: break-word;' onfocusout='modifica(".$rowNum.",7,".$rowRighe['id_lotto'].")' contenteditable>".$rowRighe['ID Materiale']."</td>";

					echo "<td>".$rowRighe['nVersioni']."</td>";
					echo "<td>".$rowRighe['lotto']."</td>";
					if($rowRighe['avvisoRevisioneCodcab']=='true')
						echo '<td style="text-align:center;color:red"><i class="fas fa-exclamation-triangle" title="Nel lotto sono presenti cabine revisionate"></i></td>';
					else
						echo "<td></td>";
					if($rowRighe['generabile']!=NULL)
						echo "<td style='text-align:center;width:150px;max-width:150px;'><button id='generaButtonG' class='generaButtonG' onclick='erroreGenerabile(".htmlspecialchars(json_encode($rowRighe['lotto'])).",".htmlspecialchars(json_encode($rowRighe['commessa'])).")' data-toggle='tooltip' title='Non generabile. Errore: ".$rowRighe['generabile']."' value=' ' ></button></td>";
					else
					{
						echo "<td style='text-align:center;width:150px;max-width:150px;'>";
							echo "<input type='button' id='generaButton".$generabili."' class='generaButton' onclick='genera($generabili,".$rowRighe['id_lotto'].")' data-toggle='tooltip' title='Genera ultima versione' />";
							echo "<div id='stato".$generabili."' class='stato'></div>";
						echo "</td>";
						$generabili++;
					}
					
					echo "<td style='text-align:center;width:150px;max-width:150px;'>";
						if($rowRighe['nVersioni']>0)
						{
							echo '<form action="downloadExcelLotti.php" method="POST" id="downloadForm'.$rowRighe['id_lotto'].'" name="downloadForm'.$rowRighe['id_lotto'].'" style="height:20px;display:inline-block;">';
								echo "<input type='submit' id='downloadButton".$rowRighe['id_lotto']."' class='downloadButton' value='' data-toggle='tooltip' title='Scarica ultima versione' />";
								echo "<input type='hidden' name='commessa' value='".$rowRighe['commessa']."' />";
								echo "<input type='hidden' name='nVersioni' value='".($rowRighe['nVersioni']-1)."' />";
								echo "<input type='hidden' name='lotto' value='".$rowRighe['lotto']."' />";
								echo "<input type='hidden' name='id_lotto' value='".$rowRighe['id_lotto']."' />";
							echo "</form>";
							if($rowRighe['nVersioni']>1)
							{
								echo "<br><input type='button' id='btnElencoVersioni".$rowRighe['id_lotto']."' class='btnElencoVersioni' onclick='versioni(".$rowRighe['id_lotto'].")' value='Versioni precedenti' />";
								echo "<div id='versioni".$rowRighe['id_lotto']."' class='versioni'>";
									echo "<input type='button' id='chiudiButton' class='chiudiButton' onclick='chiudiVersioni(".$rowRighe['id_lotto'].")' value=' ' /><br>";
									echo "<b style='margin-bottom:2px;'>Versioni precedenti:</b>";
									$i=0;
									while($i<($rowRighe['nVersioni']-1))
									{
										echo '<form action="downloadExcelLotti.php" method="POST" style="height:10px;display:inline-block;">';
											echo "<input type='submit' class='btnVersioni' value='Versione$i' data-toggle='tooltip' title='Scarica versione $i' />";
											echo "<input type='hidden' name='commessa' value='".$rowRighe['commessa']."' />";
											echo "<input type='hidden' name='nVersioni' value='".$i."' />";
											echo "<input type='hidden' name='lotto' value='".$rowRighe['lotto']."' />";
											echo "<input type='hidden' name='id_lotto' value='".$rowRighe['id_lotto']."' />";
										echo "</form>";
										$i++;
									}
								echo "</div>";
							}
						}
						else
						{
							echo "<input type='button' id='downloadButtonDisabled' class='downloadButtonDisabled' value='' data-toggle='tooltip' title='Nessun file generato' />";
						}
					echo "</td>";
				echo '</tr>';
				$rowNum++;
			}
			
		}
?>