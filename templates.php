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

function get_template($filename, $values = array(), $extension = 'html') {
    $output = file_get_contents("templates/$filename" . '.' . $extension);
    $keys = array_keys($values);    //Liste der zu ersetzenden Strings
    foreach($keys as $key) {
        $output = str_replace('{' . $key . '}', $values[$key], $output);
    }
    return $output;
}
?>
