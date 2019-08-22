<?php

	include "session.php";

	exec('del "C:\\xampp\\htdocs\\dw_produzione\\files\\esportazioneGN\\esportazioneGN'.session_id().'.xlsm"');
	exec('del "C:\\xampp\\htdocs\\dw_produzione\\files\\esportazioneGN\\esportazioneGN'.session_id().'.xlsx"');
	
?>