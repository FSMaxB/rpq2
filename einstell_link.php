<?php
/*
    RPQ2-Webinterface
    
    Copyright (C) 2012 Innowatt Energiesysteme GmbH
    Author: Max Bruckner
    
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see http://www.gnu.org/licenses/.
    
    --------------------einstell_link.php-----------------------------
    Link der für jede Datei in der Liste von CSV-Einstellwerten zum 
    Einsatz kommt.
*/
?>

<a href="<?php echo "$ordner/$dateiname";?>"><?php echo $dateiname;?></a>
&ensp;<a href="remove.php?pfad=<?php echo "$ordner/$dateiname";?>&amp;return=<?php echo $return;?>">[Löschen]</a>
&ensp;<a href="submit.php?pfad=<?php echo "$ordner/$dateiname";?>&modus=einstell">[Übertragen]</a>

<br />
