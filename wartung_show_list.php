<div style="height:500px;width:100%;border:1px solid #ccc;overflow:auto;">
<?php
$dateistream = fopen($pfad, "r");	//Logdatei zum Lesen öffnen
echo nl2br(fread($dateistream, filesize($pfad)));	//Logdatei ausgeben (mit html-Zeilenumbrüchen)
fclose($dateistream);
?>
</div>
