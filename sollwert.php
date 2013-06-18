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
include_once('glob_function.php');

$title = 'Sollwerte';
$author = 'Max Bruckner';
$heading = 'Sollwerte/Steuerung Betriebsart';

$regler = $_POST['regler'];
$mode = $_POST['mode'];
$anzahl = $_POST['anzahl'];
$wert1 = $_POST['wert1'];
$wert2 = $_POST['wert2'];
$wert3 = $_POST['wert3'];
$wert4 = $_POST['wert4'];
$wert5 = $_POST['wert5'];
$wert6 = $_POST['wert6'];
$wert7 = $_POST['wert7'];
$wert8 = $_POST['wert8'];
$BA_Regler_Aus = $_POST['Betriebsart_Regler_Aus'];
$BA_Regler_Freigabe = $_POST['Betriebsart_Regler_Freigabe'];
$BA_Regler_RK2 = $_POST['Betriebsart_Regler_RK2'];
$BA_Manuell_G = $_POST['Betriebsart_Manuell_G'];
$BA_Manuell_K = $_POST['Betriebsart_Manuell_K'];
$BA_Manuell_GGKK = $_POST['Betriebsart_Manuell_GGKK'];
$BA_Autoquit = $_POST['Betriebsart_Autoquit'];
$BA_Quit_Kabelbruch = $_POST['Betriebsart_Quit_Kabelbruch'];
 
function get_sollwert($received,$wert1,$wert2,$wert3,$wert4,$wert5,$wert6,$wert7,$wert8,
					  $BA_Regler_Aus,$BA_Regler_Freigabe,$BA_Manuell_G,
					  $BA_Manuell_K,$BA_Manuell_GGKK,$BA_Autoquit,$BA_Quit_Kabelbruch,$befehl,$status,$st_Info,$regler,$BA_check) {
	$template_sollwert = file_get_contents('template_sollwert.html');
	$output = str_replace('{received}', $received, $template_sollwert);
 	$output = str_replace('{wert1}', $wert1, $output);	
	$output = str_replace('{wert2}', $wert2, $output);	 	
	$output = str_replace('{wert3}', $wert3, $output);	 
	$output = str_replace('{wert4}', $wert4, $output);	
 	$output = str_replace('{wert5}', $wert5, $output);	
	$output = str_replace('{wert6}', $wert6, $output);	 	
	$output = str_replace('{wert7}', $wert7, $output);	 
	$output = str_replace('{wert8}', $wert8, $output);		
	 					
	$output = str_replace('{Betriebsart_Regler_Aus}', $BA_Regler_Aus, $output);	 			
	$output = str_replace('{Betriebsart_Regler_Freigabe}', $BA_Regler_Freigabe, $output);	 				
//	$output = str_replace('{Betriebsart_Regler_RK2}', $BA_Regler_RK2, $output);
	$output = str_replace('{Betriebsart_Manuell_G}', $BA_Manuell_G, $output);
	$output = str_replace('{Betriebsart_Manuell_K}', $BA_Manuell_K, $output);
	$output = str_replace('{Betriebsart_Manuell_GGKK}', $BA_Manuell_GGKK, $output);
	$output = str_replace('{Betriebsart_Autoquit}', $BA_Autoquit, $output);
	$output = str_replace('{Betriebsart_Quit_Kabelbruch}', $BA_Quit_Kabelbruch, $output);
	
	$output = str_replace('{checked1}', $BA_check[0], $output);	
	$output = str_replace('{checked2}', $BA_check[1], $output);	
	$output = str_replace('{checked3}', $BA_check[2], $output);	
	$output = str_replace('{checked4}', $BA_check[3], $output);		
	$output = str_replace('{checked5}', $BA_check[4], $output);	
	$output = str_replace('{checked6}', $BA_check[5], $output);	
	$output = str_replace('{checked7}', $BA_check[6], $output);			
	
	
	
	$output = str_replace('{befehl}', $befehl, $output);				
	$output = str_replace('{status}', $status, $output);					
	$output = str_replace('{st_Info}', $st_Info, $output);						
	$output = str_replace('{regler}', $regler, $output);						
	return $output;
}


