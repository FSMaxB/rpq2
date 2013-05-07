<?php
function get_files($ordner) {
	$file_list = scandir($ordner);
	
	foreach ( $file_list as $datei ) {
		if( strpos($datei, '.') !== 0 ) //Ausfiltern aller versteckter Dateien
			$files[] = $datei;
	}
	
	return $files;
}
?>
