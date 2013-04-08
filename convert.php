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

$pfad = $_GET['pfad'];	//Holen des Pfades der zu konvertierenden Datei aus der URL

//Extrahieren des Dateinamens aus dem Pfad
$dummy = explode('/',$pfad);		//Auftrennen des Pfades anhand von '/'
$datei = $dummy[count($dummy)-1];	//Der Teil nach dem letzten '/' ist der Dateiname

$title = "Konvertieren der CSV-Sollwerttabelle \"$datei\"";
$heading = "Konvertieren der CSV-Sollwerttabelle \"$datei\"";
$author = 'Max Bruckner';

include('header.php');			//Header einbinden
include('heading.php');			//Überschrift einbinden
include('convert_form.php');	//Formular für die Konvertierungseinstellungen einbinden
include('convert_footer.php');	//Angepassten Footer einbinden
?>
