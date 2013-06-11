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

include_once('settings.php');
include_once('templates.php');
include_once('file.php');
include_once('page.php');

$title = 'Aufzeichnungen verwalten';
$author = 'Max Bruckner, Andreas Bruckner';
$heading = 'Aufzeichnungen verwalten';

$return = 'logs.php';

$file_list = "<table>\n";
foreach( get_files($settings['ordner_log']) as $file ) {
    $file_list .= get_link_logs($file, $settings['ordner_log'], $return, $return) . "\n";
}
$file_list .= '</table>';

$output = get_heading($heading);
$output .= get_container($file_list,'460px');
$output .= get_button_menu_back();
draw_page($output, $title, $author, HEAD);
?>
