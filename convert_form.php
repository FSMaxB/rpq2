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
    
    --------------------convert_form.php-----------------------------
    Enthält das Formular mit den Konvertierungseinstellungen und dem
    Aufruf der Konvertierfunktion (convert_do.php). Dieses Formular
    kommt in convert.php zum Einsatz.
*/
?>

<form action="convert_do.php" method="get">
<?php 
include('form_adresse.php');	//Einbinden des Formulars mit den Regler-Adressen
?>
 <input type="hidden" name="input" value="<?php echo $pfad;?>">
 <input type="hidden" name="return_success" value="regler.php">
 <input type="hidden" name="return_failure" value="convert.php?pfad=<?php echo $pfad;?>">
 <input type="submit" value="Konvertieren">
</form>
