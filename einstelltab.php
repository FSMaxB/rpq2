<?php
/*
    RPQ2-Webinterface
    
    Copyright (C) 2012 Innowatt Energiesysteme GmbH
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

$title = 'Einstellwerttabellen verwalten';
$author = 'Max Bruckner';
$heading = 'Einstellwerttabellen verwalten';

$ordner = 'einstell';			//Ordner, in dem die CSV-Einstellwerte gespeichert werden
$link = 'einstelltab_link.php';	//Datei mit den Links für die Auflistung der CSV-Einstellwerte
$return = 'einstelltab.php';		//Diese Seite, um hierher zurückkehren zu können
$include = 'upload_csv.php';	//Datei, die in upload.php eingebunden werden soll (zum Verarbeiten der Dateiendungen)


include('header.php');
include('heading.php');
include('upload_form.php');		//Einbinden des Upload-Formulars
include('list.php');			//Auflistung der Dateien
include('footer_sub.php');
?>
