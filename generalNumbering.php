<?php
	include "Session.php";
	include "connessione.php";
	
	$pageName="General Numbering";
	$appName="Produzione";
?>
<html>
	<head>
		<title><?php echo $appName."&nbsp&#8594&nbsp".$pageName; ?></title>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
		<link rel="stylesheet" href="css/styleV12.css" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link rel="stylesheet" href="fontawesomepro/css/fontawesomepro.css" />
		<link rel="stylesheet" href="editableTable/editableTable.css" />
		<script src="editableTable/editableTable.js"></script>
		<script src="spinner.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
		<link rel="stylesheet" href="css/spinner.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="jquery.table2excel.js"></script>
		<script src="struttura.js"></script>
		<script>
			function editableTableLoad()
			{
			
			}
			/*function showTableNF() 
			{
				document.getElementById("risultato").innerHTML = "Risultato:&nbsp";
				document.getElementById("btnV").style.display = "inline-block";
				document.getElementById("myTable").style.color = "#E6E6E6";
				
				var nRighe=document.getElementById("nRighe").value;
				
				if(document.getElementById("myTable").rows.length>2)
				{
					var commessa=document.getElementById("filtrocommessa").value;
					var ponte=document.getElementById("filtroponte").value;
					var firezone=document.getElementById("filtrofirezone").value;
					var tipo=document.getElementById("filtrotipo").value;
					var verso=document.getElementById("filtroverso").value;
					var lato_nave=document.getElementById("filtrolato_nave").value;
					var kit_cabina=document.getElementById("filtrokit_cabina").value;
					var finitura_A=document.getElementById("filtrofinitura_A").value;
					var finitura_B=document.getElementById("filtrofinitura_B").value;
					var finitura_C=document.getElementById("filtrofinitura_C").value;
					var settimana=document.getElementById("filtrosettimana").value;
					var numero_cabina=document.getElementById("filtronumero_cabina").value;
					var lotto=document.getElementById("filtrolotto").value;
				}
				else
				{
					var commessa="%";
					var ponte="%";
					var firezone="%";
					var tipo="%";
					var verso="%";
					var lato_nave="%";
					var kit_cabina="%";
					var finitura_A="%";
					var finitura_B="%";
					var finitura_C="%";
					var settimana="%";
					var numero_cabina="%";
					var lotto="%";
				}
					
					var valori = [];
					
					valori.push("&commessa="+commessa);
					valori.push("&ponte="+ponte);
					valori.push("&firezone="+firezone);
					valori.push("&tipo="+tipo);
					valori.push("&verso="+verso);
					valori.push("&lato_nave="+lato_nave);
					valori.push("&kit_cabina="+kit_cabina);
					valori.push("&finitura_A="+finitura_A);
					valori.push("&finitura_B="+finitura_B);
					valori.push("&finitura_C="+finitura_C);
					valori.push("&settimana="+settimana);
					valori.push("&numero_cabina="+numero_cabina);
					valori.push("&lotto="+lotto);
					valori.push("&nRighe="+nRighe);
					
					var str=valori.toString();
					var count = (str.match(/%/gi) || []).length;
					
					if(count==13)
					{
						document.getElementById("nRighe").disabled = false;
						document.getElementById("nRighe").style.border = "1px solid gray";
					}
					else
					{
						document.getElementById("nRighe").disabled = true;
						document.getElementById("nRighe").style.border = "1px solid red";
					}
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						//console.log(this.responseText);
						if(this.responseText.indexOf("Tabella caricata")>0)
						{
							try
							{
								document.getElementById("btnV").style.display = "none";
								document.getElementById("myTable").style.color = "black";
								setTimeout(function()
								{ 
									checkNRighe();
								}, 200);
							}
							catch(err)
							{
								window.alert(err);
							}
						}
						
						document.getElementById("myTable").innerHTML  =  this.responseText;
					}
				};
				xmlhttp.open("POST", "tabellaNF.php?nRighe=" + nRighe + valori.join(""), true);
				xmlhttp.send();
			}
			function modificaCommessa(riga,valore,id)
			{
				var riga=riga;
				var valore=valore;
				var id=id;
				var nomeColonna ="Commessa";
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("risultato").innerHTML = "Risultato:&nbsp" +  this.responseText;
					}
				};
				xmlhttp.open("POST", "aggiornaGN.php?nomeColonna=" + nomeColonna + "&valore=" + valore + "&id=" + id, true);
				xmlhttp.send();
			}
			function modifica(riga,colonna,id)
			{
				var riga=riga;
				var colonna=colonna;
				var id=id;
				
				var nomeColonna = document.getElementById("myTable").rows[0].cells[colonna].innerHTML;
				vNomeColonna=nomeColonna.split('<');
				nomeColonna=vNomeColonna[0];
				var valore = document.getElementById("myTable").rows[riga].cells[colonna].innerHTML;
				
				var i;
				var count;
				
				i=0;
				count = (valore.match(/<div>/g) || []).length;
				for(i=0;i<count;i++)
				{
					valore = valore.replace('<div>', '');
					valore = valore.replace('</div>', '');
				}
				i=0;
				count = (valore.match(/<br>/g) || []).length;
				for(i=0;i<count;i++)
				{
					valore = valore.replace('<br>', ' ');
				}
				i=0;
				count = (valore.match(/nbps/g) || []).length;
				for(i=0;i<count;i++)
				{
					valore = valore.replace('&nbps;', ' ');
				}
				
				if(valore!='')
				{
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							document.getElementById("risultato").innerHTML = "Risultato:&nbsp" +  this.responseText;
						}
					};
					xmlhttp.open("POST", "aggiornaGN.php?nomeColonna=" + nomeColonna + "&valore=" + valore + "&id=" + id, true);
					xmlhttp.send();
				}
				if(valore=='')
				{
					if(nomeColonna=="Kit_cabina" || nomeColonna=="Finitura_A" || nomeColonna=="Finitura_B" || nomeColonna=="Finitura_C" || nomeColonna=="Settimana" || nomeColonna=="Lotto")
					{
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function() 
						{
							if (this.readyState == 4 && this.status == 200) 
							{
								document.getElementById("risultato").innerHTML = "Risultato:&nbsp" +  this.responseText;
							}
						};
						xmlhttp.open("POST", "aggiornaGN.php?nomeColonna=" + nomeColonna + "&valore=" + valore + "&id=" + id, true);
						xmlhttp.send();
					}
				}
				
			}
			function cancella(id)
			{
				var id=id;
				//window.alert(id);
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("risultato").innerHTML = "Risultato:&nbsp" +  this.responseText;
					}
				};
				xmlhttp.open("POST", "cancellaGN.php?id=" + id, true);
				xmlhttp.send();
				setTimeout(function()
				{ 
					showTableNF();
				}, 500);
				
			}
			function inserisci(riga)
			{
				var riga=riga;
				//window.alert(riga);
				var length=(document.getElementById('myTable').rows[riga].cells.length)-1;
				var valori = [];
				
				if(document.getElementById("commessaS2").value!="")
				{
					valori.push("?commessa="+document.getElementById("commessaS2").value);
					
					var nomeColonna;
					var errore=0;
					
					for (i = 1; i < length; i++) 
					{
						nomeColonna=document.getElementById("myTable").rows[0].cells[i].innerHTML;
						var vNomeColonna=nomeColonna.split('<');
						nomeColonna=vNomeColonna[0];
						if(nomeColonna=="Ponte" || nomeColonna=="Firezone" || nomeColonna=="Tipo" || nomeColonna=="Verso" || nomeColonna=="Lato_nave" || nomeColonna=="Numero_cabina")
						{
							if(document.getElementById("myTable").rows[riga].cells[i].innerHTML=='' || document.getElementById("myTable").rows[riga].cells[i].innerHTML==' ' || document.getElementById("myTable").rows[riga].cells[i].innerHTML==null)
							{
								document.getElementById("risultato").innerHTML = "Risultato:&nbsp<b style='color:red'>compila i campi obbligatori.</b>";
								document.getElementById("myTable").rows[riga].cells[i].style.borderBottom="2px solid red";
								errore=1;
								break;
							}
						}
						valori.push("&"+nomeColonna + "='" + document.getElementById("myTable").rows[riga].cells[i].innerHTML+"'");
					}
					if(errore==0)
					{
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function() 
						{
							if (this.readyState == 4 && this.status == 200) 
							{
								document.getElementById("risultato").innerHTML = "Risultato:&nbsp" +  this.responseText;
							}
						};
						xmlhttp.open("POST", "inserisciGN.php?" + valori.join(""), true);
						xmlhttp.send();
					
						setTimeout(function()
						{ 
							showTableNF();
						}, 500);
					}
				}
				else
				{
					document.getElementById("risultato").innerHTML = "Risultato:&nbsp<b style='color:red'>Devi selezionare una commessa</b>";
					document.getElementById("commessaS2").style.color="white";
					document.getElementById("commessaS2").style.borderColor="red";
					document.getElementById("commessaS2").style.background="red";
				}
			}
			function resetFiltri()
			{
				document.getElementById("filtrocommessa").value="%";
				document.getElementById("filtroponte").value="%";
				document.getElementById("filtrofirezone").value="%";
				document.getElementById("filtrotipo").value="%";
				document.getElementById("filtroverso").value="%";
				document.getElementById("filtrolato_nave").value="%";
				document.getElementById("filtrokit_cabina").value="%";
				document.getElementById("filtrofinitura_A").value="%";
				document.getElementById("filtrofinitura_B").value="%";
				document.getElementById("filtrofinitura_C").value="%";
				document.getElementById("filtrosettimana").value="%";
				document.getElementById("filtronumero_cabina").value="%";
				document.getElementById("filtrolotto").value="%";
				
				document.getElementById("nRighe").value="50";
				
				showTableNF();
			}
			function checkNRighe()
			{
				var colore = document.getElementById("nRighe").style.borderColor;
				if(colore=="red")
				{
					document.getElementById("nRighe").value="*";
				}
				var x = document.getElementById("myTable").rows.length;
				document.getElementById("righeTabella").innerHTML="Totale:&nbsp"+"<b style='color: #3367d6'>"+(x-3)+"&nbsprighe</b>";
			}
			function assegna()
			{
				var lotto = document.getElementById("lottoIns").value;
				if(lotto=='')
				{
					document.getElementById("lottoIns").style.borderColor="red";
				}
				else
				{
					document.getElementById("btnV").style.display = "inline-block";
					document.getElementById("myTable").style.color = "#E6E6E6";
					
					var l = (document.getElementById("myTable").rows.length)-2;
					
					if(l>200)
					{
						var r = confirm("L' aggiornamento di "+(l-1)+" righe potrebbe richiedere molto tempo e bloccare l' accesso ad altri utenti. Aggiornare comunque?");
					}
					else
					{
						var r=true;
					}
					if (r == true) 
					{
						var i=1;
						var valori='';
						
						while(i<l)
						{
							if(document.getElementById("myTable").rows[i].cells[12].innerHTML=='')
							{
								var commessa=document.getElementById("commessaSelect"+i).value;
								var numero_cabina=document.getElementById("myTable").rows[i].cells[11].innerHTML;
								
								var commessaSplitNumero_cabina = commessa + "|" + numero_cabina;
								
								valori = valori + commessaSplitNumero_cabina + "£";
							}
							i++;
						}
						
						//console.log(valori);
						//console.log(lotto);
						
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function() 
						{
							if (this.readyState == 4 && this.status == 200) 
							{
								document.getElementById("btnV").style.display = "none";
								document.getElementById("myTable").style.color = "black";
								
								document.getElementById("lottoIns").value='';
								showTableNF();
								document.getElementById("risultato").innerHTML = "Risultato:&nbsp" +  this.responseText;
							}
						};
						xmlhttp.open("POST", "aggiornaLotto.php?valori=" + valori + "&lotto=" + lotto, true);
						xmlhttp.send();
					} 
					else 
					{
						document.getElementById("risultato").innerHTML = "Risultato:&nbsp" + "<b style='color:red'>Aggiornamento annullato</b>";
						document.getElementById("btnV").style.display = "none";
						document.getElementById("myTable").style.color = "black";
						
						document.getElementById("lottoIns").value='';
					}
				}
			}*/
			function getTable(table,orderBy,orderType)
			{
				getEditableTable
				({
					table:table,
					readOnlyColumns:['id_gn','commessa'],
					noInsertColumns:['id_gn'],
					primaryKey:"id_gn",
					container:'containerGestioneGeneralNumbering',
					foreignKeys:[['commessa','commesse','id_commessa','commessa']],
					orderBy:orderBy,
					orderType:orderType
				});
			}
			function assegnaLotto(lotto,tipo,acronimo)
			{
				if(lotto==null || lotto=='')
				{
					Swal.fire
					({
						type: 'error',
						title: 'Errore',
						text: 'Nessun lotto '+tipo+' selezionato'
					});
				}
				else
				{
					if(getTableRows(selectetTable)>150)
					{
						Swal.fire
						({
							type: 'error',
							title: 'Errore',
							text: 'Numero massimo di righe (150) superato'
						});
					}
					else
					{
						newCircleSpinner("Creazione lotto "+tipo+" in corso...");
						var id_gn_array=[];
						var table = document.getElementById("myTable"+selectetTable);
						for (var i = 1, row; row = table.rows[i]; i++)
						{
							if(row.style.display!="none")
								id_gn_array.push(row.cells[0].innerHTML);
						}
						var JSONid_gn_array=JSON.stringify(id_gn_array);
						$.post("assegnaLotto.php",
						{
							JSONid_gn_array,
							lotto,
							acronimo
						},
						function(response, status)
						{
							if(status=="success")
							{
								removeCircleSpinner();
								if(response.indexOf("ok")>-1)
								{
									Swal.fire
									({
										type: 'success',
										title: 'Lotto '+tipo+' creato'
									}).then((result) => 
									{
										swal.close();
										setTimeout(function(){ resetFilters();getTable(selectetTable); }, 1000);
									});
								}
								if(response.indexOf("error")>-1)
								{
									Swal.fire
									({
										type: 'error',
										title: 'Errore',
										text: 'Impossibile creare il lotto '+tipo+'. Se il problema persiste contattare l amministratore'
									});
								}
							}
							else
								console.log(status);
						});
					}
				}
			}
		</script>
		<style>
			.swal2-title
			{
				font-family:'Montserrat',sans-serif;
				font-size:18px;
			}
			.swal2-content
			{
				font-family:'Montserrat',sans-serif;
				font-size:13px;
			}
			.swal2-confirm,.swal2-cancel
			{
				font-family:'Montserrat',sans-serif;
				font-size:13px;
			}
		</style>
	</head>
	<body onload="getTable('produzione_general_numbering_view')">
		<button onclick="topFunction()" id="btnGoTop" title="Go to top"></button>
		<script>
		// When the user scrolls down 20px from the top of the document, show the button
			window.onscroll = function() {scrollFunction()};

			function scrollFunction() 
			{
				if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) 
				{
					document.getElementById("btnGoTop").style.width = "48px";
					document.getElementById("btnGoTop").style.height = "48px";
					document.getElementById("btnGoTop").style.opacity = "1";
				} 
				else 
				{
					document.getElementById("btnGoTop").style.width = "0px";
					document.getElementById("btnGoTop").style.height = "0px";
					document.getElementById("btnGoTop").style.opacity = "0";
				}
			}

			// When the user clicks on the button, scroll to the top of the document
			function topFunction() 
			{
				document.body.scrollTop = 0;
				document.documentElement.scrollTop = 0;
			}
		</script>

		<?php include('struttura.php'); ?>
		<div class="absoluteActionBarGn">
			<div class="absoluteActionBarGnElement">Righe: <span id="rowsNumEditableTable"></span></div>
			<button class="absoluteActionBarGnButton" onclick="excelExport('containerGestioneGeneralNumbering')">Esporta <i style="margin-left:5px;color:green" class="far fa-file-excel"></i></button>
			<button class="absoluteActionBarGnButton" onclick="resetFilters();getTable(selectetTable)">Ripristina <i style="margin-left:5px" class="fal fa-filter"></i></button>
			
			<button class="absoluteActionBarGnButton" onclick="assegnaLotto(document.getElementById('assegnaLottoInput').value,'monofacciale','')" style="float:right">Assegna <i style="margin-left:5px" class="fal fa-list-alt"></i></button>
			<input type="number" class="absoluteActionBarGnInput" id="assegnaLottoInput" style="padding-right:0px;float:right" />
			<div class="absoluteActionBarGnElement" style="float:right">Lotto</div>
			
			<button class="absoluteActionBarGnButton" onclick="assegnaLotto(document.getElementById('assegnaLottoInputBf').value,'bifacciale','_bf')" style="float:right;margin-right:50px">Assegna<i style="margin-left:5px" class="fal fa-list-alt"></i></button>
			<input type="number" class="absoluteActionBarGnInput" id="assegnaLottoInputBf" style="padding-right:0px;float:right" />
			<div class="absoluteActionBarGnElement" style="float:right">Lotto B.F.</div>

			<button class="absoluteActionBarGnButton" onclick="assegnaLotto(document.getElementById('assegnaLottoInputMb').value,'monobifacciale','_mb')" style="float:right;margin-right:50px">Assegna<i style="margin-left:5px" class="fal fa-list-alt"></i></button>
			<input type="number" class="absoluteActionBarGnInput" id="assegnaLottoInputMb" style="padding-right:0px;float:right" />
			<div class="absoluteActionBarGnElement" style="float:right">Lotto M.B.</div>

			<button class="absoluteActionBarGnButton" onclick="assegnaLotto(document.getElementById('assegnaLottoInputNb').value,'nuovobifacciale','_nb')" style="float:right;margin-right:50px">Assegna<i style="margin-left:5px" class="fal fa-list-alt"></i></button>
			<input type="number" class="absoluteActionBarGnInput" id="assegnaLottoInputMb" style="padding-right:0px;float:right" />
			<div class="absoluteActionBarGnElement" style="float:right">Lotto N.B.</div>
		</div>
		<div id="containerGestioneGeneralNumbering"></div>
		<!--<div id="container">
			<div id="content">
				<div id="immagineLogo" class="immagineLogo" style="margin-bottom:20px" ></div>
				<div id="risultato" class="risultato" >Risultato:&nbsp</div>
				<div id="righe" class="righe">
					Mostra 
					<select name="nRighe" id="nRighe" onchange="showTableNF()"></b> 
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">200</option>
						<option value="500">500</option>
						<option value="1000">1000</option>
						<option value="2000">2000</option>
						<option value="5000">5000</option>
						<option value="*">*</option>
					</select>
					righe
				</div>
				<button id='btnV' class='btnV' ><br><b class="fa fa-circle-o-notch fa-spin"></b></button>
				
				<div id="riga2" class="riga2">
					<div id="righeTabella" class="righeTabella">Totale:&nbsp</div>
					<div id="compilaLotto" class="compilaLotto">
						N.&nbsplotto:&nbsp
						<input type="number" name="lottoIns" id="lottoIns" >
						<input type="button" id="assegnaLotto" class="assegnaLotto" value="Assegna" onclick="assegna();" />
					</div>
				</div>
				<table id="myTable"></table>
			</div>
		</div>-->
		<div id="push"></div>
		<div id="footer">
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>

<!--------------------------------------------------------------------------------------------------------------------------------------------------------------->
