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

$title = 'Dokumentationen';
$author = 'Max Bruckner';
$heading = 'Dokumentationen';

$docs_ordner = 'docs';			//Ordner, in dem die Dokumentationen gespeichert sind. Kann hier global verändert werden
$ordner = opendir($docs_ordner);	//Ordner öffnen

include('header.php');
include('heading.php');

echo "<div align=\"center\">";	//Beginne zentrierten Kontainer

//Ordnerinhalt durchgehen
while(TRUE)
{
	$dateiname = readdir($ordner);
	if($dateiname !== FALSE)	//Sind noch Dateien Übrig?
	{
		if($dateiname != '.' && $dateiname != '..')	//Ausfilterung der Ordner '.' und '..'
			include('docs_button.php');	//Datei als Button darstellen
	}
	else break;
}
echo '</div>';			//Beende zentrierten Kontainer

include('footer_sub.php');
?>
