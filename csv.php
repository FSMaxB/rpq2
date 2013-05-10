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
    
    --------------------csv.php------------------------------------
    Stellt das Menü CSV-Sollwerttabellen dar.
*/

include_once('settings.php');
include_once('page.php');
include_once('file_list.php');
include_once('templates.php');

$title = 'CSV-Sollwerttabellen';
$author = 'Max Bruckner';
$heading = 'CSV-Sollwerttabellen';


$return = 'csv.php';
$extension = 'csv';

//Dateiliste erstellen:
foreach ( get_files($ordner_sollwert) as $file ) {
	$file_list .= get_link_csv("$ordner_sollwert/$file", $file, $return);
}

$output = get_heading($heading);
$output .= get_form_upload($ordner_sollwert, $extension, $return, $return);
$output .= get_container($file_list);
$output .= get_button('index.php', 'Zum Hauptmenü');

draw_page($output, $title, $author, LAYOUT);
?>
