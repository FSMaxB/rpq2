<html>
<?php
//Entgegennehmen von Variablen aus URL
$pfad = $_GET['pfad'];
$modus = $_GET['modus'];

//Extrahieren des Dateinamens aus dem Pfad
$dummy = explode('/',$pfad);		//Splitte Pfad anhand des Trennzeichens '/'
$datei = $dummy[count($dummy)-1];	//Dateiname = letztes Element des Arrays

if($modus == 'sollwert')
{
	//Extrahieren der Regleradresse aus dem Dateinamen
	$dummy = explode('_',$datei);
	$adresse = $dummy[2];		//Hinweis: Dateiname ist immer SK_RPQ_adresse_rest
	
	$title = "Übertragen von Regler-Sollwertvorgabe \"$datei\"";
	$heading = "Übertragen von Regler-Sollwertvorgabe \"$datei\"";
}
else if($modus == 'einstell')
{
	$title = "Übertragen von CSV-Einstellwerten: \"$datei\"";
	$heading = "Übertragen von CSV-Einstellwerten: \"$datei\"";
	
}

$author = 'Max Bruckner';


include('header.php');
include('heading.php');
if($modus == 'sollwert')
{
	include('submit_form_sollwert.php');
	include('submit_footer_sollwert.php');
}
else if($modus == 'einstell')
{
	include('submit_form_einstell.php');
	include('submit_footer_einstell.php');
}
?>
