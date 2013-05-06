<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="author" content="Max Bruckner">
  <title>Lizenzbedingungen</title>
 </head>
 <body>
  <table border="0" width="100%" align="center" bgcolor="#B7DEE8">
   <tr>
    <td>
     <h1 align="left">&ensp;RPQ2&emsp;Messen - Steuern - Regeln&emsp;Webinterface</h1>
    </td>
    <td>
     <img src="bilder/Innowatt.png" align="right" alt="[Innowatt Logo]" title="Innowatt Energiesysteme GmbH">
    </td>
   </tr>
  </table>
  <h1 align="center">Lizenzbedingungen</h1>
  <table border="0" width="50%" align="left">
   <tr>
    <td>
<p>
Folgender Hinweis bezieht sich auf das gesamte RPQ2-Webinterface mit Ausnahme des Innowatt-Logos (<tt>bilder/Innowatt.png</tt>), des Fotos des RPQ2-Reglers (<tt>bilder/RPQ2.jpg</tt>), des Bildes Zum Herunterfahren (<tt>bilder/shutdown.png</tt>) und dem Programm CSV_ASM zum Konvertieren von CSV-Sollwerttabellen in Regler-Sollwertvorgaben (<tt>nativ/CSV_ASM.armv6-hf</tt>, <tt>nativ/CSV_ASM.x86</tt>, <tt>nativ/CSV_ASM.x86_64</tt>).
</p>
<div style="border:1px solid #ccc">
<tt>
    <p>
    Copyright &copy; 2012  Innowatt Energiesysteme GmbH<br />
    Autor: Max Bruckner
    </p>
    <p>
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.
    </p>
    <p>
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    </p>
    <p>
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <a href="http://www.gnu.org/licenses/">http://www.gnu.org/licenses/</a>.
    </p>
</tt>
</div>

<p>
<a href="http://www.gnu.de/documents/gpl-3.0.de.html">Hier</a> finden sie eine inoffizielle (daher nicht rechtsgültige) deutsche Übersetzung der GNU General Public License version 3.
</p>
<p>
Den Quellcode des RPQ2-Webinterfaces finden Sie <a href="source.zip">hier</a>.
</p>
<p>
<b>Herunterfahren-Bild</b> (Lizenz: GNU General Public License version 2 oder jede spätere Version):<br />
<a href="http://upload.wikimedia.org/wikipedia/commons/5/57/Gnome-system-shutdown.svg">http://upload.wikimedia.org/wikipedia/commons/5/57/Gnome-system-shutdown.svg</a>
</p>
<p>
<b>Innowatt-Logo:</b>
Copyright &copy; xxxx Innowatt Energiesysteme GmbH, alle Rechte Vorbehalten. Es ist gestattet, das Logo einzusetzen, solange mit dem Webinterface ein Gerät der Firma Innowatt Energiesysteme GmbH gesteuert wird.
</p>
<p>
<b>Foto des RPQ2-Reglers:</b>
Copyright &copy; 2012 Innowatt Energiesysteme GmbH, alle Rechte Vorbehalten. Es ist gestattet, das Foto einzusetzen, solange mit dem Webinterface ein RPQ2-Regler der Firma Innowatt Energiesysteme GmbH gesteuert wird.
</p>
<p>
<b>CSV_ASM:</b>
Copyright &copy; 2012 Innowatt Energiesystem GmbH. Die veröffentlichung dieses Programms erfolgt ohne jeglich Gewährleistung. Die Weiterverbreitung in binärer Form ist gestattet.
</p>
<p>
<b>Raspberry Pi&#8482; is a trademark of the Raspberry Pi Foundation</b>
</p>
<p>
Wird dieses Webinterface auf einem anderen Computer als dem Raspberry Pi&#8482; installiert, so sollten alle Hinweise auf denselbigen entfernt werden (in den Dateien <tt>footer.php</tt> und <tt>license.php</tt>)
</p>
<p>
	<b>SICHERHEITSHINWEIS</b>
</p>
<p>
	Dieses Webinterface sollte unter KEINEN UMSTÄNDEN über das Internet zugänglich gemacht werden, es ist nur für die Verwendung in einem lokalen Netzwerk vorgesehen. Es wurden keinerlei Maßnahmen zur Absicherung gegen Attacken und Manipulation getroffen, weshalb eine Anbindung an das Internet einen potenziellen Angriffsvektor für die Übernahme des gesamten internen Netzwerks durch Unbefugte darstellt.
</p>
     </td>
    </tr>
  </table>
  <table width="50%" align="right">
   <tr> 
    <td width="50%">
     <?php include('license_gpl.php');?>
    </td>
   </tr>
  </table>
<button onclick="window.location.href='index.php'" style="width:100%">
        <h3 align="center">Zum Hauptmenü</h3>
</button>
<?php
include('footer_raw.php');
?>
