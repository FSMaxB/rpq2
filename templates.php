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

function get_wartung($file_list, $comment, $send, $received) {
    $template_wartung = file_get_contents('template_wartung.html');

    $output = str_replace('{file_list}', $file_list, $template_wartung);
    $output = str_replace('{comment}', $comment, $output);
    $output = str_replace('{send}', $send, $output);
    $output = str_replace('{received}', $received, $output);
    return $output;
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

function get_page_header($content, $current) {
    $template_page = file_get_contents('template_page_header.html');

    $output = str_replace('{content}', $content, $template_page);
    $output = str_replace('{current}', $current, $output);
    return $output;
}

function get_link_einstell($ordner, $filename, $return_success, $return_failure) {
    $template_link_einstell = file_get_contents('template_link_einstell.html');

    $output = str_replace('{ordner}', $ordner, $template_link_einstell);
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

function get_container($content, $height = '400px', $border = '1px', $id = 'div') {
    $template_container = file_get_contents('template_container.html');

    $output = str_replace('{content}', $content, $template_container);
    $output = str_replace('{height}', $height, $output);
    $output = str_replace('{border}', $border, $output);
    $output = str_replace('{id}', $id, $output);
    return $output;
}

function get_button($link, $text) {
    $template_button = file_get_contents('template_button.html');

    $output = str_replace('{link}', $link, $template_button);
    $output = str_replace('{text}', $text, $output);
    return $output;
}

function get_form_einstell($comment, $regler, $index, $einstellwerte, $filename) {
    $template_form_einstell = file_get_contents('template_form_einstell.html');

    $output = str_replace('{comment}', $comment, $template_form_einstell);
    $output = str_replace('{regler}', $regler, $output);
    $output = str_replace('{index}',$index, $output);
    $output = str_replace('{einstellwerte}', $einstellwerte, $output);
    $output = str_replace('{filename}', $filename, $output);
    return $output;
}

function get_einstellzeile($number, $form, $id, $value, $skal, $komma, $text) {
    $template_einstellzeile = file_get_contents('template_einstellzeile.html');

    $output = str_replace('{number}', $number, $template_einstellzeile);
    $output = str_replace('{form}', $form, $output);
    $output = str_replace('{id}', $id, $output);
    $output = str_replace('{value}', $value, $output);
    $output = str_replace('{skal}', $skal, $output);
    $output = str_replace('{komma}', $komma, $output);
    $output = str_replace('{text}', $text, $output);
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

function get_link_docs($ordner, $filename, $return_success, $return_failure) {
    $template_link_docs = file_get_contents('template_link_docs.html');

    $output = str_replace('{ordner}', $ordner, $template_link_docs);
    $output = str_replace('{filename}', $filename, $output);
    $output = str_replace('{return_success}', $return_success, $output);
    $output = str_replace('{return_failure}', $return_failure, $output);
    return $output;
}

function get_button_menu_back() {
    $template_button_menu_back = file_get_contents('template_button_menu_back.html');

    return $template_button_menu_back;
}

function get_form_settings($serial_interfaces, $serial_baudrates, $ordner_docs, $ordner_einstell_mess, $ordner_wartung, $ordner_log, $ordner_pdo, $return_success, $return_failure) {
    $template_form_settings = file_get_contents('template_form_settings.html');

    $output = str_replace('{serial_interfaces}', $serial_interfaces, $template_form_settings);
    $output = str_replace('{serial_baudrates}', $serial_baudrates, $output);
    $output = str_replace('{ordner_docs}', $ordner_docs, $output);
    $output = str_replace('{ordner_einstell-mess}', $ordner_einstell_mess, $output);
    $output = str_replace('{ordner_wartung}', $ordner_wartung, $output);
    $output = str_replace('{ordner_log}', $ordner_log, $output);
    $output = str_replace('{ordner_pdo}', $ordner_pdo, $output);
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

function get_form_editor($text, $ordnerlist, $filename) {
    $template_form_editor = file_get_contents('template_form_editor.html');

    $output = str_replace('{text}', $text, $template_form_editor);
    $output = str_replace('{ordnerlist}', $ordnerlist, $output);
    $output = str_replace('{filename}', $filename, $output);
    return $output;
}

function get_form_einstellzeile($number, $line, $type) {
    $template_form_einstellzeile = file_get_contents('template_form_einstellzeile.html');

    $output = str_replace('{number}', $number, $template_form_einstellzeile);
    $output = str_replace('{line}', $line, $output);
    $output = str_replace('{type}', $type, $output);
    return $output;
}

function get_vspace() {
    $template_vspace = file_get_contents('template_vspace.html');

    return $template_vspace;
}

function get_link_mess($ordner, $filename, $return_success, $return_failure) {
    $template_link_mess = file_get_contents('template_link_mess.html');

    $output = str_replace('{ordner}', $ordner, $template_link_mess);
    $output = str_replace('{filename}', $filename, $output);
    $output = str_replace('{return_success}', $return_success, $output);
    $output = str_replace('{return_failure}', $return_failure, $output);
    return $output;
}

function get_link_wartung($filename, $ordner, $return_success, $return_failure) {
    $template_link_wartung = file_get_contents('template_link_wartung.html');

    $output = str_replace('{filename}', $filename, $template_link_wartung);
    $output = str_replace('{ordner}', $ordner, $output);
    $output = str_replace('{return_success}', $return_success, $output);
    $output = str_replace('{return_failure}', $return_failure, $output);
    return $output;
}

function get_script_mess($filename) {
    $template_script_mess = file_get_contents('template_script_mess.html');

    $output = str_replace('{filename}', $filename, $template_script_mess);
    return $output;
}

function get_mess($comment, $container) {
    $template_mess = file_get_contents('template_mess.html');

    $output = str_replace('{comment}', $comment, $template_mess);
    $output = str_replace('{container}', $container, $output);
    return $output;
}

function get_zeile_mess_get($text, $skal, $proz, $hex, $bin) {
    $template_zeile_mess_get = file_get_contents('template_zeile_mess_get.html');

    $output = str_replace('{text}', $text, $template_zeile_mess_get);
    $output = str_replace('{skal}', $skal, $output);
    $output = str_replace('{proz}', $proz, $output);
    $output = str_replace('{hex}', $hex, $output);
    $output = str_replace('{bin}', $bin, $output);
    return $output;
}

function get_mess_get($contents) {
    $template_mess_get = file_get_contents('template_mess_get.html');

    $output = str_replace('{contents}', $contents, $template_mess_get);
    return $output;
}

function get_mess_edit($comment, $regler, $messwerte, $filename) {
    $template_mess_edit = file_get_contents('template_mess_edit.html');

    $output = str_replace('{comment}', $comment, $template_mess_edit);
    $output = str_replace('{regler}', $regler, $output);
    $output = str_replace('{messwerte}', $messwerte, $output);
    $output = str_replace('{filename}', $filename, $output);
    return $output;
}

function get_zeile_mess_edit($number, $pos, $skal, $komma, $skalproz, $proz, $hex, $bin, $text) {
    $template_zeile_mess_edit = file_get_contents('template_zeile_mess_edit.html');

    $output = str_replace('{number}', $number, $template_zeile_mess_edit);
    $output = str_replace('{pos}', $pos, $output);
    $output = str_replace('{skal}', $skal, $output);
    $output = str_replace('{komma}', $komma, $output);
    $output = str_replace('{skalproz}', $skalproz, $output);
    $output = str_replace('{proz}', $proz, $output);
    $output = str_replace('{hex}', $hex, $output);
    $output = str_replace('{bin}', $bin, $output);
    $output = str_replace('{text}', $text, $output);
    return $output;
}

function get_button_inline($link, $text) {
    $template_button_inline = file_get_contents('template_button_inline.html');

    $output = str_replace('{link}', $link, $template_button_inline);
    $output = str_replace('{text}', $text, $output);
    return $output;
}

function get_link_logs($filename, $ordner, $return_success, $return_failure) {
    $template_link_logs = file_get_contents('template_link_logs.html');

    $output = str_replace('{filename}', $filename, $template_link_logs);
    $output = str_replace('{ordner}', $ordner, $output);
    $output = str_replace('{return_success}', $return_success, $output);
    $output = str_replace('{return_failure}', $return_failure, $output);
    return $output;
}

function hex($input, $digits) {
	if ($input == '')
		return('');
	$string = NULL;
	for($i = 0; $i < $digits; $i++) {
		$string .= '0';
	}
	
	$string .= dechex($input);
	return substr($string, strlen($string) - $digits);
}

function get_pdo_mapping($comment, $received, $command, $regler, $map_high, $map_low, $map_index, $mapped_high, $mapped_low, $mapped_index) {
	$template_pdo_mapping = file_get_contents('template_pdo_mapping.html');
	
	$output = str_replace('{comment}', $comment, $template_pdo_mapping);
 	$output = str_replace('{received}', $received, $output);
 	$output = str_replace('{command}', $command, $output);
 	$output = str_replace('{regler}', $regler, $output);
 	$output = str_replace('{map_high}', $map_high, $output);
 	$output = str_replace('{map_low}', $map_low, $output);
 	$output = str_replace('{map_index}', $map_index, $output);
 	$output = str_replace('{mapped_high}', $mapped_high, $output);
 	$output = str_replace('{mapped_low}', $mapped_low, $output);
 	$output = str_replace('{mapped_index}', $mapped_index, $output);
	return $output;
}

function get_link_pdo($filename, $ordner) {
	$template_link_pdo = file_get_contents('template_link_pdo.html');
	
	$output = str_replace('{ordner}', $ordner, $template_link_pdo);
	$output = str_replace('{filename}', $filename, $output);
	return $output;
}
?>
