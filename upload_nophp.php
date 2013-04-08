<?php
if(stripos($name,'.php',strlen($name)-4) !== FALSE)	//Wenn PHP-Endung, Fehler-Ausgeben
{
		echo "<meta http-equiv=\"refresh\" content=\"3; URL=$return_failure\">";
		echo "</head>\n<body>";
		echo 'Sie dürfen keine PHP-Dateien hochladen!';
		echo "</body>\n</html>";
		exit();
}
?>
