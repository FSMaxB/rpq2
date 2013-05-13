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
include_once('page.php');
include_once('templates.php');

$counter = 0;
$linecounter = 1;		//Zählt die bearbeiteten CSV-Zeilen
$trennlines;			//Array, das alle Zeilen enthält, in denen sich Trennlinien befinden.
$einstellwerte; //String, in den die Fertige Liste von Einstellwerten reinkommt.
$trenn; //hidden formulare für den Array mit trennzeilen.

function einstell_zeile( $csv_string ) {
	global $counter, $linecounter, $trennlines, $einstellwerte;
	
	if( $csv_string == '*' ) {
		$einstellwerte .= "\n" . get_einstellzeile_trenn();
		$trennlines[] = $linecounter;
		$linecounter++;
	}
	else {
		$fields = explode(',', $csv_string);
		
		if(!is_numeric($fields[0])) {
			return;
		}
		
		
		$counter++;
		
		$id = '<input type="text" size="3" maxlength="3" name="id' . $counter . '" value="' . $fields[0] . '">';
		$value = '<input type="text" size="6" maxlength="6" name="value' . $counter . '" value="' . $fields[1] . '" tabindex="' . $counter . '">'; 
		$min = '<input type="text" size="6" maxlength="6" name="min' . $counter . '" value="' . $fields[2] . '">';
		$max = '<input type="text" size="6" maxlength="6" name="max' . $counter . '" value="' . $fields[3] . '">';
		$text = '<input type="text" size="50" maxlength="50" name="text' . $counter . '" value="' . $fields[4] . '">';
		$form = '<input type="hidden" name="check' . $counter . '" value="false">'
		      . '<input type="checkbox" name="check' . $counter . '" value="true" checked>';
		$output_line = get_einstellzeile($form, $text, $id, $value, $min, $max);
		
		$einstellwerte = $einstellwerte . "\n" . $output_line;
		$linecounter++;
	}
}

$title = 'Einstellwerte';
$author = 'Max Bruckner';
$heading = 'Einstellwerte';

$filename = $_GET["filename"];
if($filename == '') {
	$filename = 'default.csv';
}

$path = "{$settings['ordner_einstellwert']}/$filename";
$filecontent = file_get_contents($path);
$lines = explode("\n", $filecontent);

$comment = $lines[0];
$index = explode(',',$lines[1]);
$index = $index[1];

foreach($lines as $line) {
	if($line !== '') {
		einstell_zeile($line);
	}
}

foreach($trennlines as $trennline) {
	$trenn .= "\n" .  '<input type="hidden" name="trenn[]" value="' . $trennline . '">';
}

$output = get_heading($heading);
$output .= get_form_einstell($comment, $index, $einstellwerte, $filename, $counter, $trenn);
$output .= get_button_menu_back();

draw_page( $output, $title, $author, LAYOUT);
?>
