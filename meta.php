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

//Diese Datei muss in jeder anderen Datei eingebunden werden.

define('PROFILE_STANDARD', 0);
define('PROFILE_IE7', 1);

//Log-Datei schreiben
file_put_contents('misc/timestamp', time());
$return = $_SERVER["REQUEST_URI"];  //return auf aktuelle Seite setzen
$profile = PROFILE_STANDARD;
if(stripos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7') !== FALSE) {
    $profile = PROFILE_IE7;
}
?>