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
include_once('settings.php');
include_once('csv.php');
include_once('templates.php');
include_once('tty.php');
include_once('file.php');

$filename = $_GET['filename'];
$log = $_GET['log'];

function get_mess_format($lines) {
    $i = 0;
    $mess_format = NULL;
    foreach($lines as $line) {
        $split = explode(',', $line);
        if( (count($split) == 8) && (strlen($split[0]) <= 2)  && is_numeric($split[0]) ) {    //Messwert-Format-Zeile?
            $mess_format[$i]['pos'] = $split[0];
            $mess_format[$i]['skal'] = $split[1];
            $mess_format[$i]['komma'] = $split[2];
            $mess_format[$i]['skalproz'] = $split[3];
            $mess_format[$i]['proz'] = $split[4];
            $mess_format[$i]['hex'] = $split[5];
            $mess_format[$i]['bin'] = $split[6];
            $mess_format[$i]['text'] = $split[7];
        }
        $i++;
    }
    return $mess_format;
}

function get_messwerte($regler) {
    global $settings;

    exec("nativ/mess {$settings['serial_interface']} $regler", $results);

    $i = 0;
    foreach ($results as $result) {
        $split = explode(',', $result);

        $messwerte[$i]['proz'] = $split[0];
        $messwerte[$i]['hex'] = $split[1];
        $messwerte[$i]['bin'] = $split[2];

        $i++;
    }

    return $messwerte;
}

function get_mess_lines($messwerte, $mess_format) {
    $output = NULL;
    foreach ( $mess_format as $line ) {
        $pos = $line['pos'] - 1;
        $text = $line['text'];
        $skal = '&nbsp;';
        if($line['skalproz'] === '1') {
            $skal = number_format($line['skal'] * $messwerte[$pos]['proz'], $line['komma'], ',', ' ');
        }
        $proz = '&nbsp;';
        if($line['proz'] === '1') {
            $proz = number_format($messwerte[$pos]['proz'], 0, ',', ' ');
        }
        $hex = '&nbsp;';
        if($line['hex'] === '1') {
            $hex = $messwerte[$pos]['hex'];
        }
        $bin = '&nbsp;';
        if($line['bin'] === '1') {
            $bin = $messwerte[$pos]['bin'];
            $bin1 = substr($bin, 0, 4);
            $bin2 = substr($bin, 4, 4);
            $bin3 = substr($bin, 8,4);
            $bin4 = substr($bin, 12,4);
            $bin = "$bin1-$bin2-$bin3-$bin4";
        }

        $output .= get_zeile_mess_get($text, $skal, $proz, $hex, $bin);
    }
    return $output;
}

$lines = file("{$settings['ordner_einstell-mess']}/$filename", FILE_IGNORE_NEW_LINES);
$mess_format = get_mess_format($lines);
$regler = get_value('Regler', $lines);
$messwerte = get_messwerte($regler);

if($log === 'true') {
    $log_line = "\n";
    foreach($mess_format as $format) {
        if($format['proz'] === '1') {
            $log_line .= $messwerte[$format['pos']-1]['proz'] . ',';
        }
    }
    $filename = correct_filename($filename, 'log');
    file_put_contents("{$settings['ordner_log']}/$filename", $log_line, FILE_APPEND);
}

$output = get_zeile_mess_get('<b>Beschreibung:</b>', '&nbsp;<b>Istwert:</b>', '&nbsp;<b>Prozesswert:</b>', '&nbsp;<b>HEX-Wert:</b>', '&nbsp;<b> Anzeige Binäre-Werte:</b>&nbsp;');
$output .= get_mess_lines($messwerte, $mess_format);
echo get_mess_get($output);
?>
