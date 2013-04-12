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

function write($file) {
	$output = $comment . "\n";
	$output = $output . 'Index,' . $index . "\n";

	$linecounter = 0;
	for($counter = 1; $counter <= $count; $counter++) {
		$linecounter++;
		if(in_array($linecounter,$_POST["trenn"])) {
			$output = $output . "*\n";
			$linecounter++;
		}
	
		if($_POST["check$counter"] === "true") {
			$output = $output . $_POST["id$counter"] . ',' . $_POST["value$counter"] . ',' . $_POST["min$counter"] . ',' . $_POST["max$counter"] . ',' . $_POST["text$counter"] . "\n";
		}
	}
	
	echo $output;
}

$filename = $_POST["filename"];
$mode = $_POST["mode"];

$comment = $_POST["comment"];
$index = $_POST["index"];
$count = $_POST["count"];

switch(mode) {
	case save:
		write($filename);
		break;
}

?>
