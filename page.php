<?php
/*
    RPQ2-Webinterface

    Copyright (C) 2012-2013 Innowatt Energiesysteme GmbH
    Author: Max Bruckner, Andreas Bruckner

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

include_once('templates.php');

function draw_page( $content, $title, $author, $type, $header = '') {
    $current = $_SERVER["REQUEST_URI"];

    switch ($type) {
        case NAKED:
            $output = $content;
            break;
        case RAW:
            $output = get_page($content, $current);
            break;
        case LAYOUT:
            $output = get_page(get_layout($content), $current);
            break;
      case HEAD:
            $output = get_page_header($content, $current);
            break;
    }
    echo get_html($output, $title, $author, $header);
}
?>
