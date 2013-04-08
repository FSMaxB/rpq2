<form action="send.php" method="get">
<?php
include('form_baud.php');		//Baudraten-Liste einbinden
include('submit_form_timeout.php');	//Timeout-Delay-Liste einbinden
include('form_tty.php');		//Lister der Verfügbaren Schnittstellen einbinden
echo "<input type=\"hidden\" name=\"input\" value=\"$pfad\" />\n";		//Dateinamen mitschicken
echo "<input type=\"hidden\" name=\"return_success\" value=\"regler.php\" />\n";	//Wert für automatische Weiterleitung bei Erfolg mitschicken
echo "<input type=\"hidden\" name=\"return_failure\" value=\"submit.php?pfad=$pfad&adresse=$adresse&modus=sollwert\" />\n"; //Wert für automatische Weiterleitung bei Fehler mitschicken
echo "<input type=\"hidden\" name=\"adresse\" value=\"$adresse\" />\n";	//Adresse des Reglers
echo "<input type=\"submit\" value=\"Übertragen\">\n";	//Button zum Aufrufen von "send.php" mit den entsprechenden Parametern
?>
</form>
