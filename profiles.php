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

/*
 * In dieser Datei werden diverse Profile definiert und implementiert.
 * Die Profile existieren Hauptsächlich, um für Internet Explorer zur
 * kompatibilität dynamisch einige Funktionen entfernen und UI-Elemente
 * durch andere ersetzen zu können. Die Profile können aber auch nützlich
 * sein, um für verschiedene zu steuernde Geräte verschiedene Menüpunkte
 * und Funktionen anbieten zu können.
 * */

/*
 * Dies ist eine Liste aller Links auf Seiten. Hierzu wird erstens
 * der Name der PHP-Datei ( link ), zweitens der Text, der erscheint,
 * wenn im Hauptmenü auf die Seite verlinkt wird ( menu ) und
 * drittens der Text, der bei Querverweisen, zwischen den einzelnen
 * Seiten und Untermenüs angezeigt wird ( ref ) angegeben.
 *
 * Die Untermenüs oder das Hauptmenü muss also nur noch eine Liste
 * der Seiten angeben, die verlinkt werden sollen und die Buttons
 * etc. können dann automatisch daraus generiert werden.
 * */
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

/*
 * Verschiedene Profile enthalten nur bestimmte Seiten,
 * die überhaupt verwendet werden. Diese werden in den
 * folgenden Arrays definiert. Wenn ein Untermenü
 * beispielsweise einen Link zu "sollwert" anfordert,
 * aktuell aber das IE7-Profil verwendet wird, so wird
 * dieser Link nicht angezeigt werden.
 * */
$REFS_STANDARD = array('docs', 'editor', 'einstell-mess', 'einstell',
        'index', 'license', 'logs', 'mess',
        'mess_edit', 'pdo_mapping', 'settings_menu',
        'shutdown_menu', 'sollwert', 'wartung');
$REFS_IE7 = array('docs', 'einstell-mess', 'einstell',
        'index', 'license', 'mess', 'mess_edit',
        'settings_menu', 'shutdown_menu');

/*
 * Gibt den Button des gerade gesetzten Profils zurück
 * */
function profile_button($link, $text) {
    global $meta_profile;
    switch($meta_profile) {
        case PROFILE_STANDARD:
            return get_template('button', array('link' => $link, 'text' => $text));
        case PROFILE_IE7:
            return get_template('ie7_ref', array('link' => $link, 'text' => $text));
    }
}

/*
 * Gibt den inline-Button des aktuellen Profils zurück.
 * Inline-Buttons sind Buttons, die nicht eine gesamte
 * Zeile für sich beanspruchen.
 * */
function profile_button_inline($link, $text) {
    global $meta_profile;
    switch($meta_profile) {
        case PROFILE_STANDARD:
            return get_template('button_inline', array('link' => $link, 'text' => $text));
        case PROFILE_IE7:
            return '&nbsp;' . get_template('ie7_ref', array('link' => $link, 'text' => $text)) . '&nbsp;';
    }
}

/*
 * Gibt den Hauptmenü-Button des aktuellen Profils zurück
 * */
function profile_button_menu($link, $text) {
    global $meta_profile;
    switch($meta_profile) {
        case PROFILE_STANDARD:
            return get_template('button_menu', array('link' => $link, 'text' => $text));
        case PROFILE_IE7:
            return get_template('ie7_button_menu', array('link' => $link, 'text' => $text));
    }
}

/*
 * Gibt den Shutdown-Button des aktuellen Profils zurück
 * */
function profile_button_shutdown() {
    global $meta_profile, $REFS;
    switch($meta_profile) {
        case PROFILE_STANDARD:
            return get_template('vspace') . get_template('button_shutdown');
        case PROFILE_IE7:
            return get_template('ie7_button_menu', array('link' => $REFS['shutdown_menu']['link'], 'text' => $REFS['shutdown_menu']['menu']));
    }
}

/*
 * Kleine Helferfunktion, die je nach Profil die
 * Liste der zu verwendenden Seiten zurückgibt.
 * */
function profile_references() {
    global $REFS_IE7, $REFS_STANDARD, $meta_profile;

    switch($meta_profile) {
        case PROFILE_STANDARD:
            return $REFS_STANDARD;
        case PROFILE_IE7:
            return $REFS_IE7;
    }
}

/*
 * Erstellt eine Zeile mit Querverweisen,
 * wie sie unten auf den meisten Seiten
 * vorkommen. Hierzu bekommt die Funktion
 * eine Liste von Seiten, zu denen Verlinkt
 * werden soll und entscheidet anhand des Profils,
 * welche Verweise tatsächlich generiert werden.
 * */
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
