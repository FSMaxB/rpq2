<?php
/*
    RPQ2-Webinterface

    Copyright (C) 2012-2013 Innowatt Energiesysteme GmbH
    Author: Andreas Bruckner

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


function send($send) {
    global $settings;

    $received = NULL;
    $befehl = NULL;

    exec("nativ/einstell wartung {$settings['serial_interface']} $send", $results);

    foreach ( $results as $result ) {
         $received .= "$result\n";
    }
    return $received;
}

function hex($input, $digits) {
	if ($input == '')
		return('');
	$string = NULL;
	for($i = 0; $i < $digits; $i++) {
		$string .= '0';
	}
	
	$string .= dechex($input);
	return substr($string, strlen($string) - $digits);
}

function AsciiHex_to_Dezimal($input) 
{
			$temp = substr($input,0,1);
			$Ziffer = ord($temp)-48;	
			if ($Ziffer > 9) 
				$Ziffer = $Ziffer -7;
			$Zahl = $Ziffer * 4096;
			
			$temp = substr($input,1,1);
			$Ziffer = ord($temp)-48;	
			if ($Ziffer > 9) 
				$Ziffer -= 7;
			$Zahl += $Ziffer * 256;
			
			$temp = substr($input,2,1);
			$Ziffer = ord($temp)-48;	
			if ($Ziffer > 9) 
				$Ziffer -= 7;
			$Zahl += $Ziffer * 16;
			
			$temp = substr($input,3,1);
			$Ziffer = ord($temp)-48;	
			if ($Ziffer > 9) 
				$Ziffer -= 7;
			$Zahl += $Ziffer;			
			if  ($Zahl > 0x7FFF)
			 $Zahl = $Zahl - 0xFFFF -1;

	return $Zahl;
}


?>
