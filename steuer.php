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

$einstell_template = file_get_contents('einstellzeile.html');
$einstell_template_trenn = file_get_contents('einstellzeile_trenn.html');

function einstell_zeile( $csv_string ) {
	global $einstell_template, $einstell_template_trenn;
	if( $csv_string == '*' ) {
		echo $einstell_template_trenn;
	}
	else {
		$fields = explode(',', $csv_string);
		$output_line = $einstell_template;
		$output_line = str_replace('{id}',$fields[0],$output_line);
		$output_line = str_replace('{value}',$fields[1],$output_line);
		$output_line = str_replace('{min}',$fields[2],$output_line);
		$output_line = str_replace('{max}',$fields[3],$output_line);
		$output_line = str_replace('{text}',$fields[4],$output_line);
		$output_line = str_replace('{form}',"<input type=\"checkbox\" name=\"checked" . $fields[0] . "\" value=\"true\">",$output_line);
		echo $output_line;
	}
}

$title = 'Steuerung';
$author = 'Max Bruckner';
$heading = 'Steuerung';

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

echo "<form action=\"einstell_write.php\" method=\"get\">\n";
echo "<table>\n";
foreach($lines as $line) {
	if($line !== '') {
		einstell_zeile($line);
	}
}
echo "</table>\n";
echo "<input type=\"submit\" value=\"Absenden\">";
echo "</form>\n";

include('footer_sub.php');
?>
