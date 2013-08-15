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
include_once('page.php');
include_once('templates.php');


$title = 'RPQ2 Webinterface';
$author = 'Max Bruckner';


$output = get_template('script_detect');
$output .= get_template('button_menu', array('link' => 'einstell.php?filename=default.ew', 'text' => 'Einstellwerte'));
$output .= get_template('button_menu', array('link' => 'mess.php?filename=default.mw', 'text' => 'Messwerte'));
$output .= get_template('button_menu', array('link' => 'einstell-mess.php', 'text' => 'Einstell-/Mess-/Sollwerte verwalten'));
$output .= get_template('button_menu', array('link' => 'logs.php', 'text' => 'Aufzeichnungen verwalten'));
$output .= get_template('button_menu', array('link' => 'docs.php', 'text' => 'Dokumentationen'));
$output .= get_template('button_menu', array('link' => 'settings_menu.php', 'text' => 'Einstellungen'));

$output .= get_template('vspace');
$output .= get_template('button_shutdown');

draw_page($output, $title, $author, LAYOUT);
?>
