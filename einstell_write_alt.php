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

$author = 'Max Bruckner';

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
    $output = $comment;
    $output .= "Regler,$regler\n";
    $output .= "Index,$index\n";
    foreach( $einstellwerte as $einstellwert) {
        switch($einstellwert['type']) {
            case 'value':
                if( $einstellwert['checked'] === 'true') {
                    $first_value = true;
                    $Zahl = $einstellwert['value'];
 
					$value = number_format($Zahl, $einstellwert['komma'], '.', '');
                    $output .= "{$einstellwert['id']},$value,{$einstellwert['skal']},{$einstellwert['komma']},{$einstellwert['text']}\n";
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
    $filename = correct_filename($filename, '');
    return file_put_contents("{$settings['ordner_einstell-mess']}/$filename", $output);
}

function run($mode, $file_send, $file_receive = '') {
    global $settings;

    $outputs = NULL;
    switch($mode) {
        case 'read':
            $result = exec("nativ/einstell read {$settings['serial_interface']} {$settings['ordner_einstell-mess']}/$file_send  {$settings['ordner_einstell-mess']}/$file_receive", $outputs);
            break;
        case 'write':
            $result = exec("nativ/einstell write {$settings['serial_interface']} {$settings['ordner_einstell-mess']}/$file_send", $outputs);
            break;
    }

    $result = NULL;
    foreach( $outputs as $output) {
        $result .= "$output\n";
    }

    return $result;
}

function get_output($return, $text_success, $file_success, $text_fail, $file_fail) {
    global $header; //Das ist etwas gegen mein Konzept
    if( (strpos($return, 'FEHLER') !== FALSE) ) {
            $output = get_failure($text_fail);
            $header = get_redirect(3, "einstell_alt.php?filename=$file_fail");
        } else {
 //           $output = get_success($text_success);
            $header = get_redirect(0, "einstell_alt.php?filename=$file_success");
        }
    return $output;
}

set_tty();

switch($mode) {
    //TODO vervollständigen
    case 'read':
        $title = 'Einstellwerte lesen';
        write_csv('send.ew', $comment, $regler, $index, $data, false, false, false);
        $return = run('read', 'send.ew', 'receive.ew');
        $output = get_output($return, '</br>Einstellwerte erfolgreich ausgelesen', 'receive.ew', nl2br($return), 'send.ew');
        break;

    case 'write':
        $title = 'Einstellwerte schreiben';
        write_csv('send.ew', $comment, $regler, $index, $data, false, false, false);
        $return = run('write', 'send.ew');
        
        $output = get_output($return, '</br>Einstellwerte erfolgreich geschrieben', 'send.ew', nl2br($return), 'send.ew');
        break;

    case 'write_save':
        $title = 'Einstellwerte schreiben und speichern';
        write_csv('send.ew', $comment, $regler, $index, $data, false, false, false);
        $return = run('write', 'send.ew');
        
        if(write_csv($filename, $comment, $regler, $index, $data, $take_trenn, $take_comments, false)) {
            $output = get_output($return, '</br>Einstellwerte erfolgreich geschrieben und gespeichert', $filename, nl2br($return), 'send.ew');
        } else {
            $output = get_failure('</br>Speichern der Einstellwerte fehlgeschlagen!');
            $output .= get_button_menu_back();
        }
        break;

    case 'save':
        $title = 'save';
        if(write_csv($filename, $comment, $regler, $index, $data, $take_trenn, $take_comment, false)) {
 //           $output = get_success('</br>Einstellwerte erfolgreich gespeichert');
            $header = get_redirect(0, "einstell_alt.php?filename=$filename");
        } else {
            $output = get_failure('</br>Beim Speichern der Einstellwerte ist ein Fehler aufgetreten');
            $header = get_redirect(3, "index.php");
        }
        break;
}

draw_page($output, $title, $author, NAKED, $header);
?>
