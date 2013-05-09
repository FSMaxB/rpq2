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

include('settings.php');
include('page.php');
include('file_list.php');

$title = 'Dokumentationen';
$author = 'Max Bruckner';
$heading = 'Dokumentationen';

$template_button = file_get_contents('template_button.html');
$template_heading = file_get_contents('template_heading.html');
$template_container = file_get_contents('template_container.html');

$file_list = '';

foreach ( get_files($ordner_docs) as $file) {
	$button = str_replace('{link}', "$ordner_docs/$file", $template_button);
	$button = str_replace('{text}', $file, $button);
	$file_list .= $button;
}

$output = str_replace('{heading}', $heading, $template_heading);
$output .= $file_list;
$button = str_replace('{link}', 'index.php', $template_button);
$button = str_replace('{text}', 'Zum Hauptmenü', $button);
$output .= $button;

draw_page($output, $title, $author, LAYOUT);
?>
