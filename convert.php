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

include_once('page.php');
include_once('templates.php');

$pfad = $_GET['pfad'];	//Holen des Pfades der zu konvertierenden Datei aus der URL

//Extrahieren des Dateinamens aus dem Pfad
$split = explode('/',$pfad);		//Auftrennen des Pfades anhand von '/'
$datei = end($split);

$title = "Konvertieren der CSV-Sollwerttabelle \"$datei\"";
$heading = "Konvertieren der CSV-Sollwerttabelle \"$datei\"";
$author = 'Max Bruckner';

$output = get_heading($heading);
$output .= get_form_convert($pfad);
$output .= get_button('csv.php', 'Zurück zu CSV-Sollwerttabellen');

draw_page($output, $title, $author, LAYOUT);
?>
