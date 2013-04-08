<form action="receive.php" method="POST">
<input type="hidden" name="return_success" value="<?php echo $return;?>" />
<input type="hidden" name="return_failure" value="<?php echo $return;?>" />
<input type="hidden" name="ordner" value="<?php echo $ordner;?>" />
<div align="center"><textarea name="befehl" cols="50" rows="20"></textarea><br /></div><br />
<?php
include('form_baud.php');
echo '&emsp;';
include('form_tty.php');
echo "<br />\n<br />\n";
?>
<input type="radio" name="logmode" value="w" checked />Logdatei überschreiben&ensp;
<input type="radio" name="logmode" value="a" />Logdatei weiterführen
<br /><br />
<?php include('wartung_form_maxchars.php');?><br />
<?php include('wartung_form_maxtime.php');?><br />
Dateiname:&ensp;<input type="text" name="datei" size="30" maxlength="30" />.log&emsp;
<input type="submit" value="Aufnahme starten" />
</form>
<br />
