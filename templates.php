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

//TODO die mehrfachen Aufrufe von str_replace lassen sich vermeiden, indem man arrays verwendet

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

function get_page($content) {
	$template_page = file_get_contents('template_page.html');
	
	return str_replace('{content}', $content, $template_page);
}

function get_link_sollwert($path, $filename, $return) {
	$template_link_sollwert = file_get_contents('template_link_sollwert.html');
	
	$output = str_replace('{path}', $path, $template_link_sollwert);
	$output = str_replace('{filename}', $filename, $output);
	$output = str_replace('{return}', $return, $output);
	return $output;
}

function get_link_einstelltab($path, $filename, $return) {
	$template_link_einstelltab = file_get_contents('template_link_einstelltab.html');
	
	$output = str_replace('{path}', $path, $template_link_einstelltab);
	$output = str_replace('{filename}', $filename, $outpu);
	$output = str_replace('{return}', $return, $output);
	return $output;
}

function get_link_csv($path, $return, $filename) {
	$template_link_csv = file_get_contents('template_link_csv.html');
	
	$output = str_replace('{path}', $path, $template_link_csv);
	$output = str_replace('{filename}', $filename, $output);
	$output = str_replace('{return}', $return, $output);
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
	$output = str_replace('{extensin}', $extension, $output);
	$output = str_replace('{return_success}', $return_success, $output);
	$output = str_replace('{return_failure}', $return_failure, $output);
	return $output;
}

function get_convert_form($path) {
	$template_convert_form = file_get_contents('template_convert_form.html');
	
	return str_replace('{path}', $path, $template_convert_form);
}

function get_container($content) {
	$template_container = file_get_contents('template_container.html');
	
	return str_replace('{content}', $content, $template_container);
}

function get_button($link, $text) {
	$template_button = file_get_contents('template_button.html');
	
	$output = str_replace('{link}', $link, $template_button);
	$output = str_replace('{text}', $text, $output);
	return $output;
}

?>
