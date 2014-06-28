<?php
/*
    RPQ2-Webinterface

    Copyright (C) 2012-2014 Innowatt Energiesysteme GmbH
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
include_once('file.php');
include_once('templates.php');

$title = 'Datei hochladen';
$author = 'Max Bruckner';


//Variablen per POST holen
$ordner = $_POST['ordner'];
$return_success = $_POST['return_success'];
$return_failure = $_POST['return_failure'];
$extension = $_POST['extension'];   //Wenn nicht angegeben geht alles außer PHP

$name = $_FILES['datei']['name'];   //Ursprünglicher Dateiname der hochgeladenen Datei

$name = correct_filename($name, $extension);

$ziel = "$ordner/$name";


if(move_uploaded_file($_FILES['datei']['tmp_name'],$ziel))
{
    $message = http_build_query(array('message' => get_template('success', array('text' => "Datei \"{$_FILES['datei']['name']}\" hochgeladen."))));
    if(strpos($return_success, '?') === FAlSE)
        $return_success .= "?$message";
    else
        $return_success .= $message;
    $header = get_template('redirect', array('time' => 0, 'destination' => $return_success));
} else {
    $message = http_build_query(array('message' => get_template('failure', array( 'text' => "Beim Hochladen der Datei \"{$_FILES['datei']['name']}\" ist ein Fehler aufgetreten."))));
    if(strpos($return_failure, '?') === FALSE)
        $return_failure .= "?$message";
    else
        $return_failure .= $message;
    $header = get_template('redirect', array('time' => 0, 'destination' => $return_failure));
}

draw_page($output, $title, $author, HTML, $header);
?>
