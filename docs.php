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

    --------------------docs.php-------------------------------------
    Zeigt die verfügbaren Dokumentationen an. (Listet alle Dateien
    aus dem Ordner mit den Dokumentationen).
*/

include_once('settings.php');
include_once('page.php');
include_once('file.php');
include_once('templates.php');

$title = 'Dokumentationen';
$author = 'Max Bruckner';
$heading = 'Dokumentationen';

$file_list = '';
foreach ( get_files($settings['ordner_docs']) as $file) {
    $file_list .= get_button("{$settings['ordner_docs']}/$file", $file);
}

$output = get_heading($heading);
$output .= $file_list;
$output .= get_button_menu_back();

draw_page($output, $title, $author, LAYOUT);
?>