  <form enctype="multipart/form-data" action="upload.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    <input type="hidden" name="ordner" value="<?php echo $ordner;?>" />
    <input type="hidden" name="return_success" value="<?php echo $return;?>" />
    <input type="hidden" name="return_failure" value="<?php echo $return;?>" />
    <input type="hidden" name="include" value="<?php echo $include;?>" />
    <input name="datei" type="file" />
    <input type="submit" value="Hochladen" />
  </form>
