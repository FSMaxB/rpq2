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
include_once('templates.php');
include_once('file.php');
include_once('page.php');


$title = 'Dokumentationen';
$author = 'Max Bruckner';
$heading = 'Dokumentationen';

//Dateiliste erstellen:
$file_list = '<table>';
foreach ( get_files($settings['ordner_docs']) as $file ) {
    $file_list .= get_template('link_docs', array('directory' => $settings['ordner_docs'], 'filename' => $file, 'return_success' => $return, 'return_failure' => $return));
}
$file_list .= '</table>';

$output = get_template('heading', array('heading' => $heading));
$output .= get_template('form_upload', array('directory' => $settings['ordner_docs'], 'extension' => '', 'return_success' => $return, 'return_failure' => $return));
$output .= get_template('container', array('content' => $file_list, 'height' => '260px', 'border' => DEFAULT_CONTAINER_BORDER, 'id' => DEFAULT_CONTAINER_ID));
$output .= '<a href="index.php"><h3>Zum Hauptmenü</h3></a>';
draw_page($output, $title, $author, HEAD);
?>
