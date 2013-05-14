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

include_once('settings.php');
include_once('templates.php');
include_once('page.php');
include_once('tty.php');

$comment = $_POST['comment'];
$regler = $_POST['regler'];
$index = $_POST['index'];
$data = $_POST['data'];
$mode = $_POST['mode'];

switch($mode) {
    case 'read':
        $title = 'read';
        break;
    case 'write':
        $title = 'write';
        break;
    case 'write_save':
        $title = 'write_save';
        break;
    case 'save':
        $title = 'save';
        break;
}
$author = 'Max Bruckner';

$output = "<p><b>Kommentar:</b>$comment</p>";
$output .= "<p><b>Regler:</b>$regler</p>";
$output .= "<p><b>Index:</b>$index</p>";
var_dump($data);
draw_page($output, $title, $author, NAKED);
?>