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

function upload_form($ordner, $extension, $return_success, $return_failure) {
	$template_form_upload = file_get_contents('template_form_upload.html');
	
	$output = str_replace('{ordner}', $ordner, $template_form_upload);
	$output = str_replace('{return_success}', $return_success, $output);
	$output = str_replace('{return_failure}', $return_failure, $output);
	$output = str_replace('{extension}', $extension, $output);
	
	return $output;
}
?>
