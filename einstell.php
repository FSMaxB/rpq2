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

/*
 * Allgemeiner Hinweis:
 * Die eingelesene CSV-Datei wird in einem Array folgender Form übergeben:
 *  $einstellwerte[Zeilennummer][Name] = Wert;
 *      Zeilennummer: Nummer der Zeile in der CSV-Datei beginnend mit 0
 *      Name: Einer der Folgenden
 *          'line': Enthält die Ursprüngliche Zeile
 *          'type': Art des Zeileninhalts, eins von 'value', 'comment', 'trenn' und 'other'
 *          'id': Subindex
 *          'value': Einstellwert
 *          'min', 'max': Minimal- und Maximalwert
 *          'text': Beschreibungstext zum Einstellwert
 *          'checked': Boolean, ob das Häkchen im Webinterface gesetzt wurde
 * */

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
        $einstellwerte[$i]['type'] = 'other';

        if( strpos($line, '#') === 0 ) {    //Kommentarzeile?
            $einstellwerte[$i]['type'] = 'comment';
        } else if( strpos($line, '*') === 0 ) { //Trennzeile?
            $einstellwerte[$i]['type'] = 'trenn';
        } else {
            $split = explode(',', $line);
            if( (count($split) == 5) && (strlen($split[0]) <= 2)  && ctype_xdigit($split[0]) ) {    //Einstellwert? ctype_xdigit: prüft auf hex
                $einstellwerte[$i]['type'] = 'value';

                $einstellwerte[$i]['id'] = $split[0];
                $einstellwerte[$i]['value'] = $split[1];
                $einstellwerte[$i]['min'] = $split[2];
                $einstellwerte[$i]['max'] = $split[3];
                $einstellwerte[$i]['text'] = $split[4];
            }
        }

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