<a href="<?php echo "wartung_show.php?pfad=$ordner/$dateiname";?>"><?php echo $dateiname;?></a>
(<?php
//Dateigröße ausgeben
$dummy = escapeshellcmd("$ordner/$dateiname");
$result = explode("\t", exec("du -h $dummy"));
echo $result[0];
?>)
&ensp;<a href="remove.php?pfad=<?php echo "$ordner/$dateiname";?>&amp;return=<?php echo $return;?>">[Löschen]</a>

<br />
