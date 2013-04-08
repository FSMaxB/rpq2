<?php
//Anzuzeigende Datei aus URL-Holen
$pfad = $_GET['pfad'];

$title = "Logdatei anzeigen";
$author = 'Max Bruckner';
$heading = "Logdatei anzeigen";

$return = "wartung_show.php?pfad=$pfad";

include('header_raw.php');
include('heading.php');
include('wartung_show_list.php');	//Logdatei anzeigen

//Läuft gerade eine Aufnahme?
$result = exec("ps -ef | grep receive | grep -v grep");	//Abfragen einer Liste aller laufenden Prozesse mit receive
if($result != '')	//Wenn ja, Button zum beenden anzeigen
{
	include('wartung_kill.php');	//Button zum Beenden der Aufnahme
}
?>
      <button onclick="window.location.href='<?php echo $return;?>'">
        Aktualisieren
      </button>
  </td>
 </tr>
</table>
     <br />
     <div align="center">
      <button onclick="window.location.href='wartung.php'" style="width:100%">
        <h3 align="center">Zurück zu Wartung</h3>
      </button>
     </div>
<?php
include('footer_raw.php');
?>
