<?php
$title = 'Eigene Dokumentationen';
$author = 'Max Bruckner';
$heading = 'Eigene Dokumentationen';

$ordner = 'owndocs';		//Ordner, in dem die eigenen Dokumentationen gespeichert werden. Kann hier global gesetzt werden.
$link = 'owndocs_link.php';
$return = 'owndocs.php';	//Der Name dieser Datei (wichtig für Skripte, die zurückkehren wollen)

include('header.php');
include('heading.php');
include('owndocs_upload.php');	//Einbinden des Upload-Formulares
include('list.php');		//Einbinden der Auflistung von Dokumentationen

include('footer_sub.php');

?>
