<?php
$author = 'Max Bruckner';
$title = 'Daten Übertragen';
include('header.php');
define(def_baudrate, '9600');				//Standardwert für die Baudrate

//Einlesen der Variablen aus URL.
//escapeshellcmd() auf diejenigen anwenden, die an Systembefehle weitergegeben werden
$baudrate = escapeshellcmd($_GET['baud']);
$input = escapeshellcmd($_GET['input']);	//Eingabedatei
$output = escapeshellcmd($_GET['tty']);	//Schnittstelle
$timeout = escapeshellcmd($_GET['timeout']);
$adresse = escapeshellcmd($_GET['adresse']);
$return_success = $_GET['return_success'];	//Weiterleitung bei Erfolg
$return_failure = $_GET['return_failure'];	//Weiterleitung im Fehlerfall

if($baudrate == '')			//Falls keine Baudrate angegeben wurde: Standardwert verwenden
	$baudrate = def_baudrate;

system("stty -F $output -echo");		//echo der Schnittstelle ausschalten
system("stty -F $output $baudrate");			//Baudrate einstellen
system("stty -F $output cooked");		//Pufferung des Betriebsystems anschalten, da diese eventuell von der Aufnahmefunktion abgeschaltet wurde

$result = exec("./nativ/send $input $output $adresse $timeout"); //Ausführen des C-Programmes zum Übertragen über die Schnittstelle
echo "<h2 align=\"center\">$result</h2><br />";

if(strpos($result,'ERROR')!==FALSE)	//Enthält die Befehlsausgabe eine Fehlermeldung?
	$return = $return_failure;
	else
		$return = $return_success;

//Ist eine Weiterleitung angegeben worden, so erstelle entsprechenden Link
if($return != '')
	echo "<button onclick=\"window.location.href='$return'\" style=\"width:100%\"><h3 align=\"center\">weiter</h3></button>";
include('footer.php');
?>
