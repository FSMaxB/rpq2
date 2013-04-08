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
    
    --------------------form_tty.php-----------------------------
    HTML-Formular(bestandteil) zur Auswahl der seriellen Schnitt-
    stelle (Gerätedatei).
*/
?>

Schnittstelle:
<select name="tty" size="1">
<?php
$folder = opendir('/dev/');	//Öffnen des Ordners mit den Gerätedateien

//Scannen nach gültigen seriellen Schnittstellen und ausgeben von Einträgen für Dropdown-Liste
while(TRUE)
{
	$geraet = readdir($folder);
	if($geraet !== FALSE)
	{
		if(strpos($geraet, 'ttyS')!==FALSE || strpos($geraet, 'ttyAMA')!==FALSE || strpos($geraet, 'ttyUSB')!==FALSE)
			echo "<option>/dev/$geraet</option>";
	}
	else break;
}
?>
</select>
<br />
