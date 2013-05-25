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

include_once('settings.php');
include_once('templates.php');
include_once('page.php');
include_once('csv.php');

function get_mess_lines($lines) {
    $output = NULL;
    if($lines != '') {
        //$output = get_zeile_mess_edit('<b>Position:</b>', '<b>Skalierungsfaktor:</b>', '<b>Kommastellen:</b>', '<b>Istwert:</b>', '<b>Prozesswert:</b>', '<b>Hex:</b>', '<b>Bin:</b>', '<b>Beschreibung:</b>');

        $i = 0;
        foreach( $lines as $line) {
            $split = explode(',', $line);
            $output .= "<input type=\"hidden\" name=\"data[$i][line]\" value=\"$line\">\n";
            if( strpos($line, '#') === 0) {
                $output .= "<input type=\"hidden\" name=\"data[$i][type]\" value=\"comment\">\n";
            } else if( (count($split) == 8) && (strlen($split[0]) <= 2)  && is_numeric($split[0]) ) {    //Messwert-Format-Zeile?
                $output .= "<input type=\"hidden\" name=\"data[$i][type]\" value=\"value\">\n";
                $skalproz = $proz = $hex = $bin = '';
                $pos = $split[0];
                $skal = $split[1];
                $komma = $split[2];
                if($split[3] === '1')
                    $skalproz = 'checked';
                if($split[4] === '1')
                    $proz = 'checked';
                if($split[5] === '1')
                    $hex = 'checked';
                if($split[6] === '1')
                    $bin = 'checked';
                $text = $split[7];
                $output .= get_zeile_mess_edit($i, $pos, $skal, $komma, $skalproz, $proz, $hex, $bin, $text);
            } else {
                $output .= "<input type=\"hidden\" name=\"data[$i][type]\" value=\"other\">\n";
            }
            $i++;
        }
    }
    return $output;
}

$title = "Messwerttabellen bearbeiten";
$author = "Max Bruckner";
$heading = "Messwerttabellen bearbeiten";

$filename = $_GET['filename'];

$lines = file("{$settings['ordner_einstell-mess']}/$filename", FILE_IGNORE_NEW_LINES);
$regler = get_value('Regler', $lines);
$comment = get_comment($lines);
$mess_lines = get_mess_lines($lines);

$output = get_heading($heading);
$output .= get_mess_edit($comment, $regler, $mess_lines, $filename);
$output .= get_button_menu_back();

draw_page($output, $title, $author, LAYOUT);

?>