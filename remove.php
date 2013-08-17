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
    $message = http_build_query(array('message' => get_template('success', array('text' => 'Datei "' . $path . '" gelöscht.'))));
    if(strpos($return_success, '?') === FALSE)
        $return_success .= "?$message";
    else
        $return_success .= $message;
    $header = get_template('redirect', array('time' => 0, 'destination' => $return_success));
} else {
    $message = http_build_query(array('message' => get_template('failure', array('text' => 'Es ist ein Fehler aufgetreten, "' . $path . '" konnte nicht gelöscht werden.'))));
    if(strpos($return_failure, '?') === FALSE)
        $return_failure .= "?$message";
    else
        $return_failure .= $message;
    $header = get_template('redirect', array('time' => 0, 'destination' => $return_failure));
}

draw_page($output, $title, $author, HTML, $header);
?>
