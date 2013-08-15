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

include_once('meta.php');
include_once('page.php');

$title = 'System herunterfahren';
$author = 'Max Bruckner';

$mode = $_GET['mode'];

if($mode == 'reboot') {
    $param = '-r';
    $output = '<h1>Das System wird neu gestartet!</h1>';
} else if($mode == 'halt') {
    $param = '-h';
    $output = '<h1>Das System wird heruntergefahren</h1>';
    $output .= '<br>';
    $output .= '<h1>Zum Neustart Spannung am Webinterface weg nehmen</h1>';
     $output .= '<h1>und nach einigen Sekunden wieder einschalten</h1>';
} else {
    $output = '<h1>Ungültiger Parameter</h1>';
    $output .= get_template('button', array('link' => 'index.php', 'text' => '<b>Zum Hauptmenü</b>'));
    draw_page($output, $title, $author, LAYOUT);
    exit(0);
}

system("/sbin/shutdown $param now");

draw_page($output, $title, $author, HEAD);
?>
