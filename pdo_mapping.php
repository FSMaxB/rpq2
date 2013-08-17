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

include_once('meta.php');
include_once('profiles.php');
include_once('defaults.php');
include_once('page.php');
include_once('settings.php');
include_once('templates.php');
include_once('file.php');
include_once('tty.php');
include_once('glob_function.php');

$comment = NULL;



function get_file_list() {
    global $settings, $meta_current;

    $file_list = '<table>';
    foreach( get_files($settings['ordner_pdo']) as $file ) {
        $file_list .= get_template('link_pdo', array('directory' => $settings['ordner_pdo'], 'filename' => $file, 'return_success' => $meta_current, 'return_failure' => $meta_current));
    }
    $file_list .= '</table>';
    return $file_list;
}

$title = 'PDO Mapping';
$author = 'Andreas Bruckner';
$heading = '<b>PDO Mapping</b>';

$filename = $_GET['filename'];

$regler = $_POST['regler'];
$mode = $_POST['mode'];

$map_high = $_POST['map_high'];
$map_low = $_POST['map_low'];
$map_index = $_POST['map_index'];
$mapped_high = $_POST['mapped_high'];
$mapped_low = $_POST['mapped_low'];
$mapped_index = $_POST['mapped_index'];

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
    $Vergleich =  0x0580 + $regler;
    $Vergleich = hex($Vergleich,4);
    $command = hex($command, 4) . ' ';
    if ($mode == 'write') {
        $command .= '23 ' .  $map_low . $map_high . ' ' . $map_index . ' ' . '-' .' 10 ';
        $command .= $mapped_index . ' ' . $mapped_low . $mapped_high . ' 8000';
    } else {
        $command .= '40 ' . $map_low . $map_high . ' ' . $map_index;
        $command .= ' - 00 00 00 00 8000';
    }
    $temp = ereg_replace("-","",$command);
    $temp = ereg_replace(" ","",$temp);
    $received = send($temp);
    $temp = substr($received,0,3) . ' ';
    $temp .= substr($received,3,4) . ' ';
    $temp .= substr($received,7,2) . ' ';
    $temp .= substr($received,9,4) . ' ';
    $temp .= substr($received,13,2) . ' ';

    $temp .= substr($received,15,2) . ' ';

    if ($mode == 'write')
    {
        $temp .= substr($received,17,2) . ' ';
        $temp .= substr($received,19,2) . ' ';
        $temp .= substr($received,21,2);
    }
    else
    {
        $mapped_index = substr($received,17,2);
        $temp .= $mapped_index . ' ';
        $mapped_low = substr($received,19,2);
        $temp .= $mapped_low . ' ';
        $mapped_high = substr($received,21,2);
        $temp .= $mapped_high;
    }
    $received = $temp;
    $comment =  substr($received,4,4);
    if ($Vergleich == $comment)
        $comment = get_template('success', array('text' => ' Übertragung erfolgreich !'));
    else
        $comment = get_template('failure', array('text' => ' Fehler Übertragung !'));
 }

$file_list = get_file_list();

//$output = get_template('heading', array('heading' => $heading));
$output = '</br> ';
$output .= get_template('form_upload', array('directory' => $settings['ordner_pdo'], 'extension' => '', 'return_success' => $meta_current, 'return_failure' => $meta_current));
$output .= '</br> ';
$output .= get_template('container', array('content' => $file_list, 'height' => '200px', 'border' => DEFAULT_CONTAINER_BORDER, 'id' => DEFAULT_CONTAINER_ID));
$output .= '</br> ';
$output .= get_template('pdo_mapping', array(
                        'comment' => $comment,
                        'received' => $received,
                        'command' => $command,
                        'regler' => $regler,
                        'map_high' => $map_high,
                        'map_low' => $map_low,
                        'map_index' => $mapped_high,
                        'mapped_high' => $mapped_high,
                        'mapped_low' => $mapped_low,
                        'mapped_index' => $mapped_index));
$output .= get_references(array('index', 'einstell-mess', 'mess', 'wartung'));
draw_page( $output, $title, $author, HEAD);
?>
