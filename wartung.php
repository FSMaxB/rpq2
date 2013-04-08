<?php
$title = 'Schnittstelle aufnehmen';
$author = 'Max Bruckner';
$heading = 'Schnittstelle aufnehmen';

$ordner = 'tty-logs';		//Ordner, in dem CSV-Sollwerttabellen gespeichert werden. Kann hier global gesetzt werden
$link = 'wartung_link.php';	//Datei mit den Links für die Auflistung der CSV-Sollwerttabellen
$return = 'wartung.php'; 		//Der Name dieser Datei (wichtig für Skripte, die zurückkehren wollen)


include('header_raw.php');
include('heading.php');
?>
<table width="49%" align="left">
 <tr>
  <td>
<?php
include('wartung_form.php');	//Formular für das Starten der Aufnahme
?>
  </td>
 </tr>
</table>
<table width="49%" align="right">
 <tr>
  <td>
<?php
include('list.php');

//Läuft gerade eine Aufnahme?
$result = exec("ps -ef | grep receive | grep -v grep");	//Abfragen einer Liste aller laufenden Prozesse mit receive
if($result != '')	//Wenn ja, Button zum beenden anzeigen
{
	include('wartung_kill.php');	//Button zum Beenden der Aufnahme
}
?>
  </td>
 </tr>
</table>
     <br />
     <div align="center">
      <button onclick="window.location.href='index.php'" style="width:100%">
        <h3 align="center">Zurück zum Hauptmenü</h3>
      </button>
     </div>
<?php
include('footer_raw.php');
?>

