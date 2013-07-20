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
 *          'value': Istwert
 *          'skal': Skalierungsfaktor
 *          'komma': Anzahl der Anzuzeigenden Kommastellen
 *          'text': Beschreibungstext zum Einstellwert
 *          'checked': Boolean, ob das Häkchen im Webinterface gesetzt wurde
 * */

include_once('settings.php');
include_once('page.php');
include_once('templates.php');
include_once('csv.php');
include_once('tty.php');
include_once('file.php');

function get_form_einstell_alt($comment, $regler, $index, $einstellwerte, $filename) {
    $template_form_einstell = file_get_contents('template_form_einstell_alt.html');

    $output = str_replace('{comment}', $comment, $template_form_einstell);
    $output = str_replace('{regler}', $regler, $output);
    $output = str_replace('{index}',$index, $output);
    $output = str_replace('{einstellwerte}', $einstellwerte, $output);
    $output = str_replace('{filename}', $filename, $output);
    return $output;
}


$title = 'Einstellwerte';
$author = 'Max Bruckner';
$heading = 'Einstellwerte';

$filename = $_GET['filename'];
$info = $_GET['info'];


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
            if( (count($split) == 5) && (strlen($split[0]) <= 3)  && is_numeric($split[0]) ) {    //Einstellwert?
                $einstellwerte[$i]['type'] = 'value';

                $einstellwerte[$i]['id'] = $split[0];
                $einstellwerte[$i]['value'] = number_format($split[1], $split[3], '.','');
                $einstellwerte[$i]['skal'] = (double) $split[2];
                $einstellwerte[$i]['komma'] = $split[3];
                $einstellwerte[$i]['text'] = $split[4];
            }
        }

        $i++;
    }
    return $einstellwerte;
}

//Liste der Einstellwerte
function get_list($einstellwerte) {
    $output = '<tr><td></td><td><b>S-Index</b></td><td><b>Beschreibung</b></td><td><b>Soll</b></td><td><b>Teiler</b></td><td><b>KS</b></td></tr>';
    for($i = 0; $i < count($einstellwerte); $i++) {
        switch($einstellwerte[$i]['type']) {
            case 'value':
                $form = get_form_einstellzeile($i, $einstellwerte[$i]['line'], $einstellwerte[$i]['type']);
                $output .= get_einstellzeile(
                                $i,
                                $form,
                                $einstellwerte[$i]['id'],
                                $einstellwerte[$i]['value'],
                                $einstellwerte[$i]['skal'],
                                $einstellwerte[$i]['komma'],
                                $einstellwerte[$i]['text']);
                break;
            case 'trenn':
                $output .= get_form_einstellzeile($i, $einstellwerte[$i]['line'], $einstellwerte[$i]['type']);
                $output .= get_einstellzeile_trenn();
                break;
            case 'comment':
                $output .= get_form_einstellzeile($i, $einstellwerte[$i]['line'], $einstellwerte[$i]['type']);
                break;
            case 'other':
                $output .= get_form_einstellzeile($i, $einstellwerte[$i]['line'], $einstellwerte[$i]['type']);
                break;
        }
    }
    return $output;
}




$einstell_lines = file("{$settings['ordner_einstell-mess']}/$filename", FILE_IGNORE_NEW_LINES);

$comment = get_comment($einstell_lines);
$regler = get_value('Regler', $einstell_lines);
$index = get_value('Index', $einstell_lines);
$einstellwerte = get_einstellwerte($einstell_lines);
$einstell_list = get_list($einstellwerte);


$output = '</br> ';
$output .= get_form_einstell_alt($comment, $regler, $index, $einstell_list, $filename);
$output .= '</br>';
$output .= '<a href="index.php"><h3>Zum Hauptmenü</h3></a>';

draw_page($output, $title, $author, HEAD);
?>
