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

$author = 'Max Bruckner';
$title = 'Einstellwerte übertragen';
include('header.php');

$filename = $_POST["filename"] . '.csv';
$mode = $_POST["mode"];

$comment = $_POST["comment"];
$index = $_POST["index"];
$count = $_POST["count"];
$regleradresse = $_POST["regleradresse"];
$results;

function write() {
	global $_POST, $comment, $index, $count, $filename;
	
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

function run() {
	global $results, $mode, $read, $regleradresse;
	exec("nativ/einstell $mode /dev/ttyUSB0 $regleradresse einstell/send.csv $read", $outputs);
	
	foreach ($outputs as $output) {
		$results .= $output . "\n";
	}
}

function redirect($adress, $text) {
		echo '<h2 align="center">' . nl2br($text) . '</h2><br />';
		echo "<button onclick=\"window.location.href='$adress'\" style=\"width:100%\"><h3 align=\"center\">weiter</h3></button>";
}

switch ($mode) {
	case 'save':
		write();
		redirect('einstelltab.php', "Einstellwerte in $filename gespeichert!");
		break;
	case 'read':
		$filename = 'send.csv';
		write();
		$read = 'einstell/antwort.csv';
		run();
		$pos = strpos($result,'FEHLER');
		if( $pos == 0 )	{ //Enthält die Befehlsausgabe eine Fehlermeldung?
			redirect("einstell.php?filename=send.csv" ,$results);
		}	else {
				redirect("einstell.php?filename=antwort.csv", 'Lesen der Einstellwerte erfolgreich!');
		}
		redirect('index.php', $results);
		break;
	case 'write':
		$filename = 'send.csv';
		write();
		run();
		$pos = strpos($result,'FEHLER');
		if( $pos == 0)	{ //Enthält die Befehlsausgabe eine Fehlermeldung?
			redirect("einstell.php?filename=send.csv" ,$results);
		}	else {
				redirect("index.php", 'Schreiben der Einstellwerte erfolgreich!');
		}
		break;
}

include('footer.php');

?>
