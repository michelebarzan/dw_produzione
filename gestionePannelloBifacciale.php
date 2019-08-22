<?php
	include "Session.php";
	include "connessione.php";
	
	$pageName="Gestione pannello bifacciale";
	$appName="Produzione";
?>
<html>
	<head>
		<title><?php echo $appName."&nbsp&#8594&nbsp".$pageName; ?></title>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
		<link rel="stylesheet" href="css/styleV12.css" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" href="fontawesomepro/css/fontawesomepro.css" />
		<script src="spinner.js"></script>
		<link rel="stylesheet" href="css/spinner.css" />
		<script src="struttura.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/infragistics.core.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/infragistics.lob.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.ext_core.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.ext_collections.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.ext_text.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.ext_io.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.ext_ui.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.documents.core_core.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.ext_collectionsextended.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.excel_core.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.ext_threading.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.ext_web.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.xml.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.documents.core_openxml.js"></script>
		<script src="http://cdn-na.infragistics.com/igniteui/latest/js/modules/infragistics.excel_serialization_openxml.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
		<link rel="stylesheet" href="editableTable/editableTable.css" />
		<script src="editableTable/editableTable.js"></script>
		<script>
		var data = [];
		var columns = [];
		
		$(function () {
            $("#inputScegliFilePannelloBifacciale").on("change", function () {
				document.getElementById("btnImportaPannelloBifacciale").disabled = false;
                var excelFile,
                    fileReader = new FileReader();

                //$("#resultImportazionePannelloBifacciale").hide();

                fileReader.onload = function (e) {
                    var buffer = new Uint8Array(fileReader.result);

                    $.ig.excel.Workbook.load(buffer, function (workbook) {
                        var column, row, newRow, cellValue, columnIndex, i,
                            worksheet = workbook.worksheets(0),
                            columnsNumber = 0,
							gridColumns = [],
                            worksheetRowsCount;
						
						data = [];
						columns = [];

                        // Both the columns and rows in the worksheet are lazily created and because of this most of the time worksheet.columns().count() will return 0
                        // So to get the number of columns we read the values in the first row and count. When value is null we stop counting columns:
                        while (worksheet.rows(0).getCellValue(columnsNumber)) {
                            columnsNumber++;
                        }

                        // Iterating through cells in first row and use the cell text as key and header text for the grid columns
                        for (columnIndex = 0; columnIndex < columnsNumber; columnIndex++) {
                            column = worksheet.rows(0).getCellText(columnIndex);
                            gridColumns.push({ headerText: column, key: column });
                        }

                        // We start iterating from 1, because we already read the first row to build the gridColumns array above
                        // We use each cell value and add it to json array, which will be used as dataSource for the grid
                        for (i = 1, worksheetRowsCount = worksheet.rows().count() ; i < worksheetRowsCount; i++) {
                            newRow = {};
                            row = worksheet.rows(i);

                            for (columnIndex = 0; columnIndex < columnsNumber; columnIndex++) {
                                cellValue = row.getCellText(columnIndex);
                                newRow[gridColumns[columnIndex].key] = cellValue;
                            }

                            data.push(newRow);
                        }
						function arrayRemove(arr, value) 
						{
						   return arr.filter(function(ele)
						   {
							   return ele != value;
						   });
						}
						data.forEach(function(value) 
						{
							var numero_pannello=value["N° pann."];
							if(numero_pannello=="" || numero_pannello==null)
								data=arrayRemove(data, value);
						});

						gridColumns.forEach(function(gridColumn) 
						{
							columns.push(gridColumn["key"]);
						});
						//console.log(data);

                        // we can also skip passing the gridColumns use autoGenerateColumns = true, or modify the gridColumns array
                        createGrid(data, gridColumns);
                    }, function (error) {
						Swal.fire({
							  type: 'error',
							  title: 'Errore',
							  text: 'File illeggibile'
							})
						document.getElementById("btnImportaPannelloBifacciale").disabled = true;
                        /*$("#resultImportazionePannelloBifacciale").text("The excel file is corrupted.");
                        $("#resultImportazionePannelloBifacciale").show(1000);*/
                    });
                }

                if (this.files.length > 0) {
                    excelFile = this.files[0];
					var nomeFile=excelFile["name"];
                    if (excelFile.type === "application/vnd.ms-excel" || excelFile.type === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || (excelFile.type === "" && (excelFile.name.endsWith("xls") || excelFile.name.endsWith("xlsx")))) {
                        fileReader.readAsArrayBuffer(excelFile);
                    } else {
						Swal.fire({
					  type: 'error',
					  title: 'Errore',
					  text: 'Formato non supportato'
					})
						document.getElementById("btnImportaPannelloBifacciale").disabled = true;
                        /*$("#resultImportazionePannelloBifacciale").text("The format of the file you have selected is not supported. Please select a valid Excel file ('.xls, *.xlsx').");
                        $("#resultImportazionePannelloBifacciale").show(1000);*/
                    }
                }
				
				if(nomeFile=="" || nomeFile==null)
				{
					Swal.fire({
					  type: 'error',
					  title: 'Errore',
					  text: 'Impossibile recuperare il nome del file'
					})
					document.getElementById("btnImportaPannelloBifacciale").disabled = true;
				}
				else
				{
					document.getElementById("nomeFileLabelPannelloBifacciale").innerHTML="Nome file:";
					document.getElementById("nomeFilePannelloBifacciale").innerHTML=nomeFile;
					
					var commessa;
					var nomeCabina;
					var revisioneCabina;
					var descrizione;
					
					document.getElementById("infoPannelloBifacciale").style.display="inline-block";
					commessa=nomeFile.substring(1, 5);
					nomeCabina=nomeFile.substring(0, 10);
					revisioneCabina=nomeFile.substring(15, 16);
					descrizione=nomeFile.substring(17, nomeFile.length);
					descrizione = descrizione.replace(".xlsx", "");
					descrizione = descrizione.replace(".xls", "");
					
					document.getElementById("commessaInputContainerPannelloBifacciale").innerHTML="Commessa:";
					document.getElementById("nomeCabinaInputContainerPannelloBifacciale").innerHTML="Cabina:";
					document.getElementById("revisioneCabinaInputContainerPannelloBifacciale").innerHTML="Revisione:";
					document.getElementById("descrizioneInputContainerPannelloBifacciale").innerHTML="Descrizione:";
					
					document.getElementById("commessaPannelloBifacciale").value=commessa;
					document.getElementById("nomeCabinaPannelloBifacciale").value=nomeCabina;
					document.getElementById("revisioneCabinaPannelloBifacciale").value=revisioneCabina;
					document.getElementById("descrizionePannelloBifacciale").value=descrizione;
				}
				
            })
        });

        function createGrid(data, gridColumns) {
            if ($("#myTableImportazionePannelloBifacciale").data("igGrid") !== undefined) {
                $("#myTableImportazionePannelloBifacciale").igGrid("destroy");
            }

            $("#myTableImportazionePannelloBifacciale").igGrid({
                columns: gridColumns,
                //autoGenerateColumns: true,
                dataSource: data//,
                //width: "100%"
            });
		}
		function inserisciDatiPannelloBifacciale()
		{
			var commessa=document.getElementById("commessaPannelloBifacciale").value;
			var nomeCabina=document.getElementById("nomeCabinaPannelloBifacciale").value;
			var revisioneCabina=document.getElementById("revisioneCabinaPannelloBifacciale").value;
			var descrizione=document.getElementById("descrizionePannelloBifacciale").value;
			//newCircleSpinner("Inserimento in corso...");
			var JSONdata=JSON.stringify(data);
			var JSONcolumns=JSON.stringify(columns);
			$.post("inserisciDatiPannelloBifacciale.php",
			{
				JSONcolumns,
				JSONdata,
				commessa,
				nomeCabina,
				revisioneCabina,
				descrizione
			},
			function(response, status)
			{
				if(status=="success")
				{
					console.log(response);
					try
					{
						var articoliMancanti=[];
						var articoliMancantiObj = JSON.parse(response);
						for (var key in articoliMancantiObj)
						{
							articoliMancanti.push(articoliMancantiObj[key]);							
						}
						Swal.fire
						({
							title: 'Articoli mancanti',
							text: "Gli articoli "+articoliMancanti.toString()+" sono privi di anagrafica",
							type: 'warning',
							allowOutsideClick:false,
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Inserisci anagrafica',
							cancelButtonText: 'Annulla'
						}).then((result) => 
						{
							if (result.value)
							{
								inserisciArticoli(articoliMancanti);
							}
							else
								swal.close();
						})
					}
					catch(err)
					{
						if(response.indexOf("ok")>-1)
						{
							Swal.fire
							({
								type: 'success',
								title: 'Dati registrati'
							})
							document.getElementById("btnImportaPannelloBifacciale").disabled = true;
						}
						if(response.indexOf("error")>-1)
						{
							Swal.fire({
							  type: 'error',
							  title: 'Errore',
							  text: 'Impossibile inserire i dati. Se il problema persiste contattare l ammministratore'
							})
						}
						if(response.indexOf("commessainesistente")>-1)
						{
							Swal.fire({
							  type: 'error',
							  title: 'Errore',
							  text: 'Commessa innesistente'
							})
						}
						if(response.indexOf("finiture")>-1)
						{
							Swal.fire({
							  type: 'error',
							  title: 'Errore',
							  text: "Finiture inesistenti"
							})
						}
					}
					//removeCircleSpinner();
				}
				else
					console.log(status);
			});
		}
		function inserisciArticoli(articoliMancanti)
		{
			var table=document.createElement("table");
			table.setAttribute("id","myTableInserisciAtricoli");
			var row = table.insertRow(0);
			var th=document.createElement('th');
			th.innerHTML = "Articolo";
			row.appendChild(th);
			
			var th=document.createElement('th');
			th.innerHTML = "Incremento l. x";
			row.appendChild(th);
			
			var th=document.createElement('th');
			th.innerHTML = "Incremento h. x";
			row.appendChild(th);
			
			var th=document.createElement('th');
			th.innerHTML = "Incremento l. y";
			row.appendChild(th);
			
			var th=document.createElement('th');
			th.innerHTML = "Incremento h. y";
			row.appendChild(th);
			
			var th=document.createElement('th');
			th.innerHTML = "Punzonatura x";
			row.appendChild(th);
			
			var th=document.createElement('th');
			th.innerHTML = "Punzonatura y";
			row.appendChild(th);
			
			var i=1;
			articoliMancanti.forEach(function(articolo)
			{
				var row = table.insertRow(i);
				var cell1 = row.insertCell(0);
				cell1.setAttribute("id","articolo"+articolo);
				cell1.innerHTML=articolo;
				
				var defaultValueIncrementoly=9.8;
				if(articolo.indexOf("F")>-1)
					defaultValueIncrementoly=17.6;
				/*var cell2 = row.insertCell(1);var input1=document.createElement("input");input1.setAttribute("type","number");input1.setAttribute("step","0.1");input1.setAttribute("id","spessorex"+articolo);cell2.appendChild(input1);
				var cell3 = row.insertCell(2);var input2=document.createElement("input");input2.setAttribute("type","number");input2.setAttribute("step","0.1");input2.setAttribute("id","incrementolx"+articolo);cell3.appendChild(input2);
				var cell4 = row.insertCell(3);var input3=document.createElement("input");input3.setAttribute("type","number");input3.setAttribute("step","0.1");input3.setAttribute("id","incrementohx"+articolo);cell4.appendChild(input3);
				var cell5 = row.insertCell(4);var input4=document.createElement("input");input4.setAttribute("type","number");input4.setAttribute("step","0.1");input4.setAttribute("id","spessorey"+articolo);cell5.appendChild(input4);
				var cell6 = row.insertCell(5);var input5=document.createElement("input");input5.setAttribute("type","number");input5.setAttribute("step","0.1");input5.setAttribute("id","incrementoly"+articolo);cell6.appendChild(input5);
				var cell7 = row.insertCell(6);var input6=document.createElement("input");input6.setAttribute("type","number");input6.setAttribute("step","0.1");input6.setAttribute("id","incrementohy"+articolo);cell7.appendChild(input6);*/
				var cell3 = row.insertCell(1);var input2=document.createElement("input");input2.setAttribute("type","number");input2.setAttribute("lang","en");input2.setAttribute("value","11");input2.setAttribute("step","0.1");input2.setAttribute("id","incrementolx"+articolo);cell3.appendChild(input2);
				var cell4 = row.insertCell(2);var input3=document.createElement("input");input3.setAttribute("type","number");input3.setAttribute("lang","en");input3.setAttribute("value","0");input3.setAttribute("step","0.1");input3.setAttribute("id","incrementohx"+articolo);cell4.appendChild(input3);
				var cell6 = row.insertCell(3);var input5=document.createElement("input");input5.setAttribute("type","number");input5.setAttribute("lang","en");input5.setAttribute("value",defaultValueIncrementoly);input5.setAttribute("step","0.1");input5.setAttribute("id","incrementoly"+articolo);cell6.appendChild(input5);
				var cell7 = row.insertCell(4);var input6=document.createElement("input");input6.setAttribute("type","number");input6.setAttribute("lang","en");input6.setAttribute("value","0");input6.setAttribute("step","0.1");input6.setAttribute("id","incrementohy"+articolo);cell7.appendChild(input6);
				var cell8 = row.insertCell(5);var input7=document.createElement("input");input7.setAttribute("type","checkbox");input7.setAttribute("id","punzonaturax"+articolo);cell8.appendChild(input7);
				var cell9 = row.insertCell(6);var input8=document.createElement("input");input8.setAttribute("type","checkbox");input8.setAttribute("id","punzonaturay"+articolo);cell9.appendChild(input8);
				i++;
			});
			Swal.fire
			({
				width:"800px",
				title: 'Anagrafica articoli',
				allowOutsideClick:false,
				html: table.outerHTML,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Conferma',
				cancelButtonText: 'Annulla'
			}).then((result) => 
			{
				if (result.value)
				{
					//var query="INSERT INTO [dbo].[produzione_bf_delta_articoli] ([articolo] ,[spessore_x],[incremento_l_x],[incremento_h_x],[spessore_y],[incremento_l_y],[incremento_h_y],[utente],[data_importazione]) VALUES";
					var query="INSERT INTO [dbo].[produzione_bf_delta_articoli] ([articolo] ,[incremento_l_x],[incremento_h_x],[incremento_l_y],[incremento_h_y],[punzonatura_x],[punzonatura_y],[utente],[data_importazione]) VALUES";
					var table = document.getElementById("myTableInserisciAtricoli");
					var errore=false;
					for (var i = 1, row; row = table.rows[i]; i++)
					{
						for (var j = 1, col; col = row.cells[j]; j++)
						{
							if(col.childNodes[0].value=='' || col.childNodes[0].value==null)
								errore=true;
						}  
					}
					if(errore)
					{
						Swal.fire
						({
							type: 'error',
							title: 'Errore',
							text: 'Compila tutti i campi'
						})
					}
					else
					{
						var id_utente=document.getElementById("id_utente").value;
						articoliMancanti.forEach(function(articolo)
						{
							//query+=" ('"+articolo+"',"+document.getElementById("spessorex"+articolo).value+","+document.getElementById("incrementolx"+articolo).value+","+document.getElementById("incrementohx"+articolo).value+","+document.getElementById("spessorey"+articolo).value+","+document.getElementById("incrementoly"+articolo).value+","+document.getElementById("incrementohy"+articolo).value+","+id_utente+",GETDATE()),";
							query+=" ('"+articolo+"',"+document.getElementById("incrementolx"+articolo).value+","+document.getElementById("incrementohx"+articolo).value+","+document.getElementById("incrementoly"+articolo).value+","+document.getElementById("incrementohy"+articolo).value+",'"+document.getElementById("punzonaturax"+articolo).checked+"','"+document.getElementById("punzonaturay"+articolo).checked+"',"+id_utente+",GETDATE()),";
						});
						query = query.slice(0, -1);
						$.post("inserisciArticoliPannelloBifacciale.php",
						{
							query
						},
						function(response, status)
						{
							if(status=="success")
							{
								if(response.indexOf("ok")>-1)
								{
									Swal.fire
									({
										type: 'success',
										title: 'Anagrafiche articoli inserite',
										allowOutsideClick:false,
										text:"Proseguire con il caricamento dei pannelli?",
										showCancelButton: true,
										confirmButtonColor: '#3085d6',
										cancelButtonColor: '#d33',
										confirmButtonText: 'Conferma',
										cancelButtonText: 'Annulla'
									}).then((result) => 
									{
										if (result.value)
										{
											inserisciDatiPannelloBifacciale();
										}
										else
											swal.close();
									})
								}
								else
								{
									console.log(response);
									Swal.fire
									({
										type: 'error',
										title: 'Errore',
										text: 'Impossibile inserire i dati. Se il problema persiste contattare l ammministratore'
									})
								}
								
							}
							else
								console.log(status);
						});
					}
					
				}
				else
					swal.close();
			})
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
	<body>
		<?php include('struttura.php'); ?>
		<input type="hidden" id="id_utente" value="<?php echo getIdUtente($conn,$_SESSION['Username']); ?>">
		<div id="immagineLogo" class="immagineLogo" style="width:1300px;margin-top:70px;"></div>
		<div class="absoluteActionBar2">
			<button id="btnScegliFilePannelloBifacciale" onclick="document.getElementById('inputScegliFilePannelloBifacciale').click()">Scegli Excel<i class="fal fa-file-excel" style="margin-left:15px"></i></button>
			<button id="btnImportaPannelloBifacciale" disabled="true" onclick="inserisciDatiPannelloBifacciale()">Conferma caricamento<i class="fal fa-upload" style="margin-left:15px"></i></button>
			<input type="file"  id="inputScegliFilePannelloBifacciale" style="display:none" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"></input>
			<div id="nomeFileLabelPannelloBifacciale"></div>
			<div id="nomeFilePannelloBifacciale"></div>
		</div>
		<div class="absoluteContainer2" style="margin-top:90px">
			<ul id="infoPannelloBifacciale">
				<li><div class="inputContainerPannelloBifacciale" id="commessaInputContainerPannelloBifacciale"></div><input type="text" id="commessaPannelloBifacciale" /></li>
				<li><div class="inputContainerPannelloBifacciale" id="nomeCabinaInputContainerPannelloBifacciale"></div><input type="text" id="nomeCabinaPannelloBifacciale" /></li>
				<li><div class="inputContainerPannelloBifacciale" id="revisioneCabinaInputContainerPannelloBifacciale"></div><input type="text" id="revisioneCabinaPannelloBifacciale" /></li>
				<li><div class="inputContainerPannelloBifacciale" id="descrizioneInputContainerPannelloBifacciale"></div><input type="text" id="descrizionePannelloBifacciale" /></li>
			</ul>
		</div>
		<div class="absoluteContainer2" style="margin-top:200px">
			<!--<div id="resultImportazionePannelloBifacciale"></div>-->
			<table id="myTableImportazionePannelloBifacciale"></table>
		</div>
		<div id="footer">
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>

























