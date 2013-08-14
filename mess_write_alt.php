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
include_once('settings.php');
include_once('templates.php');
include_once('page.php');
include_once('file.php');

function write_csv($filename, $comment, $regler, $data, $take_comments, $take_others) {
    global $settings;
    $first_value = FALSE;
    $output = $comment;
    $output .= "Regler,$regler\n";
    foreach( $data as $line) {
        switch($line['type']) {
            case 'value':
                $first_value = TRUE;
                $output .= "{$line['pos']},{$line['skal']},{$line['komma']},{$line['skalproz']},{$line['proz']},{$line['hex']},{$line['bin']},{$line['text']}\n";
                break;
            case 'comment':
                if($take_comments)
                    $output .= $line['line'] . "\n";
                break;
            case 'other':
                if($take_others && $first_value )
                    $output .= $line['line'] . "\n";
        }
    }
    $filename = correct_filename($filename, '');
    return file_put_contents("{$settings['ordner_einstell-mess']}/$filename", $output);
}

$title = "Messwerttabelle speichern";
$author = "Max Bruckner";

$filename = $_POST['filename'];
$comment = $_POST['comment'];
$regler = $_POST['regler'];
$data = $_POST['data'];
$take_comments = $_POST['take_comments'];

if(write_csv($filename, $comment, $regler, $data, $take_comments, FALSE)) {
 //   $output = get_success('Messwerttabelle erfolgreich gespeichert!');
    $header = get_redirect(0, 'einstell-mess_alt.php');
} else {
    $output = get_failure('Messwerttabelle konnte nicht gespeichert werden!');
    $header = get_redirect(3, 'einstell-mess_alt.php');
}

draw_page($output, $title, $author, NAKED, $header);
?>
