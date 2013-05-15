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
include_once('file.php');

$comment = $_POST['comment'];
$regler = $_POST['regler'];
$index = $_POST['index'];
$data = $_POST['data'];
$mode = $_POST['mode'];
$filename = $_POST['filename'];

function write_csv($filename, $comment, $regler, $index, $einstellwerte, $take_trenn, $take_comment, $take_other) {
    global $settings;
    $first_value = false;       //Wurde schon der erste Wert geschrieben?
    $output = "$comment";
    $output .= "Regler,$regler\n";
    $output .= "Index,$index\n";
    foreach( $einstellwerte as $einstellwert) {
        switch($einstellwert['type']) {
            case 'value':
                $first_value = true;
                $output .= "{$einstellwert['id']},{$einstellwert['value']},{$einstellwert['min']},{$einstellwert['max']},{$einstellwert['text']}\n";
                break;
            case 'trenn':
                if( $take_trenn )
                    $output .= "*\n";
                break;
            case 'comment':
                if( $take_comment )
                    $output .= "{$einstellwert['line']}\n";
                break;
            case 'other':
                if( $take_other && $first_value )
                    $output .= "{$einstellwert['line']}\n";
        }
    }
    rtrim($output);    //Leerzeilen am Ende entfernen
    $filename = correct_filename($filename, 'csv');
    return file_put_contents("{$settings['ordner_einstellwert']}/$filename", $output);
}

switch($mode) {
    //TODO richtige Texte einfügen
    case 'read':
        $title = 'read';
        break;
    case 'write':
        $title = 'write';
        break;
    case 'write_save':
        $title = 'write_save';
        break;
    case 'save':
        $title = 'save';
        break;
}
$author = 'Max Bruckner';

write_csv('write.csv', $comment, $regler, $index, $data, true, true, true);
$output = nl2br(file_get_contents("{$settings['ordner_einstellwert']}/write.csv"));
draw_page($output, $title, $author, NAKED);
?>