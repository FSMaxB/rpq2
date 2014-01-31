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
include_once('templates.php');


$title = 'RPQ2 Webinterface';
$author = 'Max Bruckner';

//Die folgenden Seiten bekommen Menu-Items, sofern im Profil vorhanden
$menu = array('einstell', 'mess', 'einstell-mess', 'logs', 'docs', 'settings_menu', 'shutdown_menu');

$output = '';
foreach($menu as $menu_item) {
    //Ist menu_item im aktuellen Profil vorhanden, erstelle Button
    if(array_search($menu_item, profile_references() ) !== FALSE)
        if($menu_item != 'shutdown_menu') //Shutdown wird ausgefiltert
            $output .= profile_button_menu($REFS[$menu_item]['link'], $REFS[$menu_item]['menu']);
}

$output .= profile_button_shutdown();

draw_page($output, $title, $author, LAYOUT);
?>
