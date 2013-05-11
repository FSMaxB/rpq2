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

include_once('page.php');

$title = 'System herunterfahren';
$author = 'Max Bruckner';

$mode = $_GET['mode'];

if($mode == 'reboot') {
	$param = '-r';
	$output = '<h1>Das System wird neu gestartet!</h1>';
} else if($status == 'halt') {
	$param = '-h';
	$output = '<h1>Das System wird heruntergefahren</h1>';
} else {
	$output = '<h1>Ungültiger Parameter</h1>';
	$output .= get_button('index.php', 'Zum Hauptmenü');
	draw_page($output, $title, $author, LAYOUT);
	exit(0);
}

system("/sbin/shutdown $param now");

draw_page($output, $title, $author, LAYOUT);
?>
