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
    
    --------------------kill.php------------------------------------
    Beendet Prozesse
*/
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="author" content="Max Bruckner">
  <title>Prozess beenden</title>
<?php
$prozess = escapeshellcmd($_POST['prozess']);		//Name des zu killenden prozesses
$return_success = $_POST['return_success'];
$return_failure = $_POST['return_failure'];


//Dirty code, wenn www-data die entsprechenden Rechte dazu hat, läuft der Prozess nicht mehr, aber die ausgegebene Meldung ist nicht immer richtig
exec("killall -15 $prozess");		//nettes killen
sleep(2);
exec("killall -9 $prozess");		//böses killen

//Wenn Erfolgreich: Automatische Weiterleitung nach 1 Sekunde und Meldung ausgeben
echo "<meta http-equiv=\"refresh\" content=\"1; URL=$return_success\">";
echo "</head>\n<body>";
echo "$prozess beendet!";

?>
</body>
</html>
