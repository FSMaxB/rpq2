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

define('NAKED', 0);
define('RAW', 1);       //Verwende leere Seite mit Header und Footer
define('LAYOUT', 2);    //Verwende Layout
define('HEAD', 3);      //Nur Kopfzeile

include_once('meta.php');
include_once('templates.php');

function draw_page( $content, $title, $author, $type, $header = '') {
    $current = $_SERVER["REQUEST_URI"];

    $output = $content;
    switch ($type) {
        case NAKED:
            $output = $content;
            break;
        case LAYOUT:
            $output = get_template('layout', array('current' => $current, 'content' => $content));
        case RAW:
            $output = get_template('page', array('current' => $current, 'content' => $output));
            break;
      case HEAD:
            $output = get_template('page_header', array('current' => $current, 'content' => $content));
            break;
    }
    echo get_template('html', array('content' => $output, 'title' => $title, 'author' => $author, 'header' => $header));
}
?>
