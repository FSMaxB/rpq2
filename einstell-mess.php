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
include_once('settings.php');
include_once('page.php');
include_once('templates.php');
include_once('file.php');

$title = 'Einstell-/Messwerttabellen verwalten';
$author = 'Max Bruckner';
$heading = 'Einstell-/Messwerttabellen verwalten';


$return = 'einstell-mess.php';
$extension = '';

//Dateiliste erstellen:
$einstell_list = '<table>';
foreach ( get_files($settings['ordner_einstell-mess']) as $file ) {
    $split = explode('.', $file);
    if(end($split) !== 'mw') {
        $einstell_list .= get_link_einstell($settings['ordner_einstell-mess'], $file, $return, $return);
    }
}
$einstell_list .= '</table>';

$mess_list = '<table>';
foreach ( get_files($settings['ordner_einstell-mess']) as $file ) {
    $split = explode('.', $file);
    if(end($split) === 'mw') {
        $mess_list .= get_link_mess($settings['ordner_einstell-mess'], $file, $return, $return);
    }
}
$mess_list .= '</table>';
$output = '</br>';
//$output = get_heading($heading);
$output .= get_form_upload($settings['ordner_einstell-mess'], $extension, $return, $return);

$output .= '<br><b>Einstellwerte:</b></br>';
$output .= get_container($einstell_list, "315px");
$output .= '<b>Messwerte:</b></br>';
$output .= get_container($mess_list, "100px");
//$output .= '</br>';
$output .= get_button_inline("editor.php?ordner={$settings['ordner_einstell-mess']}&return=einstell-mess.php", '<b>Neue Datei</b>');
$output .= '</br>';
$output .= '</br>';
$output .= get_button_inline('index.php', '<b>Zum Hauptmenü</b>');
$output .= ' ';
$output .= get_button_inline('sollwert.php', '<b>Sollwerte</b>');
$output .= ' ';
$output .= get_button_inline('pdo_mapping.php', '<b>PDO Mapping</b>');
$output .= ' ';
$output .= get_button_inline('wartung.php', '<b>Manuelle Geräteeinstellung</b>');
draw_page($output, $title, $author, HEAD);
?>
