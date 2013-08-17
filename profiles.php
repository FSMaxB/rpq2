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

$REFS = array(
    'docs' => array(
        'link' => 'docs.php',
        'ref' => 'Zu Dokumentationen',
        'menu' => 'Dokumentationen'),
    'editor' => array(
        'link' => 'editor.php',
        'ref' => 'Zum Editor',
        'menu' => 'Editor'),
    'einstell-mess' => array(
        'link' => 'einstell-mess.php',
        'ref' => 'Verwaltung Einstell-/Messwerte',
        'menu' => 'Verwaltung Einstell-/Messwerte'),
    'einstell' => array(
        'link' => 'einstell.php?filename=default.ew',
        'ref' => 'Zu Einstellwerten',
        'menu' => 'Einstellwerte'),
    'index' => array(
        'link' => 'index.php',
        'ref' => 'Zum Hauptmenü',
        'menu' => 'Hauptmenü'),
    'license' => array(
        'link' => 'license.php',
        'ref' => 'Zu Lizenzbedingungen',
        'menu' => 'Lizenzbedingungen'),
    'logs' => array(
        'link' => 'logs.php',
        'ref' => 'Zu Aufzeichnungen',
        'menu' => 'Aufzeichnungen'),
    'mess' => array(
        'link' => 'mess.php?filename=default.mw',
        'ref' => 'Zu Messwerten',
        'menu' => 'Messwerte'),
    'mess_edit' => array(
        'link' => 'mess_edit.php?filename=default.mw',
        'ref' => 'Anpassung Messwerte',
        'menu' => 'Anpassung Messwerte'),
    'pdo_mapping' => array(
        'link' => 'pdo_mapping.php',
        'ref' => 'Zu PDO-Mapping',
        'menu' => 'PDO-Mapping'),
    'settings_menu' => array(
        'link' => 'settings_menu.php',
        'ref' => 'Zu Einstellungen',
        'menu' => 'Einstellungen'),
    'shutdown_menu' => array(
        'link' => 'shutdown_menu.php',
        'ref' => 'Zum Herunterfahren',
        'menu' => 'Herunterfahren'),
    'sollwert' => array(
        'link' => 'sollwert.php',
        'ref' => 'Zu Sollwerten',
        'menu' => 'Sollwerte'),
    'wartung' => array(
        'link' => 'wartung.php',
        'ref' => 'Manuelle Geräteeinstellung',
        'menu' => 'Manuelle Geräteeinstellung')
    );

$REFS_STANDARD = array('docs', 'editor', 'einstell-mess', 'einstell',
        'index', 'license', 'logs', 'mess',
        'mess_edit', 'pdo_mapping', 'settings_menu',
        'shutdown_menu', 'sollwert', 'wartung');
$REFS_IE7 = array('docs', 'einstell-mess', 'einstell',
        'index', 'license', 'mess', 'mess_edit',
        'settings_menu', 'shutdown_menu');

function profile_button($link, $text) {
    global $meta_profile;
    switch($meta_profile) {
        case PROFILE_STANDARD:
            return get_template('button', array('link' => $link, 'text' => $text));
        case PROFILE_IE7:
            return get_template('ie7_ref', array('link' => $link, 'text' => $text));
    }
}

function profile_button_inline($link, $text) {
    global $meta_profile;
    switch($meta_profile) {
        case PROFILE_STANDARD:
            return get_template('button_inline', array('link' => $link, 'text' => $text));
        case PROFILE_IE7:
            return '&nbsp;' . get_template('ie7_ref', array('link' => $link, 'text' => $text)) . '&nbsp;';
    }
}

function profile_button_menu($link, $text) {
    global $meta_profile;
    switch($meta_profile) {
        case PROFILE_STANDARD:
            return get_template('button_menu', array('link' => $link, 'text' => $text));
        case PROFILE_IE7:
            return get_template('ie7_button_menu', array('link' => $link, 'text' => $text));
    }
}

function profile_button_shutdown() {
    global $meta_profile, $REFS;
    switch($meta_profile) {
        case PROFILE_STANDARD:
            return get_template('vspace') . get_template('button_shutdown');
        case PROFILE_IE7:
            return get_template('ie7_button_menu', array('link' => $REFS['shutdown_menu']['link'], 'text' => $REFS['shutdown_menu']['menu']));
    }
}

function profile_references() {
    global $REFS_IE7, $REFS_STANDARD, $meta_profile;

    switch($meta_profile) {
        case PROFILE_STANDARD:
            return $REFS_STANDARD;
        case PROFILE_IE7:
            return $REFS_IE7;
    }
}

function get_references($refs) {
    global $REFS;

    $output = '</br></br>';

    $available_refs = profile_references();
    foreach($refs as $ref) {
        if(array_search($ref, $available_refs) !== FALSE) {
            $output .= profile_button_inline($REFS[$ref]['link'], $REFS[$ref]['ref']);
        }
    }
    return $output;
}
?>