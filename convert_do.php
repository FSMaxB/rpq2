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

include('settings.php');
include('page.php');

//Variablen aus URL holen
//escapeshellcmd() erhöht die Sicherheit beim Aufrufen von nativen Programmen und korrigiert Pfadangaben
$input =  escapeshellcmd($_GET['input']);		//Zu konvertierende Datei
$adresse = escapeshellcmd($_GET['adresse']);	//Regleradresse
$return_success = $_GET['return_success'];		//Rücksprung bei erfolg
$return_failure = $_GET['return_failure'];		//Rücksprung bei Fehler
$rumpf = "$ordner_regler/";							//Rumpf des Ordners, in dem die Konvertierte Datei landet

//Trennen von Dateinamen und restlichem Pfad
$dummy = explode('/',$input);				//Aufteilen des Pfades anhand von '/'
$input_datei = $dummy[count($dummy)-1];		//Der Dateiname ist das Ende des Pfades
if(count($dummy)==1)		//Wenn dummy nur ein Element enthält, ist der Rumpf das Aktuelle Verzeichnis '.'
	$input_rumpf = '.';
$i = 0;		//Initialisieren der Zählvariable
while($i<count($dummy)-1)		//Die Elemente von dummy wieder zu dem Pfad-Rumpf ohne Dateinamen zusammensetzen
{
	if($i > 0)	
		$input_rumpf = $input_rumpf . '/' . $dummy[$i];
		else
			$input_rumpf = $dummy[$i];
	$i = $i + 1;
}
$input_rumpf = $input_rumpf . '/';

exec("./nativ/CSV_ASM $input_rumpf $input_datei $adresse $rumpf", $results);
$result = '';
foreach ($results as $temp) {
	$result .= $temp;
}

$output .= $result;

if(strpos($result,'ERROR')!==FALSE)	//Enthält die Befehlsausgabe eine Fehlermeldung?
	$return = $return_failure;
	else
		$return = $return_success;

//Ist eine Weiterleitung angegeben worden, so erstelle entsprechenden Link
if($return != '')
	$output .= "<a href=\"$return\">[weiter]</a>";
	
draw_page($output, $title, $author, NAKED);
?>
