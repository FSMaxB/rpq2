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
include_once('templates.php');


$title = 'RPQ2 Webinterface';
$author = 'Max Bruckner';

$output = get_button_menu('einstell-mess.php', 'Einstell-/Messwerttabellen verwalten');
$output .= get_button_menu('einstell.php?filename=default.ew', 'Einstellwerte');
$output .= get_button_menu('mess.php?filename=default.mw', 'Messwerte');
$output .= get_button_menu('wartung.php', 'Manuelle Geräteeinstellung');
$output .= get_button_menu('docs.php', 'Dokumentationen');
$output .= get_button_menu('settings_menu.php', 'Einstellungen');
$output .= get_vspace();
$output .= get_button_shutdown();

draw_page($output, $title, $author, LAYOUT);
?>