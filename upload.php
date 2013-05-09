<?php
/*
    RPQ2-Webinterface
    
    Copyright (C) 2012-2013 Innowatt Energiesysteme GmbH
    Author: Max Bruckner
    
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see http://www.gnu.org/licenses/.
*/
include('page.php');

$title = 'Datei hochladen';
$author = 'Max Bruckner';


//Variablen per POST holen
$ordner = $_POST['ordner'];
$return_success = $_POST['return_success'];	//Seite, auf die im Erfolgsfall umgeleitet wird
$return_failure = $_POST['return_failure'];	//Seite, auf die im Fehlerfall umgeleitet wird
$extension = $_POST['extension'];

$template_redirect = file_get_contents('template_redirect.html');

$name = $_FILES['datei']['name'];	//Ursprünglicher Dateiname der hochgeladenen Datei

//Überprüfen und korrigieren der Dateiendung
$split = explode('.', $name);
if( ($extension != '') && (strcmp(end($split), $extension) !== 0) ) {
	$name .= ".$extension";
}

$ziel = "$ordner/$name";


if(move_uploaded_file($_FILES['datei']['tmp_name'],$ziel))	//Datei Hochladen und Abfragen ob es geklappt hat
{
	//Wenn erfolgreich, leite nach 1 Sekunde automatisch um und gebe Meldung aus
	$header = str_replace('{time}', '1', $template_redirect);
	$header = str_replace('{destination}', $return_success, $header);
	
	$output = "Datei \"{$_FILES['datei']['name']}\" erfolgreich hochgeladen.";
} else {
	//Wenn nicht erfolgreich, leite nach 3 Sekunden automatisch um und gebe Meldung aus
	$header = str_replace('{time}', '3', $template_redirect);
	$header = str_replace('{destination}',$return_failure, $header);
	$output = "Beim Hochladen der Datei \"{$_FILES['datei']['name']}\" ist ein Fehler aufgetreten.";
}

draw_page($output, $title, $author, RAW, $header);
?>
