<html>
	<head>
		<title>checkMobile</title>
		<script>
			function detectmob() 
			{ 
				if( navigator.userAgent.match(/Android/i)
				|| navigator.userAgent.match(/webOS/i)
				|| navigator.userAgent.match(/iPhone/i)
				|| navigator.userAgent.match(/iPad/i)
				|| navigator.userAgent.match(/iPod/i)
				|| navigator.userAgent.match(/BlackBerry/i)
				|| navigator.userAgent.match(/Windows Phone/i)
				)
				{
					window.location = "indexM.php";
				}
				else
				{
					window.location = "index.php";
				}
			}
		</script>
	</head>
	<body onload="detectmob()">
	</body>
</html>