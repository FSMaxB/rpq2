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
include_once('templates.php');

function correct_filename($filename, $extension) {
    //Überprüfen und korrigieren der Dateiendung
    $split = explode('.', $filename);
    if( ($extension != '') && (strcasecmp(end($split), $extension) !== 0) ) {
        $filename .= ".$extension";
    }

    if( strcasecmp(end($split), 'php') === 0  ) {
        $output = get_failure('Es ist nicht gestattet, PHP-Dateien abzuspeichern!');
        $header = get_redirect(3, 'index.php');     //TODO Das ist nicht die eleganteste Lösung
        draw_page($output, $title, $author, NAKED, $header);
        exit(1);
    }

    return $filename;
}

function get_files($ordner) {
    $file_list = scandir($ordner);

    foreach ( $file_list as $datei ) {
        if( strpos($datei, '.') !== 0 ) //Ausfiltern aller versteckter Dateien
            $files[] = $datei;
    }

    return $files;
}
?>