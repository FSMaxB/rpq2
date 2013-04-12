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
*/

$filename = $_POST["filename"] . '.csv';
$mode = $_POST["mode"];

$comment = $_POST["comment"];
$index = $_POST["index"];
$count = $_POST["count"];

function write() {
	global $_POST, $comment, $index, $count;
	
	$output = $comment . "\n";
	$output .= 'Index,' . $index . "\n";
	
	$linecounter = 0;
	for($counter = 1; $counter <= $count; $counter++) {
		$linecounter++;
		if(in_array($linecounter,$_POST["trenn"])) {
			$output .= "*\n";
			$linecounter++;
		}
	
		if($_POST["check$counter"] === "true") {
			$output .= $_POST["id$counter"] . ',' . $_POST["value$counter"] . ',' . $_POST["min$counter"] . ',' . $_POST["max$counter"] . ',' . $_POST["text$counter"] . "\n";
		}
	}
	
	file_put_contents('einstell/' . $filename,$output);
}

function set_tty() {
	system("stty -F /dev/ttyUSB0 -echo");
	system("stty -F /dev/ttyUSB0 115200");
	system("stty -F /dev/ttyUSB0 raw");
}

//function run() {
//	$result = exec("nativ/einstell $mode /dev/ttyUSB0 ../einstell/send.csv $read");
//}

switch ($mode) {
	case 'save':
		write();
		break;
	case 'read':
		$filename = 'send.csv';
		write();
		$read = '../einstell/antwort.csv';
		run();
		echo $result;
		break;
	case 'write':
		$filename = 'send.csv';
		write();
		run();
		echo $result;
		break;
}

?>
