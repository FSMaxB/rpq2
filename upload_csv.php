<?php
$name = str_ireplace('.csv','.csv',$name);	//Ersetzen von '.csv' (Groß- Kleinschreibung egal) durch '.csv' --> Endung anschließend nur klein
if(strpos($name,'.csv',strlen($name)-4)-(strlen($name)-4)!== 0)	//Wenn Falsche Endung: '.csv' anhängen (Dient auch als Sicherheitsmechanismus, damit man keine PHP-Dateien hochladen kann)
	$name = $name . '.csv';
?>
