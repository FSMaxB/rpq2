<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="author" content="Max Bruckner">
  <title>Aufnahme starten</title>
<?php
//Übertragene Daten den Variablen zuweisen
$return_success = $_POST['return_success'];
$return_failure = $_POST['return_failure'];
$baud = escapeshellcmd($_POST['baud']);
$tty = escapeshellcmd($_POST['tty']);
$befehl = $_POST['befehl'];
$ordner = escapeshellcmd($_POST['ordner']);
$datei = escapeshellcmd($_POST['datei']);
$logmode = escapeshellcmd($_POST['logmode']);
$max_chars = escapeshellcmd($_POST['maxchars']);
$max_time = escapeshellcmd($_POST['maxtime']);

//Speicherort des Zwischenspeichers
$befehl_datei = 'tmp/befehl.txt';

//Dateipfad zur Aufnahme zusammensetzen
$pfad = "$ordner/{$datei}.log";

//Echo der Schnittstelle ausschalten
exec("stty -F $tty -echo");

//Baudrate setzen
exec("stty -F $tty $baud");

//Schnittstellenzugriffsmodus auf "raw" setzen (schaltet die Pufferung auf einzelne Zeichen)
exec("stty -F $tty raw");

//Befehl in temporäre Datei schreiben
$temp_datei = fopen($befehl_datei, 'w');	//Datei zum Schreiben öffnen
fwrite($temp_datei, $befehl);
fclose($temp_datei);

//Vorherige Befehlsausgabe löschen
unlink('tmp/nohup.out');

//Aufnahme starten
system("nohup nativ/receive $tty $pfad $logmode $max_chars $max_time $befehl_datei > tmp/nohup.out &");
sleep(1); //Eine Sekunde warten

//Befehlsausgabe analysieren
$dateistream = fopen('tmp/nohup.out', "r");
$result = fread($dateistream, filesize('tmp/nohup.out'));
fclose($dateistream);
if(strpos($result,'ERROR')!==FALSE)	//Enthält die Befehlsausgabe eine Fehlermeldung?
{
	//Wenn nicht Erfolgreich: Automatische Weiterleitung nach 3 Sekunden und Meldung ausgeben
	echo "<meta http-equiv=\"refresh\" content=\"3; URL=$return_failure\">";
	echo "</head>\n<body>";
	echo $result;
}
	else
	{
		//Wenn Erfolgreich: Automatische Weiterleitung nach 1 Sekunde und Meldung ausgeben
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=wartung_show.php?pfad=$pfad\">";
		echo "</head>\n<body>";
		echo "Aufnahme gestartet.";
	}	


?>
</body>
</html>
