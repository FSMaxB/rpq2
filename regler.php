<?php
include('settings.php'); //Headerdatei einbinden
$title = 'Regler-Sollwertvorgaben';
$author = 'Max Bruckner';
$heading = 'Regler-Sollwertvorgaben';

$ordner = $ordner_regler;
$link = "regler_link.php";	//Datei mit den Links für die Auflistung der Regler-Sollwertvorgaben

$return = 'regler.php'; //Setzt automatische Weiterleitung auf diese Seite

include('header.php');
include('heading.php');
include('list.php');	//Einbinden der Auflistung von Regler-Sollwertvorgaben
include('footer_sub.php');
?>
