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
include_once('file.php');

function ordner_list($ordner) {
    global $settings;

    $output = NULL;
    foreach (array_keys($settings) as $key) {
        if( strpos($key, 'ordner') === 0) {
            if($settings[$key] === $ordner) {
                $output .= "<option value=\"{$settings[$key]}\" selected>{$settings[$key]}</option>\n";
            } else {
                $output .= "<option value=\"{$settings[$key]}\">{$settings[$key]}</option>\n";
            }
        }
    }
    return $output;
}

$get = FALSE;
if(isset($_GET['ordner'])) {
    $ordner = $_GET['ordner'];
    $get = TRUE;
} else {
    $ordner = $_POST['ordner'];
}
if(isset($_GET['filename'])) {
    $filename = correct_filename($_GET['filename'], '');
    $get = TRUE;
} else {
    $filename = correct_filename($_POST['filename'], '');
}
$text = $_POST['text'];
$return = $_GET['return'];

$title = "Bearbeiten von \"$ordner/$filename\"";
$author = 'Max Bruckner';
$heading = "Bearbeiten von \"$ordner/$filename\"";

if( ($ordner != '') && ($filename != '')) {
    if($get === TRUE) {
        $text = file_get_contents("$ordner/$filename");
    } else {
        if($text == '') //Verhindert einen Bug, dass man leere Dateien nicht speichern kann
            $text = ' ';
        if(file_put_contents("$ordner/$filename", $text)) {
            $message = get_template('success', array('text' => 'Speichern Erfolgreich'));
        } else {
            $message = get_template('failure', array('text' => 'Speichern Fehlgeschlagen'));
        }
    }
}

$ordnerlist = ordner_list($ordner);
if($return == '') {
    $return = 'index.php';
}

$output = get_template('heading', array('heading' => $heading));
$output .= get_template('form_editor', array('text' => $text, 'ordnerlist' => $ordnerlist, 'filename' => $filename));
$output .= '</br>';
$output .= $message;
$output .= get_references(array('index', 'einstell-mess', 'mess'));
draw_page($output, $title, $author, HEAD);
?>
