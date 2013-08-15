
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


$title = 'RPQ2 Webinterface';
$author = 'Andreas Bruckner';

$output = '<a href="einstell_alt.php?filename=default.ew"><h1>Einstellwerte</h1></a>';
$output .= '<a href="mess_alt.php?filename=default.mw"><h1>Messwerte</h1></a>';
$output .= '<a href="einstell-mess_alt.php"><h1>Verwaltung Einstell-/Messwerte</h1></a>';
$output .= '<a href="docs_alt.php"><h1>Dokumentationen</h1></a>';
$output .= '<a href="settings_menu_alt.php"><h1>Einstellungen</h1></a>';
$output .= '<a href="shutdown.php?mode=halt"><h1>Herunterfahren</h1></a>';
$output .= '<br> ';
draw_page($output, $title, $author, RAW);
?>
