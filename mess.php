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
include_once('profiles.php');
include_once('page.php');
include_once('settings.php');
include_once('templates.php');
include_once('csv.php');
include_once('tty.php');




set_tty();

$heading = 'Messwerte Regler';
$author = 'Max Bruckner';
$title = 'Messwerte Regler';

$filename = $_GET['filename'];

$lines = file("{$settings['ordner_einstell-mess']}/$filename", FILE_IGNORE_NEW_LINES);
$regler = get_value('Regler', $lines);
$comment = get_comment($lines);
$container = get_template('container', array('content' => '', 'height' => '350px', 'min-height' => '350px', 'max-height' => '350px', 'border' => '0px', 'id' => 'messwerte'));

//$output = get_template('heading', array('heading' => "$heading $regler"));
$output = '<br> ';
$output .= get_template('mess', array('comment' => nl2br($comment), 'container' => $container));
$output .= get_references(array('index', 'einstell', 'einstell-mess', 'sollwert'));
draw_page($output, "$title $regler", $author, HEAD, get_template('script_mess', array('filename' => $filename)));
?>
