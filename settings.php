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

define('CONFIG_FILE','settings.cfg');

function get_settings() {
    global $settings;
     $settings =
        array(      //Setzen der Defaultwerte
            'serial_interface' => '/dev/ttyUSB0',
            'serial_baudrate' => '115200',
            'ordner_docs' => 'docs',
            'ordner_einstell-mess' => 'einstell-mess',
            'ordner_wartung' => 'wartung',
            'ordner_log' => 'log',
            'ordner_pdo' => 'pdo',
            'ordner_misc' => 'misc'
        );

    $lines = file(CONFIG_FILE, FILE_IGNORE_NEW_LINES);

    foreach( $lines as $line) {
        if( (strpos($line, '#') !== 0) && ($line)) {    //Kommentarzeilen werden ignoriert
            $setting = explode('=', $line);
            if( ($setting[0]) && ($setting[1]) ) {
                $settings[$setting[0]] = trim($setting[1]);
            }
        }
    }
}

function write_settings($settings) {
    $config_linse = file(CONFIG_FILE, FILE_IGNORE_NEW_LINES);
    $output = '';
    foreach( $config_lines as $config_line ) {
        if( (strpos($config_line, '#') !== 0) && ($config_line) ) { //Kommentarzeilen und leere Zeilen nicht bearbeiten
            $setting = explode('=', $config_line);
            if( $setting[0] && $setting[1] && $settings[$setting[0]] ) {
                $output .= "{$setting[0]}={$settings[$setting[0]]}\n";
                unset($settings[$setting[0]]);
            }
        } else {
            $output .= "$config_line\n";
        }
    }

    foreach( array_keys($settings) as $key) {
        $output .= "$key={$settings[$key]}\n";
    }

    if( file_put_contents(CONFIG_FILE, $output) !== FALSE) {
        return TRUE;
    } else {
        return FALSE;
    }
}

get_settings();

//Wenn diese Datei direkt aufgerufen und nicht eingebunden wurde!
if( __FILE__ == $_SERVER['SCRIPT_FILENAME'] ) {
    include_once('page.php');
    include_once('templates.php');

    $title = 'Einstellungen speichern';
    $author = 'Max Bruckner';

    $settings = $_POST['settings'];
    $return_success = $_POST['return_success'];
    $return_failure = $_POST['return_failure'];

    if( write_settings($settings) ) {
		
        $message = http_build_query(array('message' => get_template('success', array('text' => 'Einstellungen gespeichert'))));
        if(strpos($return_success, '?') === FALSE)
            $return_success .= "?$message";
        else
            $return_success .= $message;
        $header = get_template('redirect', array('time' => 0, 'destination' => $return_success));
    } else {
        //Im fehlerfall werden die Einstellungen wieder zurückgegeben, sodass man sie nicht nochmal eingeben muss
        $queries = array( 'settings' => $settings, 'message' => get_template('failure', array('text' => 'Beim speichern der Einstellungen ist ein Fehler aufgetreten!')));
        $query = http_build_query($queries);
        if(strpos($return_failure, '?') === FALSE)
            $return_failure .= "?$query";
        else
            $return_failure .= $query;
        $header = get_template('redirect', array('time' => 0, 'destination' => "$return_failure"));
    }

    draw_page($output, $title, $author, HTML, $header);
}
?>
