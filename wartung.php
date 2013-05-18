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
include_once('settings.php');
include_once('templates.php');
include_once('file.php');
include_once('tty.php');

$title = 'Manuelle Geräteeinstellung';
$author = 'Max Bruckner';
$heading = 'Manuelle Geräteeinstellung';

$send = $_POST['send'];
$filename_save = $_POST['filename'];
$comment = $_POST['comment'];
$filename_read = $_GET['filename'];

function send($send) {
    global $settings;

    $received = NULL;

    exec("nativ/einstell wartung {$settings['serial_interface']} $send", $results);

    foreach ( $results as $result ) {
         $received .= "$result\n";
    }
    return $received;
}

function get_file_list() {
    global $settings;

    $file_list = NULL;
    foreach( get_files($settings['ordner_wartung']) as $file ) {
        $file_list .= get_link_wartung($file, "{$settings['ordner_wartung']}/$file", 'wartung.php', 'wartung.php');
    }
    return $file_list;
}

set_tty();

if( $send != '') {
    $received = send($send);
}

if( $filename_save != '' ) {
    file_put_contents("{$settings['ordner_wartung']}/$filename_save", "#$comment\n$send");
}

if( $filename_read != '' ) {
    $comment = NULL;
    $lines = file("{$settings['ordner_wartung']}/$filename_read", FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
    foreach ( $lines as $line ) {
        if( strpos($line, '#') === 0 ) {
            $comment .= substr($line, 1);
        } else {
            $send = $line;
        }
    }
}

$file_list = get_file_list();

$output = get_heading($heading);
$output .= get_form_upload($settings['ordner_wartung'], '', 'wartung.php', 'wartung.php');
$output .= get_wartung(get_container($file_list, '200px'), $comment, $send, $received);
$output .= get_button_menu_back();
draw_page( $output, $title, $author, LAYOUT);
?>