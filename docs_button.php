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
    
    --------------------docs_button.php-----------------------------
    Enthält das Design der Buttons, mit dem die Dokumentationen ange-
    zeigt werden.
*/
?>

<button onclick="window.location.href='<?php echo "$docs_ordner/$dateiname";?>'" style="width:100%">
  <h3 align="center"><?php echo $dateiname;?></h3>
</button>
