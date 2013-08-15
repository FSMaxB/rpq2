<?php
/*
    RPQ2-Webinterface

    Copyright (C) 2012-2013 Innowatt Energiesysteme GmbH
    Author: Max Bruckner
            Andreas Bruckner

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
include_once('settings.php');
include_once('tty.php');

$title = 'Einstellungen';
$author = 'Max Bruckner';
$heading = 'Einstellungen';

if( isset($_GET['']) ) {
    $settings = $_GET['settings'];
}

//Liste mit seriellen Schnittstellen erstellen
$interfaces = NULL;
foreach( get_ttys() as $tty ) {
    if( "/dev/$tty" == $settings['serial_interface'] ) {
        $interfaces .= "<option selected>/dev/$tty</option>\n";
    } else {
        $interfaces .= "<option>/dev/$tty</option>";
    }
}

//Liste mit Baudraten erstellen
$baudrates = '';
foreach( explode("\n", get_template('baudrates', array(), 'txt')) as $baudrate ) {
    if( $baudrate == $settings['serial_baudrate'] ) {
        $baudrates .= "<option selected>$baudrate</option>\n";
    } else {
        $baudrates .= "<option>$baudrate</option>\n";
    }
}

$output = get_template('heading', array('heading' => $heading));
$output .= get_template('form_settings', array(
                        'serial_interfaces' => $interfaces,
                        'serial_baudrates' => $baudrates,
                        'ordner_docs' => $settings['ordner_docs'],
                        'ordner_einstell-mess' => $settings['ordner_einstell-mess'],
                        'ordner_wartung' => $settings['ordner_wartung'],
                        'ordner_log' => $settings['ordner_log'],
                        'ordner_pdo' => $settings['ordner_pdo'],
                        'ordner_misc' => $settings['ordner_misc'],
                        'return_success' => $return,
                        'return_failure' => $return));
$output .= '<a href="editor_alt_shut_down.php?ordner=misc&filename=shutdown_time"><h3>Shutdown-Zeit</h3></a>';
$output .= '<a href="index.php"><h3>Zum Hauptmenü</h3></a>';
draw_page($output, $title, $author, HEAD);
?>
