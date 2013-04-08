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
    
    --------------------csv.php------------------------------------
    Stellt das Menü CSV-Sollwerttabellen dar.
*/

$title = 'CSV-Sollwerttabellen';
$author = 'Max Bruckner';
$heading = 'CSV-Sollwerttabellen';

$ordner = 'csv';		//Ordner, in dem CSV-Sollwerttabellen gespeichert werden. Kann hier global gesetzt werden
$link = 'csv_link.php';	//Datei mit den Links für die Auflistung der CSV-Sollwerttabellen
$return = 'csv.php'; 		//Der Name dieser Datei (wichtig für Skripte, die zurückkehren wollen)
$include = 'upload_csv.php';	//Einzubindende Datei für die richtige Dateiendung beim hochladen.

include('header.php');
include('heading.php');
include('upload_form.php');	//Einbinden des Upload-Formulares
include('list.php');		//Einbinden der Auflistung von CSV-Sollwerttabellen
include('footer_sub.php');
?>
