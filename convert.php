<?php
/*
    RPQ2-Webinterface
    
    Copyright (C) 2012 Innowatt Energiesysteme GmbH
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
    
    --------------------convert.php----------------------------------
    Diese Datei wird aufgerufen, wenn man eine Datei zum Konvertieren
	ausgewählt hat und zeigt die Einstellungen an, mit denen der 
	eigentliche Konvertierungsprozess dann aufgerufen wird.
*/

include('settings.php');
include('page.php');

$pfad = $_GET['pfad'];	//Holen des Pfades der zu konvertierenden Datei aus der URL

$convert_form = file_get_contents('convert_form.html');
$template_heading = file_get_contents('template_heading.html');
$template_button = file_get_contents('template_button.html');

//Extrahieren des Dateinamens aus dem Pfad
$dummy = explode('/',$pfad);		//Auftrennen des Pfades anhand von '/'
$datei = $dummy[count($dummy)-1];	//Der Teil nach dem letzten '/' ist der Dateiname

$title = "Konvertieren der CSV-Sollwerttabelle \"$datei\"";
$heading = "Konvertieren der CSV-Sollwerttabelle \"$datei\"";
$author = 'Max Bruckner';

$output = str_replace('{heading}',$heading,$template_heading);
$output .= str_replace('{pfad}', $pfad, $convert_form);

$button = str_replace('{link}', 'csv.php', $template_button);
$button = str_replace('{text}', 'Zurück zu CSV-Sollwerttabellen', $button);
$output .= $button;

draw_page($output, $title, $author, LAYOUT);
?>
