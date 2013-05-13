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
include_once('settings.php');
include_once('tty.php');

$title = 'Einstellungen';
$author = 'Max Bruckner';
$heading = 'Einstellungen';

$settings_url = $_GET['settings'];
if( $settings_url ) {
    $settings = $settings_url;
}

//Liste mit seriellen Schnittstellen erstellen
$interfaces = '';
foreach( get_ttys() as $tty ) {
    if( $tty == $settings['serial_interface'] ) {
        $interfaces .= "<option selected>$tty</option>\n";
    } else {
        $interfaces .= "<option>$tty</option>";
    }
}

//Liste mit Baudraten erstellen
$baudrates = '';
foreach( explode("\n", get_baudrates()) as $baudrate ) {
    if( $baudrate == $settings['serial_baudrate'] ) {
        $baudrates .= "<option selected>$baudrate</option>\n";
    } else {
        $baudrates .= "<option>$baudrate</option>\n";
    }
}

$output = get_heading($heading);
$output .= get_form_settings($interfaces, $baudrates, $settings['ordner_docs'], $settings['ordner_owndocs'], $settings['ordner_einstellwert'], 'settings_menu.php', 'settings_menu.php');
$output .= get_button_menu_back();
draw_page($output, $title, $author, LAYOUT);

?>