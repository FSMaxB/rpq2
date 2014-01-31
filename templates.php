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

/*
 * Die folgende Funktion führt eine Template-Ersetzung mit beliebigen
 * Dateien durch.
 *
 * Um ein neues Template zu erstellen, muss eine neue Datei im Ordner
 * "templates" angelegt werden.
 *
 * Die Funktion get_template erhält einen Dateinamen, optional eine Datei-
 * Endung ( der Standard ist .html ) und einen Array mit den zu
 * ersetzenden Texten. Es kann alles ersetzt werden, was in geschweiften
 * Klammern umfasst ist.
 *
 * Hier ein Beispiel:
 *      Dies ist {eins} Test. Dies ist {zwei} Test.
 * Mit dem Array array{ 'eins' => 'der erste', 'zwei' => 'der zweite' }
 * wird zu:
 *      Dies ist der erste Test. Dies ist der zweite Test.
 *
 * Hierbei können beliebige Template-Argumente beliebig Oft in
 * beliebiger Reihenfolge verwendet werden
 * 
 * */
function get_template($filename, $values = array(), $extension = 'html') {
    $output = file_get_contents("templates/$filename" . '.' . $extension);
    $keys = array_keys($values);    //Liste der zu ersetzenden Strings
    foreach($keys as $key) {
        $output = str_replace('{' . $key . '}', $values[$key], $output);
    }
    return $output;
}
?>
