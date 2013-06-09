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
include_once('settings.php');
include_once('templates.php');
include_once('tty.php');

$title = 'Sollwerte';
$author = 'Max Bruckner';
$heading = 'Sollwerte/Steuerung Betriebsart';

$regler = $_POST['regler'];
$wert1 = $_POST['wert1'];
$wert2 = $_POST['wert2'];
$wert3 = $_POST['wert3'];
$wert4 = $_POST['wert4'];
$wert5 = $_POST['wert5'];
$wert6 = $_POST['wert6'];
$wert7 = $_POST['wert7'];
$wert8 = $_POST['wert8'];
$Betriebsart_Regler_Aus = $_POST['Betriebsart_Regler_Aus'];
$Betriebsart_Regler_Freigabe = $_POST['Betriebsart_Regler_Freigabe'];
$Betriebsart_Regler_RK2 = $_POST['Betriebsart_Regler_RK2'];
$Betriebsart_Manuell_G = $_POST['Betriebsart_Manuell_G'];
$Betriebsart_Manuell_K = $_POST['Betriebsart_Manuell_K'];
$Betriebsart_Manuell_GGKK = $_POST['Betriebsart_Manuell_GGKK'];
$Betriebsart_Autoquit = $_POST['Betriebsart_Autoquit'];
$Betriebsart_Quit_Kabelbruch = $_POST['Betriebsart_Quit_Kabelbruch'];

function get_sollwert($received) {
	$template_sollwert = file_get_contents('template_sollwert.html');
	$output = str_replace('{received}', $received, $template_sollwert);
	return $output;
}


set_tty();

if($regler != '') {
//    $received = send('sw' . hex($regler, 2) . hex($wert1, 4) . hex($wert2, 4) . 'ENDE');

    $befehl = hex($regler, 2) . hex($wert1, 4) . hex($wert2, 4) . hex($wert3, 4) ;
    $befehl .= hex($wert4, 4) . hex($wert5, 4) . hex($wert6, 4) . hex($wert7, 4) ;
    $befehl .= hex($wert8, 4);
    $Betriebsart =  NULL;
	if ($Betriebsart_Regler_Aus > 0)
		$Betriebsart = 1;
	if($Betriebsart_Regler_Freigabe > 0)
		$Betriebsart += 2;
	if($Betriebsart_Regler_RK2 > 0)
		$Betriebsart += 8;		
	if ($Betriebsart_Manuell_G > 0)
		$Betriebsart += 32;			
	if ($Betriebsart_Manuell_K > 0)
		$Betriebsart += 64;	
	if ($Betriebsart_Manuell_GGKK > 0)
		$Betriebsart += 128;	
	if ($Betriebsart_Autoquit > 0)
		$Betriebsart += 0x4000;			
	if ($Betriebsart_Quit_Kabelbruch > 0)
		$Betriebsart += 0x8000;					
						
    if ($Betriebsart != '')
    {
		$befehl = 'st' . hex($regler, 2) . hex($Betriebsart, 4) . 'ENDE';
		$received = send($befehl);
	}
	else
	{
		if($wert1 != '')
		{
			$befehl = 'sw' . $befehl . 'ENDE';
			$received = send($befehl);
		}
	}
    
    
 }

$output = get_heading($heading);
$output .= get_sollwert($received);
$output .= '</br>';
$output .= '</br>';
$output .= get_button_inline('index.php', '<b>Zum Hauptmenu</b>');
$output .= ' ';
$output .= get_button_inline('mess.php?filename=default.mw', '<b>Zu Messwerten</b>');
$output .= ' ';
$output .= get_button_inline('einstell-mess.php', '<b>Weitere Einstellwerte</b>');
draw_page( $output, $title, $author, HEAD);
?>
