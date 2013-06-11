<?php
/*
    RPQ2-Webinterface

    Copyright (C) 2012-2013 Innowatt Energiesysteme GmbH
    Author: Max Bruckner, Andreas Bruckner

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

include_once('page.php');
include_once('settings.php');
include_once('templates.php');
include_once('file.php');
include_once('tty.php');

$comment = NULL;

function send($send) {
    global $settings;

    $received = NULL;
    $befehl = NULL;

    exec("nativ/einstell wartung {$settings['serial_interface']} $send", $results);

    foreach ( $results as $result ) {
         $received .= "$result\n";
    }
    return $received;
}

function get_file_list() {
    global $settings;

    $file_list = '<table>';
    foreach( get_files($settings['ordner_pdo']) as $file ) {
        $file_list .= get_link_pdo($file, $settings['ordner_pdo'], 'pdo_mapping.php', 'pdo_mapping.php');
    }
    $file_list .= '</table>';
    return $file_list;
}

$title = 'PDO Mapping';
$author = 'Max Bruckner, Andreas Bruckner';
$heading = 'PDO Mapping';

$filename = $_GET['filename'];

$regler = $_POST['regler'];
$wert = $_POST['wert'];
$mode = $_POST['mode'];

$map_high = $_POST['map_high'];
$map_low = $_POST['map_low'];
$map_index = $_POST['map_index'];
$mapped_high = $_POST['mapped_high'];
$mapped_low = $_POST['mapped_low'];
$mapped_index = $_POST['mapped_low'];

function read_file($lines) {
    global $comment, $regler, $map_high, $map_low, $map_index, $mapped_high, $mapped_low, $mapped_index;
    foreach($lines as $line) {
        if(strpos($line, '#') === 0) {
            $comment .= substr($line, 1);
        } else if(strpos($line, 'Regler') === 0) {
            $split = explode(',', $line);
            $regler = $split[1];
        } else {
            $split = explode(',', $line);
            if((count($split) == 4) && (strlen($split[0]) == 4) && (strlen($split[1]) <= 2) && (strlen($split[2]) == 4) && (strlen($split[3]) <= 2)) {
                $map_high = substr($split[0], 0, 2);
                $map_low = substr($split[0], 2, 2);
                $map_index = $split[1];
                $mapped_high = substr($split[2], 0, 2);
                $mapped_low = substr($split[2], 2, 2);
                $mapped_index = $split[3];
            }
        }
    }
}

set_tty();

if($filename != '') {
    $lines = file("{$settings['ordner_pdo']}/$filename", FILE_IGNORE_NEW_LINES);
    read_file($lines);
} else if($regler != '') {
    $command = 0x0600 + $regler;

    $command = hex($command, 4);
    if ($mode == 'write') {
        $command .= '23' . $map_low . $map_high . $map_index .'10';
        $command .= $mapped_low . $mapped_high . $mapped_index .'8000';
    } else {
        $command .= '40' . $map_low . $map_high . $map_index;
        $command .= '000000008000';
    }

    $received = send($command);
 }

$file_list = get_file_list();

$output = get_heading($heading);
$output .= get_form_upload($settings['ordner_pdo'], '', 'pdo_mapping.php', 'pdo_mapping.php');
$output .= get_newline();
$output .= get_container($file_list, '330px');
$output .= get_pdo_mapping($comment, $received, $command, $regler, $map_high, $map_low, $map_index, $mapped_high, $mapped_low, $mapped_index);
$output .= get_newline();
$output .= get_newline();
$output .= get_button_inline('index.php', '<b>Zum Hauptmenü</b>');
$output .= ' ';
$output .= get_button_inline('wartung.php', '<b>Zurück</b>');
draw_page( $output, $title, $author, HEAD);
?>
