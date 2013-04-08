<form action="kill.php" method="POST">
 <input type="hidden" name="return_failure" value="<?php echo $return;?>" />
 <input type="hidden" name="return_success" value="<?php echo $return;?>" />
 <input type="hidden" name="prozess" value="receive" />
 <input type="submit" value="Aufnahme beenden" />
</form>
