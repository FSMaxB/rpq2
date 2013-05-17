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
$take_trenn = ($_POST['take_trenn'] === 'true');
$take_comments = ($_POST['take_comments'] === 'true');

function write_csv($filename, $comment, $regler, $index, $einstellwerte, $take_trenn, $take_comment, $take_other) {
    global $settings;
    $first_value = false;       //Wurde schon der erste Wert geschrieben?
    $output = "$comment";
    $output .= "Regler,$regler\n";
    $output .= "Index,$index\n";
    foreach( $einstellwerte as $einstellwert) {
        switch($einstellwert['type']) {
            case 'value':
                if( $einstellwert['checked'] === 'true') {
                    $first_value = true;
                    $output .= "{$einstellwert['id']},{$einstellwert['value']},{$einstellwert['min']},{$einstellwert['max']},{$einstellwert['text']}\n";
                }
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

function run($mode, $file_send, $file_receive = '') {
    global $settings;

    $outputs = NULL;
    switch($mode) {
        case 'read':
            $result = exec("nativ/einstell read {$settings['serial_interface']} {$settings['ordner_einstellwert']}/$file_send  {$settings['ordner_einstellwert']}/$file_receive", $outputs);
            break;
        case 'write':
            $result = exec("nativ/einstell write {$settings['serial_interface']} {$settings['ordner_einstellwert']}/$file_send", $outputs);
            break;
    }

    $result = NULL;
    foreach( $outputs as $output) {
        $result .= "$output\n";
    }

    return $result;
}

function get_output($return, $text_success, $file_success, $text_fail, $file_fail) {
    if( (strpos($return, 'FEHLER') !== FALSE) ) {
            $output = get_failure($text_fail);
            $output .= get_button("einstell.php?filename=$file_fail", 'Weiter');
        } else {
            $output = get_success($text_success);
            $output .= get_button("einstell.php?filename=$file_success", 'Weiter');
        }
    return $output;
}

set_tty();

switch($mode) {
    //TODO vervollständigen
    case 'read':
        $title = 'Einstellwerte lesen';
        write_csv('send.csv', $comment, $regler, $index, $data, false, false, false);
        $return = run('read', 'send.csv', 'receive.csv');
        $output = get_output($return, 'Einstellwerte erfolgreich ausgelesen', 'receive.csv', nl2br($return), 'send.csv');
        break;

    case 'write':
        $title = 'Einstellwerte schreiben';
        write_csv('send.csv', $comment, $regler, $index, $data, false, false, false);
        $return = run('write', 'send.csv');
        $output = get_output($return, 'Einstellwerte erfolgreich geschrieben', 'send.csv', nl2br($return), 'send.csv');
        break;

    case 'write_save':
        $title = 'Einstellwerte schreiben und speichern';
        write_csv('send.csv', $comment, $regler, $index, $data, false, false, false);
        $return = run('write', 'send.csv');
        if(write_csv($filename, $comment, $regler, $index, $data, $take_trenn, $take_comments, false)) {
            $output = get_output($return, 'Einstellwerte erfolgreich geschrieben und gespeichert', $filename, nl2br($return), 'send.csv');
        } else {
            $output = get_failure('Speichern der Einstellwerte fehlgeschlagen!');
            $output .= get_button_menu_back();
        }
        break;

    case 'save':
        $title = 'save';
        if(write_csv($filename, $comment, $regler, $index, $data, $take_trenn, $take_comment, false)) {
            $output = get_success('Einstellwerte erfolgreich gespeichert');
            $output .= get_button("einstell.php?filename=$filename", 'Weiter');
        } else {
            $output = get_failure('Beim Speichern der Einstellwerte ist ein Fehler aufgetreten');
            $output .= get_button_menu_back();
        }
        break;
}
$author = 'Max Bruckner';
draw_page($output, $title, $author, NAKED);
?>