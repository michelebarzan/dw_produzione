<?php
	session_start();
	$_SESSION=array();
	session_destroy();
	$hour = time() + 3600 * 24 * 30;
	setcookie('username',"no", $hour);
	setcookie('password', "no", $hour);
	//$server=  $_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'];
	$externalContent = file_get_contents('http://checkip.dyndns.com/');
	preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
	$server = $m[1];
	echo '<script>location.href="http://'.$server.'/dw_login/login.php";</script>';
?>