<form action="send.php" method="get">
<?php
include('form_baud.php');		//Baudraten-Liste einbinden
include('submit_form_timeout.php');	//Timeout-Delay-Liste einbinden
include('form_tty.php');		//Lister der Verfügbaren Schnittstellen einbinden
echo "<input type=\"hidden\" name=\"input\" value=\"$pfad\" />\n";		//Dateinamen mitschicken
echo "<input type=\"hidden\" name=\"return_success\" value=\"einstell.php\" />\n";	//Wert für automatische Weiterleitung bei Erfolg mitschicken
echo "<input type=\"hidden\" name=\"return_failure\" value=\"submit.php?pfad=$pfad&modus=einstell\" />\n"; //Wert für automatische Weiterleitung bei Fehler mitschicken
include('form_adresse.php');	//Adresse des Reglers
echo "<input type=\"submit\" value=\"Übertragen\">\n";	//Button zum Aufrufen von "send.php" mit den entsprechenden Parametern
?>
</form>
