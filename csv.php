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

include('settings.php');
include('page.php');
include('upload_form.php');
include('file_list.php');

$title = 'CSV-Sollwerttabellen';
$author = 'Max Bruckner';
$heading = 'CSV-Sollwerttabellen';

$file_list = '';

$template_link_csv = file_get_contents('template_link_csv.html');
$template_container = file_get_contents('template_container.html');
$template_heading = file_get_contents('template_heading.html');
$template_button = file_get_contents('template_button.html');

$return = 'csv.php';
$extension = 'csv';
//Dateiliste erstellen:
foreach ( get_files($ordner_sollwert) as $file ) {
	$link = str_replace('{ordner}', $ordner_sollwert, $template_link_csv);
	$link = str_replace('{dateiname}', $file, $link);
	$link = str_replace('{return}', $return, $link);
	
	$file_list .= $link;
}

$output = str_replace('{heading}', $heading, $template_heading);
$output .= upload_form($ordner_sollwert, $extension, $return, $return);
$output .= str_replace('{content}', $file_list, $template_container);
$button = str_replace('{link}', 'index.php', $template_button);
$button = str_replace('{text}', 'Zum Hauptmenü', $button);
$output .= $button;

draw_page($output, $title, $author, LAYOUT);
?>
