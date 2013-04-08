<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="author" content="Max Bruckner">
  <title>Datei hochladen</title>
<?php
//Variablen per POST holen
$ordner = $_POST['ordner'];
$return_success = $_POST['return_success'];	//Seite, auf die im Erfolgsfall umgeleitet wird
$return_failure = $_POST['return_failure'];	//Seite, auf die im Fehlerfall umgeleitet wird
$include = $_POST['include'];	//Name der einzubindenden Datei


$name = $_FILES['datei']['name'];		//Ursprünglicher Dateiname der hochgeladenen Datei
include($include);		//Einbinden der Datei, die sich um die Dateiendungen Kümmert
$ziel = "$ordner/$name";


if(move_uploaded_file($_FILES['datei']['tmp_name'],$ziel))	//Datei Hochladen und Abfragen ob es geklappt hat
{
	//Wenn erfolgreich, leite nach 1 Sekunde automatisch um und gebe Meldung aus
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=$return_success\">";
	echo "</head>\n<body>";
	echo "Datei \"{$_FILES['datei']['name']}\" erfolgreich hochgeladen.";
}
	else
	{
		//Wenn nicht erfolgreich, leite nach 3 Sekunden automatisch um und gebe Meldung aus
		echo "<meta http-equiv=\"refresh\" content=\"3; URL=$return_failure\">";
		echo "</head>\n<body>";
		echo "Beim Hochladen der Datei \"{$_FILES['datei']['name']}\" ist ein Fehler aufgetreten.";
	}

?>
  </body>
</html>
