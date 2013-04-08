<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="author" content="Max Bruckner">
  <title>System herunterfahren</title>
 </head>
 <body>
<?php
$status = $_GET['status'];

if($status == 'reboot')
{
	$param = '-r';
	$message = '<h1>Das System wird neu gestartet!</h1>';
}
else if($status == 'halt')
{
	$param = '-h';
	$message = '<h1>Das System wird heruntergefahren</h1>';
}
else
{
	$message = 'Ungültige Option';
}

system("/sbin/shutdown $param now");		//Systembefehl zum Herunterfahren ausführen
echo $message;
?>
</body>
</html>
