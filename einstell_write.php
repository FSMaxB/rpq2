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
include_once('templates.php');
include_once('page.php');
include_once('tty.php');

$author = 'Max Bruckner';
$title = 'Einstellwerte übertragen';

$filename = $_POST["filename"];
$mode = $_POST["mode"];
$comment = $_POST["comment"];
$index = $_POST["index"];
$count = $_POST["count"];
$regleradresse = $_POST["regleradresse"];
$results;

function write($filename, $write_all) {
	global $_POST, $comment, $index, $count, $settings;
	
	$output = $comment . "\n";
	$output .= 'Index,' . $index . "\n";
	
	$linecounter = 0;
	for($counter = 1; $counter <= $count; $counter++) {
		$linecounter++;
		if(in_array($linecounter,$_POST["trenn"])) {
			$output .= "*\n";
			$linecounter++;
		}
	
		if( ($_POST["check$counter"] === "true") || $write_all ) {
			$output .= $_POST["id$counter"] . ',' . $_POST["value$counter"] . ',' . $_POST["min$counter"] . ',' . $_POST["max$counter"] . ',' . $_POST["text$counter"] . "\n";
		}
	}
	
	file_put_contents($settings['ordner_einstellwert'] . $filename,$output);
}

function run() {
	global $results, $mode, $read, $regleradresse, $settings;
	if($mode == 'write_save') {
		$mode_param = 'write';
	} else {
		$mode_param = $mode;
	}
	exec("nativ/einstell $mode_param {$settings['serial_interface']} $regleradresse {$settings['ordner_einstellwert']}/send.csv $read", $outputs);
	
	foreach ($outputs as $output) {
		$results .= $output . "\n";
	}
}

function redirect($adress, $text) {
		global $title, $author;
		$output =  '<h2 align="center">' . nl2br($text) . '</h2><br />';
		$output .= get_button($adress, $text);
		draw_page( $output, $title, $author, LAYOUT);
}


set_tty();

switch ($mode) {
	case 'save':
		write($filename,false);
		redirect('einstelltab.php', "Einstellwerte in $filename gespeichert!");
		break;
	case 'read':
		write('send.csv', false);
		$read = "{$settings['ordner_einstellwert']}/antwort.csv";
		run();
		$pos = strpos($results,'FEHLER');
		if( $pos !== false )	{ //Enthält die Befehlsausgabe eine Fehlermeldung?
			redirect("einstell.php?filename=send.csv" ,$results);
		}	else {
				redirect("einstell.php?filename=antwort.csv", 'Lesen der Einstellwerte erfolgreich!');
		}
		break;
	case 'write':
		write('send.csv', false);
		run();
		$pos = strpos($results,'FEHLER');
		if( $pos !== false)	{ //Enthält die Befehlsausgabe eine Fehlermeldung?
			redirect("einstell.php?filename=send.csv" ,$results);
		}	else {
				redirect("einstell.php?filename=$filename", 'Schreiben der Einstellwerte erfolgreich!');
		}
		break;
	case 'write_save':
		write('send.csv', false);
		run();
		$pos = strpos($results,'FEHLER');
		if( $pos !== false)	{ //Enthält die Befehlsausgabe eine Fehlermeldung?
			redirect("einstell.php?filename=send.csv" ,$results);
		}	else {
				redirect("einstell.php?filename=$filename", 'Schreiben der Einstellwerte erfolgreich!');
				write($filename, true);
		}
		break;
}

?>
