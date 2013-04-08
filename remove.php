<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="author" content="Max Bruckner">
  <title>Datei löschen</title>
<?php
//Variablen aus URL holen
$pfad = $_GET["pfad"];
$return = $_GET["return"]; 	//Seite für automatische Weiterleitung
if(unlink($pfad))	//Löschen der Datei und Abfragen ob Erfolgreich
{
	//Wenn Erfolgreich: Automatische Weiterleitung nach 1 Sekunde und Meldung ausgeben
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=$return\">";
	echo "</head>\n<body>";
	echo "Datei \"$pfad\" gelöscht.";
}
	else
	{
		//Wenn nicht Erfolgreich: Automatische Weiterleitung nach 3 Sekunden und Meldung ausgeben
		echo "<meta http-equiv=\"refresh\" content=\"3; URL=$return\">";
		echo "</head>\n<body>";
		echo "Es ist ein Fehler aufgetreten, \"$pfad\" konnte nicht gelöscht werden!";
	}
?>
</body>
</html>
