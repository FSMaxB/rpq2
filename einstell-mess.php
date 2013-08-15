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

include_once('meta.php');
include_once('defaults.php');
include_once('settings.php');
include_once('page.php');
include_once('templates.php');
include_once('file.php');

$title = 'Einstell-/Messwerttabellen verwalten';
$author = 'Max Bruckner';
$heading = 'Einstell-/Messwerttabellen verwalten';

$extension = '';

//Dateiliste erstellen:
$einstell_list = '<table>';
foreach ( get_files($settings['ordner_einstell-mess']) as $file ) {
    $split = explode('.', $file);
    if(end($split) !== 'mw') {
        $einstell_list .= get_template('link_einstell', array('directory' => $settings['ordner_einstell-mess'], 'filename' => $file, 'return_success' => $return, 'return_failure' => $return));
    }
}
$einstell_list .= '</table>';

$mess_list = '<table>';
foreach ( get_files($settings['ordner_einstell-mess']) as $file ) {
    $split = explode('.', $file);
    if(end($split) === 'mw') {
        $mess_list .= get_template('link_mess', array('directory' => $settings['ordner_einstell-mess'], 'filename' => $file, 'return_success' => $return, 'return_failure' => $return));
    }
}
$mess_list .= '</table>';
$output = '</br>';
//$output = get_template('heading', array('heading' => $heading));
$output .= get_template('form_upload', array('directory' => $settings['ordner_einstell-mess'], 'extension' => $extension, 'return_success' => $return, 'return_failure' => $return));
$output .= '<br><b>Einstellwerte:</b></br>';
$output .= get_template('container', array('content' => $einstell_list, 'height' => '315px', 'border' => DEFAULT_CONTAINER_BORDER, 'id' => DEFAULT_CONTAINER_ID));
$output .= '<b>Messwerte:</b></br>';
$output .= get_template('container', array('content' => $mess_list, 'height' => '100px', 'border' => DEFAULT_CONTAINER_BORDER, 'id' => DEFAULT_CONTAINER_ID));
//$output .= '</br>';
$output .= get_template('button_inline', array('link' => "editor.php?ordner={$settings['ordner_einstell-mess']}&return=einstell-mess.php", 'text' => '<b>Neue Datei</b>'));
$output .= '</br>';
$output .= '</br>';
$output .= get_template('button_inline', array('link' => "index.php", 'text' => '<b>Zum Hauptmenü</b>'));
$output .= ' ';
$output .= get_template('button_inline', array('link' => "sollwert.php", 'text' => '<b>Sollwerte</b>'));
$output .= ' ';
$output .= get_template('button_inline', array('link' => "pdo_mapping.php", 'text' => '<b>PDO Mapping</b>'));
$output .= ' ';
$output .= get_template('button_inline', array('link' => "wartung.php", 'text' => '<b>Manuelle Geräteeinstellung</b>'));
draw_page($output, $title, $author, HEAD);
?>
