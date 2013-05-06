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
    
    --------------------docs.php-------------------------------------
    Zeigt die verfügbaren Dokumentationen an. (Listet alle Dateien 
    aus dem Ordner mit den Dokumentationen).
*/

include('settings.php');
include('page.php');

$template_button = file_get_contents('template_button.html');
$template_heading = file_get_contents('template_heading.html');

$title = 'Dokumentationen';
$author = 'Max Bruckner';
$heading = 'Dokumentationen';

$output;


$ordner = opendir($ordner_docs);	//Ordner öffnen

$output = str_replace('{heading}', $heading, $template_heading);

$output .= '<div align="center">';	//Beginne zentrierten Kontainer

//Ordnerinhalt durchgehen
while(TRUE)
{
	$dateiname = readdir($ordner);
	if($dateiname !== FALSE)	//Sind noch Dateien Übrig?
	{
		if($dateiname != '.' && $dateiname != '..')	{//Ausfilterung der Ordner '.' und '..'
			$button = str_replace('{link}', $ordner_docs . '/' . $dateiname, $template_button);
			$button = str_replace('{text}', $dateiname, $button);
			
			$output .= $button;
		}
	}
	else break;
}
$output .= '</div>';			//Beende zentrierten Kontainer

$button = str_replace('{link}', 'index.php', $template_button);
$button = str_replace('{text}', 'Zurück zum Hauptmenü', $button);
$output .= $button;

draw_page($output, $title, $author, LAYOUT);
?>
