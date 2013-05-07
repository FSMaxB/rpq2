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

include('page.php');
include('settings.php');

$title = 'Wartung';
$author = 'Max Bruckner';
$heading = 'Wartung';

$send = $_POST['send'];

$template_heading = file_get_contents('template_heading.html');
$template_wartung = file_get_contents('template_wartung.html');
$template_button = file_get_contents('template_button.html');
$output = str_replace('{heading}', $heading, $template_heading);
$output .= $template_wartung;

if( $send != '') {
	exec("nativ/einstell wartung $serial_interface $send", $results);
	
	foreach ( $results as $result ) {
		$received .= $result;
	}
}

$output = str_replace('{received}', $received, $output);
$output .= str_replace('{link}', 'index.php', $template_button);
$output = str_replace('{text}', 'Zum Hauptmenü', $output);

draw_page( $output, $title, $author, LAYOUT);
?>
