<?php
$directory = opendir($ordner);	//Ordner öffnen

echo "<div style=\"height:400px;width:100%;border:1px solid #ccc;overflow:auto;\">";	//Beginn des scrollbaren Kontainers
//Ordnerinhalt durchgehen und Array mit Dateinamen erstellen
$i = 0;		//Zählvariable
while(TRUE)
{
	$dateiname = readdir($directory);
	if($dateiname !== FALSE)	//Sind noch Dateien übrig?
	{
		if($dateiname != '.' && $dateiname != '..')	//Ausfilterung der Ordner '.' und '..'
		{
			$array[$i] = $dateiname;
			$i++;
		}	
	}
	else break;
}

//sort(&$array);			//Auskommentiert, da es auf dem Raspberry Pi aus unerfindlichen Gründen Fehler verursacht

//Array durchgehen und Links mit Dateinamen erstellen
foreach($array as $dateiname)
	include($link);

echo '</div>';	//Ende des Scrollbaren Containers
?>
