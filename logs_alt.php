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

$title = 'Aufzeichnungen verwalten';
$author = 'Max Bruckner';
$heading = 'Aufzeichnungen verwalten';

$file_list = "<table>\n";
foreach( get_files($settings['ordner_log']) as $file ) {
    $file_list .= get_template('link_logs', array('directory' => $settings['ordner_log'], 'filename' => $file, 'return_success' => $return, 'return_failure' => $return)) . "\n";
}
$file_list .= '</table>';

$output = get_template('heading', array('heading' => $heading));
$output .= get_template('container', array('content' => $file_list, 'height' => '260px', 'border' => DEFAULT_CONTAINER_BORDER, 'id' => DEFAULT_CONTAINER_ID));
$output .= '<a href="index.php"><h3>Zurück</h3></a>';
draw_page($output, $title, $author, HEAD);
?>
