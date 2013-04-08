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
    
    --------------------index_links.php-----------------------------
    Liste der Links (Buttons) zu den Einzelnen Untermenüs.
*/
?>

<div align=center>
  <button onclick="window.location.href='csv.php'" style="width:100%">
    <h2 align="center">CSV-Sollwerttabellen</h2>
  </button>
  <br />
  <button onclick="window.location.href='regler.php'" style="width:100%">
    <h2 align="center">Regler-Sollwertvorgaben</h2>
  </button>
  <br />
  <button onclick="window.location.href='einstell.php'" style="width:100%">
    <h2 align="center">CSV-Einstellwerte</h2>
  </button>
  <br />
  <button onclick="window.location.href='mess.php'" style="width:100%">
    <h2 align="center">Messwerte</h2>
  </button>
  <br />
  <button onclick="window.location.href='steuer.php'" style="width:100%">
    <h2 align="center">Steuerung</h2>
  </button>
  <br />
  <button onclick="window.location.href='docs.php'" style="width:100%">
    <h2 align="center">Innowatt-Dokumentationen</h2>
  </button>
  <br />
  <button onclick="window.location.href='owndocs.php'" style="width:100%">
    <h2 align="center">Eigene Dokumentationen</h2>
  </button>
  <br />
  <br />
  <a href="shutdown-menu.php"><img src="bilder/shutdown.png" alt="[Herunterfahren]" title="Herunterfahren"></a>
</div>