set_tty();

if($regler != '') 
{
	switch($mode)
	{
		case "write":
		{
			$Betriebsart =  0;
//			if ($BA_Regler_Aus > 0)
			if(isset($BA_Regler_Aus))
			{
				$Betriebsart = 1;
				$BA_check[0] ='checked';
			}	
//			if($BA_Regler_Freigabe > 0)
			if(isset($BA_Regler_Freigabe))
			{
				$Betriebsart += 2;
				$BA_check[1] ='checked';				
			}

//			if ($BA_Manuell_G > 0)				
			if(isset($BA_Manuell_G))				
			{
				$Betriebsart += 32;			
				$BA_check[2] ='checked';				
			}
//			if ($BA_Manuell_K > 0)
			if(isset($BA_Manuell_K))
			{
				$Betriebsart += 64;	
				$BA_check[3] ='checked';
			}	
//			if ($BA_Manuell_GGKK > 0)
			if(isset($BA_Manuell_GGKK))			
			{
				$Betriebsart += 128;	
				$BA_check[4] ='checked';				
			}
//			if ($BA_Autoquit > 0)
			if(isset($BA_Autoquit ))
			{		
				$Betriebsart += 0x4000;			
				$BA_check[5] ='checked';				
			}
//			if ($BA_Quit_Kabelbruch > 0)
			if(isset($BA_Quit_Kabelbruch))
			{
				$Betriebsart += 0x8000;		
				$BA_check[6] ='checked';				
			}
			$befehl = 'st' . hex($regler, 2) . hex($Betriebsart, 4) . 'ENDE';
			$received = send($befehl);
		}
		break;
		case "write_Soll":
		{
			$befehl = hex($regler, 2) . hex($wert1, 4);
			switch($anzahl)
			{
				case "2": 
					$befehl .= hex($wert2, 4);
				break;
				case "3": 
					$befehl .= hex($wert2, 4) . hex($wert3, 4);
				break;				
				case "4": 
					$befehl .= hex($wert2, 4) . hex($wert3, 4) . hex($wert4, 4);
				break;	
				case "5": 
					$befehl .= hex($wert2, 4) . hex($wert3, 4) . hex($wert4, 4);
					$befehl .= hex($wert5, 4);
				break;					
				case "6": 
					$befehl .= hex($wert2, 4) . hex($wert3, 4) . hex($wert4, 4);
					$befehl .= hex($wert5, 4) . hex($wert6, 4);
				break;	
				case "7": 
					$befehl .= hex($wert2, 4) . hex($wert3, 4) . hex($wert4, 4);
					$befehl .= hex($wert5, 4) . hex($wert6, 4) . hex($wert7, 4);
				break;		
				case "8": 
					$befehl .= hex($wert2, 4) . hex($wert3, 4) . hex($wert4, 4);
					$befehl .= hex($wert5, 4) . hex($wert6, 4) . hex($wert7, 4);
					$befehl .= hex($wert8, 4);
				break;																																																																								
			}

			if($wert1 != '')
			{
				$befehl = 'sw' . $befehl . 'ENDE';
				$received = send($befehl);
			}
		}
		break;
		case "read":
		{
			$befehl = 'ip' . hex($regler, 2);
			$received = send($befehl);
			$Save_received = $received;
		
			$temp = substr($received,0,3) . ' ';
			for($var = 3; $var < 68 ;$var+= 4)
			{
				$temp .= substr($received,$var,4) . ' ';
			}
			$received = $temp;
			
			$Betriebsart = AsciiHex_to_Dezimal(substr($Save_received,27,4)) ;
			if ($Betriebsart & 1)
			{
				$BA_Regler_Aus = 1;
				$BA_check[0] ='checked';
			}
			else
				$BA_Regler_Aus = 0;
				
			if ($Betriebsart & 2)
			{
				$BA_Regler_Freigabe = 1;
				$BA_check[1] ='checked';				
			}
			else
				$BA_Regler_Freigabe = 0;	
				
//			if ($Betriebsart & 8)
//				$BA_Regler_RK2 = 1;
//			else
//				$BA_Regler_RK2 = 0;
				
			if ($Betriebsart & 32)
			{
				$BA_Manuell_G = 1;
				$BA_check[2] ='checked';				
			}
			else
				$BA_Manuell_G = 0;								
			
			if ($Betriebsart & 64)
			{
				$BA_Manuell_K = 1;
				$BA_check[3] ='checked';				
			}
			else
				$BA_Manuell_K = 0;
				
			if ($Betriebsart & 128)
			{
				$BA_Manuell_GGKK = 1;
				$BA_check[4] ='checked';				
			}
			else
				$BA_Manuell_GGKK = 0;	
				
			if ($Betriebsart & 0x4000)
			{
				$BA_Autoquit = 1;
				$BA_check[5] ='checked';				
			}
			else
				$BA_Autoquit = 0;	
				
			if ($Betriebsart & 0x8000)
			{
				$BA_Quit_Kabelbruch = 1;
				$BA_check[6] ='checked';				
			}
			else
				$BA_Quit_Kabelbruch = 0;	

			$wert1 = AsciiHex_to_Dezimal(substr($Save_received,31,4)) ;
			if ($anzahl > 1)
				$wert2 = AsciiHex_to_Dezimal(substr($Save_received,35,4)) ;	
			if ($anzahl > 2)
				$wert3 = AsciiHex_to_Dezimal(substr($Save_received,39,4)) ;
			if ($anzahl > 3)				
				$wert4 = AsciiHex_to_Dezimal(substr($Save_received,43,4)) ;
			if ($anzahl > 4)	
				$wert5 = AsciiHex_to_Dezimal(substr($Save_received,47,4)) ;
			if ($anzahl > 5)		
				$wert6 = AsciiHex_to_Dezimal(substr($Save_received,51,4)) ;	
			if ($anzahl > 6)		
				$wert7 = AsciiHex_to_Dezimal(substr($Save_received,55,4)) ;
			if ($anzahl > 7)		
				$wert8 = AsciiHex_to_Dezimal(substr($Save_received,59,4)) ;							
			
		}
		break;
		case "read_Status":
		{
			$befehl = 'mw' . hex($regler, 2);
			$received = send($befehl);
			$Save_received = $received;
			
			$status = substr($Save_received,3,4);
			$Zahl = AsciiHex_to_Dezimal($status) ;
			$st_Info = NULL;
			
			if ($Zahl < 0)
				$st_Info .= ' Betriebsbereit(B15)';
			if ($Zahl & 1)	
				$st_Info .= ' Fehler(B0)';															
			if ($Zahl & 16)	
				$st_Info .= ' Begrenzung PID Regler(B4)';											
			if ($Zahl & 32)	
				$st_Info .= ' Begrenzung Ausgang(B5)';							
			if ($Zahl & 64)	
				$st_Info .= ' Regler Aus(B6)';	
			if ($Zahl & 128)	
				$st_Info .= ' Freigabe(B7)';
			if ($Zahl & 512)	
				$st_Info .= ' Regelkreis 2(B9)';	
			if ($Zahl & 0x4000)	
				$st_Info .= ' ausgeregelt(B14)';																									
		}
		break;
	}
	$regler = substr($befehl,2,2);
}

$output = '</br>';
//$output = get_heading($heading);
$output .= get_sollwert($received,$wert1,$wert2,$wert3,$wert4,$wert5,$wert6,$wert7,$wert8,
						$BA_Regler_Aus,$BA_Regler_Freigabe,$BA_Manuell_G,
						$BA_Manuell_K,$BA_Manuell_GGKK,$BA_Autoquit,
						$BA_Quit_Kabelbruch,$befehl,$status,$st_Info,$regler,$BA_check);
$output .= '</br>';
$output .= '</br>';
$output .= get_button_inline('index.php', '<b>Zum Hauptmenu</b>');
$output .= ' ';
$output .= get_button_inline('mess.php?filename=default.mw', '<b>Zu Messwerten</b>');
$output .= ' ';
$output .= get_button_inline('einstell-mess.php', '<b>Weitere Einstellwerte</b>');
draw_page( $output, $title, $author, HEAD);
?>
