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

$einstell_template = file_get_contents('einstellzeile.html');	//Vorlage für die Listenelemente
$einstell_template_trenn = file_get_contents('einstellzeile_trenn.html');	//Vorlage für die Trennlinien
$counter = 0;
$linecounter = 0;		//Zählt die bearbeiteten CSV-Zeilen
$trennlines;			//Array, das alle Zeilen enthält, in denen sich Trennlinien befinden.

function einstell_zeile( $csv_string ) {
	global $einstell_template, $einstell_template_trenn, $counter, $linecounter, $trennlines;
	
	$linecounter++;
	
	if( $csv_string == '*' ) {
		echo $einstell_template_trenn;
		$trennlines[] = $linecounter;
	}
	else {
		$fields = explode(',', $csv_string);
		
		if(!is_numeric($fields[0])) {
			return;
		}
		
		
		$counter++;
		
		$output_line = $einstell_template;
		$output_line = str_replace('{id}',$fields[0],$output_line);
		
		$value = '<input type="text" name="value' . $counter . '" value="' . $fields[1] . '" tabindex="' . $counter . '">'; 
		$output_line = str_replace('{value}',$value,$output_line);
		
		$output_line = str_replace('{min}',$fields[2],$output_line);
		$output_line = str_replace('{max}',$fields[3],$output_line);
		$output_line = str_replace('{text}',$fields[4],$output_line);
		
		$form = '<input type="hidden" name="check' . $counter . '" value="false">'
		      . '<input type="checkbox" name="check' . $counter . '" value="true" checked>'
		      . '<input type="hidden" name="id' . $counter . '" value="' . $fields[0] . '">'
		      . '<input type="hidden" name="defv' . $counter . '" value="' . $fields[1] . '">'
		      . '<input type="hidden" name="min' . $counter . '" value="' . $fields[2] . '">'
		      . '<input type="hidden" name="max' . $counter . '" value="' . $fields[3] . '">'
		      . '<input type="hidden" name="text' . $counter . '" value="' . $fields[4] . '">';
		$output_line = str_replace('{form}',$form,$output_line);
		
		echo $output_line;
	}
}

$title = 'Einstellwerte';
$author = 'Max Bruckner';
$heading = 'Einstellwerte';

$ordner = 'einstell';

$filename = $_GET["filename"];
if($filename == '') {
	$filename = 'default.csv';
}

$path = $ordner . '/' . $filename;
$filecontent = file_get_contents($path);
$lines = explode("\n", $filecontent);

include('header.php');
include('heading.php');

echo "<form action=\"einstell_write.php\" method=\"post\">\n";
echo "<table>\n";
foreach($lines as $line) {
	if($line !== '') {
		einstell_zeile($line);
	}
}
echo "</table>\n";

foreach($trennlines as $trennline) {
	echo '<input type="hidden" name="trenn[]" value="' . $trennline . '">';
}

echo '<input type="hidden" name="count" value="' . $counter . '">';
echo '<input type="reset" value="Zurücksetzen">';
echo '<input type="submit" value="Absenden">';
echo "</form>\n";

include('footer_sub.php');
?>
