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

$title = 'Einstellwerte';
$author = 'Max Bruckner';
$heading = 'Einstellwerte';

$filename = $_GET['filename'];
$einstell_csv = file_get_contents("{$settings['ordner_einstellwert']}/$filename");
$einstell_lines = explode("\n", $einstell_csv);

function get_comment($lines) {
    $comment = NULL;
    foreach($lines as $line) {
        if( (strpos($line, 'Index,') === 0) || (strpos($line, 'Regler,') === 0) || (strpos($line, '#')) ) {
             break;
        }
        $comment .= "$line\n";
    }
    return $comment;
}

function get_value($name, $lines) {
    foreach($lines as $line) {
        if( strpos($line, $name . ',') === 0 ) {
            $split = explode(',', $line);
            $value = $split[1];
            break;
        }
    }
    return $value;
}

function get_einstellwerte($lines) {
    $i = 0;
    $einstellwerte = NULL;
    foreach($lines as $line) {
        $einstellwerte[$i]['line'] = $line;
        //TODO so ziemlich alles
        $i++;
    }
    return $einstellwerte;
}

$output = $einstell_csv;

$comment = get_comment($einstell_lines);
$output .= "<p>$comment</p>";

$regler = get_value('Regler', $einstell_lines);
$output .= "<p><b>Regler:</b>$regler</p>";

$index = get_value('Index', $einstell_lines);
$output .= "<p><b>Index:</b>$index</p>";
var_dump(get_einstellwerte($einstell_lines));
draw_page($output, $title, $author, LAYOUT);
?>