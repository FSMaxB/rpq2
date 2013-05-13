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

function get_settings() {
	global $settings;
	$settings = 
		array(		//Setzen der Defaultwerte
			'serial_interface' => '/dev/ttyUSB0',
			'serial_baudrate' => '115200',
			'ordner_docs' => 'docs',
			'ordner_owndocs' => 'owndocs',
			'ordner_einstellwert',
		);
	
	$file = file_get_contents('settings.cfg');
	$lines = explode("\n", $file);
		
	foreach( $lines as $line) {
		if( (strpos($line, '#') !== 0) && ($line)) {	//Kommentarzeilen werden ignoriert
			$setting = explode('=', $line);
			if( ($setting[0]) && ($setting[1]) ) {
				$settings[$setting[0]] = $setting[1];
			}
		}
	}
}

get_settings();
