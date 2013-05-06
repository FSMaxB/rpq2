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

define('RAW', false);		//Verwende leere Seite
define('LAYOUT', true);		//Verwende Layout

include('settings.php');

function draw_page( $content, $title, $author, $type, $header = '') {
	$page = file_get_contents('template_page.html');
	$layout = file_get_contents('template_layout.html');
	
	$output = str_replace('{header}', $header, $output);
	$output = str_replace('{title}', $title, $output);
	$output = str_replace('{author}', $author, $output);
	
	if( $type == LAYOUT ) {
		$output = str_replace('{content}', $layout, $output);
	}
	
	$output = str_replace('{content}', $content, $output);
	
	echo $output;
}
?>
