ALLGEMEINE HINWEISE

*Diese Datei soll Ihnen einen Überblick über den Quelltext geben.
*Informationen zur Lizenz des RPQ2-Webinterfaces finden Sie in der Datei COPYING.txt!
*Informationene zur Installation finden Sie in der Datei INSTALL.txt!

ORDNERSTRUKTUR

*dieser Ordner: Hier befindet sich neben den Unterordnern noch die wichtigste Komponente des RPQ2-Webinterfaces: der PHP-Quellcode.
*"bilder": Hier befinden sich die Bilder des Webinterfaces
*"csv": Aufbewahrungsort für CSV-Sollwerttabellen. Der Webserver benötigt Schreibzugriff auf diesen Ordner (siehe INSTALL.txt).
*"docs": Hier lagern die Dokumentationen für den RPQ2-Regler.
*"nativ": Hier befinden sich die nativ programmierten Programmbestandteile des RPQ2-Webinterfaces.
*"regler": Aufbewahrungsort für Regler-Sollwertvorgaben. Der Webserver benötigt Schreibzugriff auf diesen Ordner (siehe INSTALL.txt).

FUNKTION DER EINZELNEN DATEIEN


-header.php-

HTML-Dokumentenkopf, der in fast jeder Seite eingebunden wird.

-heading.php-
Vorlage für die Überschriften in den Untermenüs.

-footer.php-
Das Gegenstück zu "header.php".

-footer_sub.php-
Erweitert "footer.php" um den Button "Zurück ins Hauptmenü".

-index.php-
Zuständig für die Darstellung des Hauptmenüs.

-index_links.php-
Enthält die Buttons des Hauptmenüs. Ist in "index.php" eingebunden.

-csv.php-
Zuständig für die Darstellung des Menüs "CSV-Sollwerttabellen".

-csv_upload.php-
Enthält ein Formular zum Hochladen von Dateien. Ist in "csv.php" eingebunden und ruft zum Upload die datei "upload.php" auf.

-upload.php-
Enthält den Upload-Mechanismus für CSV-Sollwerttabellen. Wird von "csv_upload.php" aufgerufen.

-upload_csv.php-
Wird in "upload.php" eingebunden, wenn nur CSV-Dateien hochgeladen werden können sollen.

-upload_nophp.php-
Wird in "upload.php" eingebunden, wenn das Hochladen von allem außer PHP-Dateien erlaubt werden soll.

-csv_link.php-
Enthält eine Vorlage für einen Link auf CSV-Sollwerttabellen mitsamt Lösch-Funktion (ruft "remove.php" auf) und Konvertierungs-Funktion (ruft "convert.php" auf).

-remove.php-
Löscht Dateien.

-convert.php-
Abfrage, für welchen Regler die gegebene CSV-Sollwerttabelle konvertiert werden soll. Ruft nach Bestätigung "convert_do.php" auf. Wird von "csv_link.php" aufgerufen.

-convert_form.php-
Enthält die Liste mit den Regler-Adressen.

-convert_footer.php-
Erweitert "footer.php" um den Button "Zurück zu CSV-Sollwerttabellen". Wird in "convert.php" eingebunden.

-convert_do.php-
Führt das Programm "nativ/CSV_ASM" zum Konvertieren von CSV-Sollwerttabellen in Regler-Sollwertvorgaben auf. Wird von "convert.php" aufgerufen.

-regler.php-
Zuständig für die Darstellung des Menüs "Regler-Sollwertvorgaben".

-regler_h.php-
Headerdatei von "regler.php".

-regler_link.php-
Enthält eine Vorlage für einen Link auf Regler-Sollwertvorgaben mitsamt Lösch-Funktion (ruft "remove.php" auf) und Übertragungs-Funktion (ruft "submit.php" auf).

-submit.php-
Zuständig für die Darstellung des Menüs für die Schnittstellenkonfiguration.

-submit_footer.php-
Erweitert "footer.php" um einen "Zurück zu Regler-Sollwertvorgaben"-Button. Wird von "submit.php" eingebunden.

-submit_form.php-
Enthält das Grundgerüst des HTML-Formulars für das Menü der Schnittstellenkonfiguration. Wird von "submit.php" eingebunden. Ruft "send.php" auf.

-form_baud.php-
Enthält eine Dropdown-Liste mit den verfügbaren Baudraten. Wird von "submit_form.php" eingebunden.

-form_tty.php-
Zuständig für die Darstellung einer Dropdown-Liste zum Auswählen der Schnittstellen-Datei. Wird von "submit_form.php" eingebunden.

-submit_form_timeout.php-
Enthält eine Dropdown-Liste mit den verfügbaren timeout-delays für die Antwort vom Regler. Wird von "submit_form.php" eingebunden.

-send.php-
Ruft das C-Programm "send" im Ordner "nativ" auf, um Regler-Sollwertvorgaben per serieller Schnittstelle zu übertragen. Wird von "submit_form.php" aufgerufen.

-einstell.php-
Noch nicht implementiert.

-mess.php-
Noch nicht implementiert.

-steuer.php-
Noch nicht implementiert.

-wartung.php-
Noch nicht implementiert.

-docs.php-
Zuständig für die Darstellung des Menüs "Dokumentationen".

-docs_button.php-
Vorlage für die Buttons im Menü "Dokumentationen". Wird von "docs.php" eingebunden.

-list.php-
Erzeugt eine Liste von Dateien mit angegebenen Links. Wird von "csv.php" und "regler.php" eingebunden.

-shutdown.php-
Wird vom Hauptmenü aus aufgerufen und führt den Systembefehl "shutdown -h now" aus, um den Rechner herunterzufahren.

-license.php-
Enthält die Lizenzbedingungen.

-license_gpl.php-
Enthält die GPL v. 3. Wird in license.php eingebunden.

-owndocs.php-
Zuständig für die Darstellung des Menüs "Eigene Dokumentationen".

-owndocs_upload.php-
Enthält ein Formular zum Hochladen von Dateien. Ist in "owndocs.php" eingebunden und ruft zum Upload die datei "upload.php" auf.

-owndocs_link.php-
Enthält eine Vorlage für einen Link auf eigene Dokumentationen mitsamt Lösch-Funktion (ruft "remove.php" auf).
