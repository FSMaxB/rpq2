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

include_once('settings.php');
include_once('file_list.php');

function get_ttys() {
	$devices = get_files('/dev');
	
	foreach ( $devices as $device ) {
		if( (strpos($device, 'ttyS') === 0) || (strpos($device, 'ttyUSB') === 0) || (strpos($device, 'ttyS') === 0) || (strpos($device, 'ttyAMA') === 0) || (strpos($device, 'ttyACM') === 0))
			$ttys[] = $device;
	}
	
	return $ttys;
}

function set_tty() {
	global $settings;
	system("stty -F {$settings['serial_interface']} -echo");
	system("stty -F {$settings['serial_interface']} {$settings['serial_baudrate']}");
	system("stty -F {$settings['serial_interface']} raw");
}

?>
