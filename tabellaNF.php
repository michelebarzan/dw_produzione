<?php
	include "connessione.php";
	include "Session.php";
		
	if(set_time_limit(120))
	{
		$nRighe=$_REQUEST['nRighe'];
		
		$commessa=$_REQUEST['commessa'];
		$ponte=$_REQUEST['ponte'];
		$firezone=$_REQUEST['firezone'];
		$tipo=$_REQUEST['tipo'];
		$verso=$_REQUEST['verso'];
		$lato_nave=$_REQUEST['lato_nave'];
		$kit_cabina=$_REQUEST['kit_cabina'];
		$finitura_A=$_REQUEST['finitura_A'];
		$finitura_B=$_REQUEST['finitura_B'];
		$finitura_C=$_REQUEST['finitura_C'];
		$settimana=$_REQUEST['settimana'];
		$numero_cabina=$_REQUEST['numero_cabina'];
		$lotto=$_REQUEST['lotto'];
		
		$tmp = array_count_values($_REQUEST);
		$cnt = $tmp["%"];
		
		if($nRighe!="*")
		{
			if ( $cnt!=(count($_REQUEST)-1))
				$nRighe="*";
		}
		
		if($nRighe=="*")
			$filtro="";
		else
			$filtro="TOP ($nRighe)";
		
			
		echo '<tr class="myTableRowHeader">';
			if($commessa=='%')
				echo '<th>Commessa';
			else
				echo '<th style="color:#4C91CB">Commessa';
				costruisciSelectFK($conn,"commessa",$commessa);
			echo '</th>';
			if($ponte=='%')
				echo '<th>Ponte';
			else
				echo '<th style="color:#4C91CB">Ponte';
				costruisciSelect($conn,"ponte",$ponte);
			echo '</th>';
			if($firezone=='%')
				echo '<th>Firezone';
			else
				echo '<th style="color:#4C91CB">Firezone';
				costruisciSelect($conn,"firezone",$firezone);
			echo '</th>';
			if($tipo=='%')
				echo '<th>Tipo';
			else
				echo '<th style="color:#4C91CB">Tipo';
				costruisciSelect($conn,"tipo",$tipo);
			echo '</th>';
			if($verso=='%')
				echo '<th>Verso';
			else
				echo '<th style="color:#4C91CB">Verso';
				costruisciSelect($conn,"verso",$verso);
			echo '</th>';
			if($lato_nave=='%')
				echo '<th>Lato_nave';
			else
				echo '<th style="color:#4C91CB">Lato_nave';
				costruisciSelect($conn,"lato_nave",$lato_nave);
			echo '</th>';
			if($kit_cabina=='%')
				echo '<th>Kit_cabina';
			else
				echo '<th style="color:#4C91CB">Kit_cabina';
				costruisciSelect($conn,"kit_cabina",$kit_cabina);
			echo '</th>';
			if($finitura_A=='%')
				echo '<th>Finitura_A';
			else
				echo '<th style="color:#4C91CB">Finitura_A';
				costruisciSelect($conn,"finitura_A",$finitura_A);
			echo '</th>';
			if($finitura_B=='%')
				echo '<th>Finitura_B';
			else
				echo '<th style="color:#4C91CB">Finitura_B';
				costruisciSelect($conn,"finitura_B",$finitura_B);
			echo '</th>';
			if($finitura_C=='%')
				echo '<th>Finitura_C';
			else
				echo '<th style="color:#4C91CB">Finitura_C';
				costruisciSelect($conn,"finitura_C",$finitura_C);
			echo '</th>';
			if($settimana=='%')
				echo '<th>Settimana';
			else
				echo '<th style="color:#4C91CB">Settimana';
				costruisciSelect($conn,"settimana",$settimana);
			echo '</th>';
			if($numero_cabina=='%')
				echo '<th>Numero_cabina';
			else
				echo '<th style="color:#4C91CB">Numero_cabina';
				costruisciSelect($conn,"numero_cabina",$numero_cabina);
			echo '</th>';
			if($lotto=='%')
				echo '<th>Lotto';
			else
				echo '<th style="color:#4C91CB">Lotto';
				costruisciSelect($conn,"lotto",$lotto);
			echo '</th>';
			echo '<th><input type="button" id="cancellaFiltri" class="cancellaFiltri" value="Reset" onclick="resetFiltri()" /></th>';	
		echo '</tr>';
			
		$queryRighe="SELECT $filtro [id_gn],[ponte] ,[firezone],[tipo],[verso],[lato_nave],[kit_cabina],[finitura_A],[finitura_B],[finitura_C],[settimana],[numero_cabina],[lotto],[revisione], commesse.commessa AS commessa , commesse.id_commessa FROM general_numbering_revisioni, commesse WHERE general_numbering_revisioni.commessa=commesse.id_commessa 
						AND (dbo.commesse.commessa LIKE '$commessa' OR
                         dbo.commesse.commessa IS NULL) AND (dbo.general_numbering_revisioni.ponte LIKE '$ponte' OR
                         dbo.general_numbering_revisioni.ponte IS NULL) AND (dbo.general_numbering_revisioni.firezone LIKE '$firezone' OR
                         dbo.general_numbering_revisioni.firezone IS NULL) AND (dbo.general_numbering_revisioni.tipo LIKE '$tipo' OR
                         dbo.general_numbering_revisioni.tipo IS NULL) AND (dbo.general_numbering_revisioni.verso LIKE '$verso' OR
                         dbo.general_numbering_revisioni.verso IS NULL) AND (dbo.general_numbering_revisioni.lato_nave LIKE '$lato_nave' OR
                         dbo.general_numbering_revisioni.lato_nave IS NULL) AND (dbo.general_numbering_revisioni.kit_cabina LIKE '$kit_cabina' OR
                         dbo.general_numbering_revisioni.kit_cabina IS NULL) AND (dbo.general_numbering_revisioni.finitura_A LIKE '$finitura_A' OR
                         dbo.general_numbering_revisioni.finitura_A IS NULL) AND (dbo.general_numbering_revisioni.finitura_B LIKE '$finitura_B' OR
                         dbo.general_numbering_revisioni.finitura_B IS NULL) AND (dbo.general_numbering_revisioni.finitura_C LIKE '$finitura_C' OR
                         dbo.general_numbering_revisioni.finitura_C IS NULL) AND (dbo.general_numbering_revisioni.settimana LIKE '$settimana' OR
                         dbo.general_numbering_revisioni.settimana IS NULL) AND (dbo.general_numbering_revisioni.numero_cabina LIKE '$numero_cabina' OR
                         dbo.general_numbering_revisioni.numero_cabina IS NULL) AND (dbo.general_numbering_revisioni.lotto LIKE '$lotto' OR
                         dbo.general_numbering_revisioni.lotto IS NULL)
						ORDER BY id_gn DESC";
						//echo $queryRighe;
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
			while($rowRighe=sqlsrv_fetch_array($resultRighe))
			{
				echo '<tr class="myTableRowNormal">';
					echo '<td>';
						echo "<select name='commessaS' class='commessaS' id='commessaSelect".$rowNum."' onchange='modificaCommessa(".$rowNum.",this.value,".$rowRighe['id_gn'].")'>";
						echo "<option value='".$rowRighe['id_commessa']."'>".$rowRighe['commessa']."</option>";
						$queryCommessa="SELECT * FROM commesse WHERE commessa != '".$rowRighe['commessa']."'";
						$resultCommessa=sqlsrv_query($conn,$queryCommessa);
						if($resultCommessa==FALSE)
						{
							$queryCommessa=str_replace("'","*APICE*",$queryCommessa);
							$testoErrore=print_r(sqlsrv_errors(),TRUE);
							$testoErrore=str_replace("'","*APICE*",$testoErrore);
							$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
							$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$queryCommessa','".$testoErrore."','".$_SESSION['Username']."')";
							$resultErrori=sqlsrv_query($conn,$queryErrori);
							$queryCommessa=str_replace("*APICE*","'",$queryCommessa);
							echo "<br><br>Errore esecuzione query<br>Query: ".$queryCommessa."<br>Errore: ";
							die(print_r(sqlsrv_errors(),TRUE));
						}
						else
						{
							while($rowCommessa=sqlsrv_fetch_array($resultCommessa))
							{
								echo "<option value='".$rowCommessa['id_commessa']."'>".$rowCommessa['commessa']."</option>";
							}
						}
						echo "</select>";
					echo '</td>';
					echo "<td onfocusout='modifica(".$rowNum.",1,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['ponte']."</td>";
					echo "<td onfocusout='modifica(".$rowNum.",2,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['firezone']."</td>";
					echo "<td onfocusout='modifica(".$rowNum.",3,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['tipo']."</td>";
					echo "<td onfocusout='modifica(".$rowNum.",4,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['verso']."</td>";
					echo "<td onfocusout='modifica(".$rowNum.",5,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['lato_nave']."</td>";
					if($rowRighe['kit_cabina']==null || $rowRighe['kit_cabina']=='' || $rowRighe['kit_cabina']==' ' || $rowRighe['kit_cabina']=='NULL')
						echo "<td onfocusout='modifica(".$rowNum.",6,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['kit_cabina']."</td>";
					else
						echo "<td onfocusout='modifica(".$rowNum.",6,".$rowRighe['id_gn'].")' data-tooltip='Revisione: ".$rowRighe['revisione']."' contenteditable>".$rowRighe['kit_cabina']."</td>";
					echo "<td onfocusout='modifica(".$rowNum.",7,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['finitura_A']."</td>";
					echo "<td onfocusout='modifica(".$rowNum.",8,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['finitura_B']."</td>";
					echo "<td onfocusout='modifica(".$rowNum.",9,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['finitura_C']."</td>";
					echo "<td onfocusout='modifica(".$rowNum.",10,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['settimana']."</td>";
					echo "<td onfocusout='modifica(".$rowNum.",11,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['numero_cabina']."</td>";
					echo "<td onfocusout='modifica(".$rowNum.",12,".$rowRighe['id_gn'].")' contenteditable>".$rowRighe['lotto']."</td>";
					echo '<td style="text-align: center;"><button id="btnCancella" value=" " onclick="cancella('.$rowRighe['id_gn'].')"></td>';
				echo '</tr>';
				$rowNum++;
			}
			//nuova riga
			echo '<tr>';
				echo '<td>';
					echo "<select name='commessa' id='commessaS2'>";
					echo "<option value='' disabled selected>Commessa</option>";
					$queryCommessa2="SELECT * FROM commesse";
					$resultCommessa2=sqlsrv_query($conn,$queryCommessa2);
					if($resultCommessa2==FALSE)
					{
						$queryCommessa2=str_replace("'","*APICE*",$queryCommessa2);
						$testoErrore=print_r(sqlsrv_errors(),TRUE);
						$testoErrore=str_replace("'","*APICE*",$testoErrore);
						$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
						$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$queryCommessa2','".$testoErrore."','".$_SESSION['Username']."')";
						$resultErrori=sqlsrv_query($conn,$queryErrori);
						$queryCommessa2=str_replace("*APICE*","'",$queryCommessa2);
						echo "<br><br>Errore esecuzione query<br>Query: ".$queryCommessa2."<br>Errore: ";
						die(print_r(sqlsrv_errors(),TRUE));
					}
					else
					{
						while($rowCommessa2=sqlsrv_fetch_array($resultCommessa2))
						{
							echo "<option value='".$rowCommessa2['id_commessa']."'>".$rowCommessa2['commessa']."</option>";
						}
					}
					echo "</select>";
				echo '</td>';
				echo '<td contenteditable></td>';
				echo '<td contenteditable></td>';
				echo '<td contenteditable></td>';
				echo '<td contenteditable></td>';
				echo '<td contenteditable></td>';
				echo '<td contenteditable></td>';
				echo '<td contenteditable></td>';
				echo '<td contenteditable></td>';
				echo '<td contenteditable></td>';
				echo '<td contenteditable></td>';
				echo '<td contenteditable></td>';
				echo '<td contenteditable></td>';
				echo '<td style="text-align: center;"><button id="btnInserisci" value=" " onclick="inserisci('.$rowNum.')"></td>';
			echo '</tr>';
			//echo "<tr><td>$queryRighe</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
			echo "<tr style='display:none;color:white;border:1px solid white'><td>Tabella caricata</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
		}
	}
	else
		echo "<b style='color:red'>Errore di sistema</b>. Contattare l' amministratore";
		
		function costruisciSelectFK($conn,$colonna,$valore)
		{
			echo "<select id='filtro$colonna' class='selectFiltro' onchange='showTableNF()'>";
				if($valore!='%')
					echo "<option value='$valore'>$valore</option>";
				echo "<option value='%'>Tutti</option>";
				if($valore!='%')
					$querycolonna="SELECT DISTINCT commesse.[$colonna] FROM commesse,general_numbering_revisioni WHERE general_numbering_revisioni.[$colonna] = commesse.[id_$colonna] AND commesse.[$colonna]<>'$valore' ORDER BY [$colonna]";
				else
					$querycolonna="SELECT DISTINCT commesse.[$colonna] FROM commesse,general_numbering_revisioni WHERE general_numbering_revisioni.[$colonna] = commesse.[id_$colonna] ORDER BY [$colonna] ";
				$resultcolonna=sqlsrv_query($conn,$querycolonna);
				if($resultcolonna==FALSE)
				{
					$querycolonna=str_replace("'","*APICE*",$querycolonna);
					$testoErrore=print_r(sqlsrv_errors(),TRUE);
					$testoErrore=str_replace("'","*APICE*",$testoErrore);
					$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
					$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$querycolonna','".$testoErrore."','".$_SESSION['Username']."')";
					$resultErrori=sqlsrv_query($conn,$queryErrori);
					$querycolonna=str_replace("*APICE*","'",$querycolonna);
					echo "<br><br>Errore esecuzione query<br>Query: ".$querycolonna."<br>Errore: ";
					die(print_r(sqlsrv_errors(),TRUE));
				}
				else
				{
					while($rowcolonna=sqlsrv_fetch_array($resultcolonna))
					{
						echo "<option value='".$rowcolonna[$colonna]."'>".$rowcolonna[$colonna]."</option>";
					}
				}
			echo "</select>";
		}
		
		function costruisciSelect($conn,$colonna,$valore)
		{
			$orderBy="";
			if($colonna=="lotto" || $colonna=="ponte" || $colonna=="firezone")
				$orderBy="LEN([$colonna]),";
			if($valore!='%')
			{
				echo "<select id='filtro$colonna' class='selectFiltro' style='background:#4C91CB;color: white;border:1px solid white' onchange='showTableNF()'>";
				if($valore=='')
					echo "<option value='$valore'>NULL</option>";
				else
					echo "<option value='$valore'>$valore</option>";
			}
			else
				echo "<select id='filtro$colonna' class='selectFiltro' onchange='showTableNF()'>";
			echo "<option value='%'>Tutti</option>";
			if($valore!='%')
				$querycolonna="SELECT DISTINCT $orderBy [$colonna] FROM general_numbering_revisioni WHERE [$colonna] <> '$valore' ORDER BY $orderBy [$colonna] ";
			else
				$querycolonna="SELECT DISTINCT $orderBy [$colonna] FROM general_numbering_revisioni ORDER BY $orderBy [$colonna] ";
			$resultcolonna=sqlsrv_query($conn,$querycolonna);
			if($resultcolonna==FALSE)
			{
				$querycolonna=str_replace("'","*APICE*",$querycolonna);
				$testoErrore=print_r(sqlsrv_errors(),TRUE);
				$testoErrore=str_replace("'","*APICE*",$testoErrore);
				$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
				$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$querycolonna','".$testoErrore."','".$_SESSION['Username']."')";
				$resultErrori=sqlsrv_query($conn,$queryErrori);
				$querycolonna=str_replace("*APICE*","'",$querycolonna);
				echo "<br><br>Errore esecuzione query<br>Query: ".$querycolonna."<br>Errore: ";
				die(print_r(sqlsrv_errors(),TRUE));
			}
			else
			{
				while($rowcolonna=sqlsrv_fetch_array($resultcolonna))
				{
					if($rowcolonna[$colonna]==NULL || $rowcolonna[$colonna]=='')
						echo "<option value='".$rowcolonna[$colonna]."'>NULL</option>";
					else
						echo "<option value='".$rowcolonna[$colonna]."'>".$rowcolonna[$colonna]."</option>";
				}
			}
			echo "</select>";
		}
?>