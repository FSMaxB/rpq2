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

define('NAKED', 0);     //Gar kein Template
define('HTML', 1);      //Nur HTML-Gerüst
define('RAW', 2);       //Verwende leere Seite mit Header und Footer
define('LAYOUT', 3);    //Verwende Layout
define('HEAD', 4);      //Nur Kopfzeile

include_once('meta.php');
include_once('templates.php');

function draw_page( $content, $title, $author, $type, $header = '') {
    global $meta_profile, $meta_message, $meta_current;

    if( ($meta_profile == PROFILE_IE7) && ($type == LAYOUT))
        $type = RAW;

    $output = $content;
    switch ($type) {
        case NAKED:
            $output = $content;
            break;
        case HTML:
            $output = get_template('html', array('author' => $author, 'title' => $title, 'header' => $header, 'content' => $content, 'message' => $meta_message));
            break;
        case RAW:
            $output = get_template('page_header', array('message' => $meta_message, 'version' => get_template('version', array(), 'txt')));
            $output .= $content;
            $output .= get_template('page_footer', array('current' => $meta_current));
            $output = get_template('html', array('author' => $author, 'title' => $title, 'header' => $header, 'content' => $output, 'message' => ''));
            break;
        case LAYOUT:
            $output = get_template('page_header', array('message' => $meta_message, 'version' => get_template('version', array(), 'txt')));
            $output .= get_template('layout', array('content' => $content));
            $output .= get_template('page_footer', array('current' => $meta_current));
            $output = get_template('html', array('author' => $author, 'title' => $title, 'header' => $header, 'content' => $output, 'message' => ''));
            break;
      case HEAD:
            $output = get_template('page_header', array('message' => $meta_message, 'version' => get_template('version', array(), 'txt')));
            $output .= $content;
            $output = get_template('html', array('author' => $author, 'title' => $title, 'header' => $header, 'content' => $output, 'message' => ''));
            break;
    }
    echo $output;
}
?>
