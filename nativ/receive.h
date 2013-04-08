//Folgender define ersetzt einige Funktionen durch thread-sichere Varianten
#define _REENTRANT

//Für den Einsatz in PHP kompilieren
#define PHP

//Einstellen der Fehlerausgabe. Die PHP-Funktion system() nimmt Ausgaben von stderr nicht entgegen!
#ifdef PHP
	#define ERROR_STREAM	stdout
#else
	#define ERROR_STREAM	stderr
#endif

//(FHELER)MELDUNGEN
#define E_BEFEHL		"ERROR: Befehldatei \"%s\" ist ungültig.\n"
#define E_TTY			"ERROR: Schnittstellendatei \"%s\" ist ungültig.\n"
#define E_LOGFILE		"ERROR: Aufnahmedatei \"%s\" ist ungültig.\n"
#define E_APPEND		"ERROR: Ungültiger Dateischreibemodus.\n"
#define E_MAX_CHARS		"ERROR: Ungültige Zahl maximal aufzunehmender Zeichen.\n"
#define E_TIME			"ERROR: Maximaler Aufnahmezeitraum ungültig.\n"
#define E_SYNTAX		"ERROR: Ungültige Syntax.\n"
#define M_TIME			"Aufnahme beendet, da Zeit abgelaufen!\n"
#define M_CHARS			"Aufnahme beendet, da maximale Zeichenzahl erreicht.\n"
#define M_KILLED		"Aufnahme beendet, da Prozess manuell beendet.\n"

//Status des Threads
#define RUNNING		1
#define FINISHED	0
#define UNDEFINED	2

int pruefe_argumente();
void sende_befehl();
void* record();
void clean();
void killed(int sig);
