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
include_once('templates.php');
include_once('page.php');

$title = 'Datei löschen';
$author = 'Max Bruckner';

$path = $_GET["path"];
$return_success = $_GET['return_success'];
$return_failure = $_GET['return_failure'];

if(unlink($path)) {
    $header = get_template('redirect', array('time' => 1, 'destination' => $return_success));
    $output = '</br> ';
    $output .= get_template('success', array('text' => 'Datei "' . $path . '" gelöscht.'));
} else {
    $header = get_template('redirect', array('time' => 3, 'destination' => $return_failure));
    $output = '</br> ';
    $output .= get_template('failure', array('text' => 'Es ist ein Fehler aufgetreten, "' . $path . '" konnte nicht gelöscht werden.'));
}

draw_page($output, $title, $author, HEAD, $header);
?>
