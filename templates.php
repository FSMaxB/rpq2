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

function get_wartung($received) {
    $template_wartung = file_get_contents('template_wartung.html');

    return str_replace('{received}', $received, $template_wartung);
}

function get_redirect($time, $destination) {
    $template_redirect = file_get_contents('template_redirect.html');

    $output = str_replace('{time}', $time, $template_redirect);
    $output = str_replace('{destination}', $destination, $output);
    return $output;
}

function get_page($content, $current) {
    $template_page = file_get_contents('template_page.html');

    $output = str_replace('{content}', $content, $template_page);
    $output = str_replace('{current}', $current, $output);
    return $output;
}

function get_link_einstelltab($path, $filename, $return_success, $return_failure) {
    $template_link_einstelltab = file_get_contents('template_link_einstelltab.html');

    $output = str_replace('{path}', $path, $template_link_einstelltab);
    $output = str_replace('{filename}', $filename, $output);
    $output = str_replace('{return_success}', $return_success, $output);
    $output = str_replace('{return_failure}', $return_failure, $output);
    return $output;
}

function get_layout($content) {
    $template_layout = file_get_contents('template_layout.html');

    return str_replace('{content}', $content, $template_layout);
}

function get_html($content, $title, $author, $header) {
    $template_html = file_get_contents('template_html.html');

    $output = str_replace('{content}', $content, $template_html);
    $output = str_replace('{title}', $title, $output);
    $output = str_replace('{author}', $author, $output);
    $output = str_replace('{header}', $header, $output);
    return $output;
}

function get_heading($heading) {
    $template_heading = file_get_contents('template_heading.html');

    return str_replace('{heading}', $heading, $template_heading);
}

function get_form_upload($directory, $extension, $return_success, $return_failure) {
    $template_form_upload = file_get_contents('template_form_upload.html');

    $output = str_replace('{directory}', $directory, $template_form_upload);
    $output = str_replace('{extension}', $extension, $output);
    $output = str_replace('{return_success}', $return_success, $output);
    $output = str_replace('{return_failure}', $return_failure, $output);
    return $output;
}

function get_container($content, $height = '400px', $border = '1px') {
    $template_container = file_get_contents('template_container.html');

    $output = str_replace('{content}', $content, $template_container);
    $output = str_replace('{height}', $height, $output);
    $output = str_replace('{border}', $border, $output);
    return $output;
}

function get_button($link, $text) {
    $template_button = file_get_contents('template_button.html');

    $output = str_replace('{link}', $link, $template_button);
    $output = str_replace('{text}', $text, $output);
    return $output;
}

function get_form_einstell($comment, $index, $einstellwerte, $filename, $counter, $trenn) {
    $template_form_einstell = file_get_contents('template_form_einstell.html');

    $output = str_replace('{comment}', $comment, $template_form_einstell);
    $output = str_replace('{index}',$index, $output);
    $output = str_replace('{einstellwerte}', $einstellwerte, $output);
    $output = str_replace('{filename}', $filename, $output);
    $output = str_replace('{counter}', $counter, $output);
    $output = str_replace('{trenn}', $trenn, $output);
    return $output;
}

function get_einstellzeile($form, $text, $id, $value, $min, $max) {
    $template_einstellzeile = file_get_contents('template_einstellzeile.html');

    $output = str_replace('{form}', $form, $template_einstellzeile);
    $output = str_replace('{text}', $text, $output);
    $output = str_replace('{id}', $id, $output);
    $output = str_replace('{value}', $value, $output);
    $output = str_replace('{min}', $min, $output);
    $output = str_replace('{max}', $max, $output);
    return $output;

}

function get_einstellzeile_trenn() {
    $template_einstellzeile_trenn = file_get_contents('template_einstellzeile_trenn.html');

    return $template_einstellzeile_trenn;
}

function get_form_tty($content) {
    $template_form_tty = file_get_contents('template_form_tty');

    return str_replace('{content}', $content, $template_form_tty);
}

function get_form_baud() {
    $template_form_baud = file_get_contents('template_form_baud.html');

    return $template_form_baud;
}

function get_button_shutdown() {
    $template_button_shutdown = file_get_contents('template_button_shutdown.html');

    return $template_button_shutdown;
}

function get_button_menu($link, $text) {
    $template_button_menu = file_get_contents('template_button_menu.html');

    $output = str_replace('{link}', $link, $template_button_menu);
    $output = str_replace('{text}', $text, $output);
    return $output;
}

function get_license($license) {
    $template_license = file_get_contents('template_license.html');

    return str_replace('{license}', $license, $template_license);
}

function get_license_gpl() {
    $template_license_gpl = file_get_contents('template_license_gpl.html');

    return $template_license_gpl;
}

function get_link_owndocs($path, $filename, $return_success, $return_failure) {
    $template_link_owndocs = file_get_contents('template_link_owndocs.html');

    $output = str_replace('{path}', $path, $template_link_owndocs);
    $output = str_replace('{filename}', $filename, $output);
    $output = str_replace('{return_success}', $return_success, $output);
    $output = str_replace('{return_failure}', $return_failure, $output);
    return $output;
}

function get_button_menu_back() {
    $template_button_menu_back = file_get_contents('template_button_menu_back.html');

    return $template_button_menu_back;
}

function get_form_settings($serial_interfaces, $serial_baudrates, $ordner_docs, $ordner_owndocs, $ordner_einstellwert, $return_success, $return_failure) {
    $template_form_settings = file_get_contents('template_form_settings.html');

    $output = str_replace('{serial_interfaces}', $serial_interfaces, $template_form_settings);
    $output = str_replace('{serial_baudrates}', $serial_baudrates, $output);
    $output = str_replace('{ordner_docs}', $ordner_docs, $output);
    $output = str_replace('{ordner_owndocs}', $ordner_owndocs, $output);
    $output = str_replace('{ordner_einstellwert}', $ordner_einstellwert, $output);
    $output = str_replace('{return_success}', $return_success, $output);
    $output = str_replace('{return_failure}', $return_failure, $output);
    return $output;
}

function get_baudrates() {
    $template_baudrates = file_get_contents('template_baudrates.txt');

    return $template_baudrates;
}

function get_success($text) {
    $template_success = file_get_contents('template_success.html');

    $output = str_replace('{text}', $text, $template_success);
    return $output;
}

function get_failure($text) {
    $template_failure = file_get_contents('template_failure.html');

    $output = str_replace('{text}', $text, $template_failure);
    return $output;
}
?>