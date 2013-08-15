<?php
/*
    RPQ2-Webinterface

    Copyright (C) 2012-2013 Innowatt Energiesysteme GmbH
    Author: Max Bruckner
            Andreas Bruckner

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

function get_link_einstell_Neu($ordner, $filename, $return_success, $return_failure) {
    $template_link_einstell = file_get_contents('template_link_einstell_alt.html');

    $output = str_replace('{ordner}', $ordner, $template_link_einstell);
    $output = str_replace('{filename}', $filename, $output);
    $output = str_replace('{return_success}', $return_success, $output);
    $output = str_replace('{return_failure}', $return_failure, $output);
    return $output;
}

function get_link_mess_Neu($ordner, $filename, $return_success, $return_failure) {
    $template_link_mess = file_get_contents('template_link_mess_alt.html');

    $output = str_replace('{ordner}', $ordner, $template_link_mess);
    $output = str_replace('{filename}', $filename, $output);
    $output = str_replace('{return_success}', $return_success, $output);
    $output = str_replace('{return_failure}', $return_failure, $output);
    return $output;
}


$title = 'Einstell-/Messwerttabellen verwalten';
$author = 'Max Bruckner';
$heading = 'Einstell-/Messwerttabellen verwalten';


$return = 'einstell-mess_alt.php';
$extension = '';

//Dateiliste erstellen:
$einstell_list = '<table>';
foreach ( get_files($settings['ordner_einstell-mess']) as $file ) {
    $split = explode('.', $file);
    if(end($split) !== 'mw') {
        $einstell_list .= get_template('link_einstell_alt', array('directory' => $settings['ordner_einstell-mess'], 'filename' => $file, 'return_success' => $return, 'return_failure' => $return));
    }
}
$einstell_list .= '</table>';

$mess_list = '<table>';
foreach ( get_files($settings['ordner_einstell-mess']) as $file ) {
    $split = explode('.', $file);
    if(end($split) === 'mw') {
        $mess_list .= get_template('link_mess_alt', array('directory' => $settings['ordner_einstell-mess'], 'filename' => $file, 'return_success' => $return, 'return_failure' => $return));
    }
}
$mess_list .= '</table>';
$output = '<br>';
//$output = get_template('heading', array('heading' => $heading));
$output .= get_template('form_upload', array('directory' => $settings['ordner_einstell-mess'], 'extension' => $extension, 'return_success' => $return, 'return_failure' => $return));
$output .= '<br><b>Einstellwerte:</b></br>';
$output .= get_template('container', array('content' => $einstell_list, 'height' => '214px', 'border' => DEFAULT_CONTAINER_BORDER, 'id' => DEFAULT_CONTAINER_ID));
$output .= '<br><b>Messwerte:</b></br>';
$output .= get_template('container', array('content' => $mess_list, 'height' => '50px', 'border' => DEFAULT_CONTAINER_BORDER, 'id' => DEFAULT_CONTAINER_ID));
$output .= '<br>';
$output .= '<br>';
$output .= '<a href="index.php"><h3>Zum Hauptmenü</h3></a>';
draw_page($output, $title, $author, HEAD);
?>
