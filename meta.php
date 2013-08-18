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

//Verweis auf existierende Seite (dabei 'message=' entfernen)
$meta_url_parsed = parse_url($_SERVER["REQUEST_URI"]);  //return auf aktuelle Seite setzen
$meta_current_split = explode('&', $meta_url_parsed['query']);
for($i = 0; $i < count($meta_current_split); $i++) {
    if(strpos($meta_current_split[$i], 'message=') === 0)
        unset($meta_current_split[$i]);
}
if(count($meta_current_split) > 0)
    $meta_url_parsed['path'] .= '?';
$meta_current = $meta_url_parsed['path'] . str_replace('0=', '', http_build_query($meta_current_split));

$meta_profile = PROFILE_STANDARD;
//Internet-Explorer erkennen
$USER_AGENT_SPLIT = explode(' ', strtolower($_SERVER['HTTP_USER_AGENT']));
if((array_search('msie', $USER_AGENT_SPLIT) !== FALSE) && ($USER_AGENT_SPLIT[array_search('msie', $USER_AGENT_SPLIT)+1] < 10))
    $meta_profile = PROFILE_IE7;

//Nachrichten für Nachrichtenzeile empfangen
$meta_message = $_GET['message'];

?>