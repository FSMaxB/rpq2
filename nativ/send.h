//Folgender define ersetzt einige Funktionen durch thread-sichere Varianten
#define _REENTRANT

//Für den Einsatz in PHP kompilieren
#define PHP

//Fehlercodes
#define ERFOLGREICH 		0
#define ERFOLGREICH_ADRESSE	1	//Übertragung Erfolgreich, aber falsche Adresse
#define FEHLER			2
#define FEHLER_ADRESSE		3	//Übertragung fehlgeschlagen + Antwort von falscher Adresse
#define MIST			4
#define TIMEOUT			5

//Übertragungs-(Fehler-)Meldungen
#define ERFOLGREICH_M		"Übertragung an Regler %i erfolgreich abgeschlossen.\n"
#define ERFOLGREICH_ADRESSE_M	"ERROR: Übertragung erfolgreich abgeschlossen, aber falsche Regleradresse: %i\n"
#define FEHLER_M		"ERROR: Übertragung an Regler %i fehlerhaft.\n"
#define FEHLER_ADRESSE_M	"ERROR: Übertragung fehlerhaft und Antwort von Regler mit falscher Adresse: %i\n"
#define MIST_M			"ERROR: Ungültige Antwort.\n"
#define TIMEOUT_M		"ERROR: Zeitüberschreitung.\n"
#define IMPOSSIBLE_M		"ERROR: Diese Meldung sollte nicht erscheinen, wenn doch, dann ist etwas gehörig schiefgelaufen!\n"

//Fehlermeldungen bei Argumenten
#define E_SYNTAX	"ERROR: Falsche Syntax!\n"
#define E_INPUT		"ERROR: Eingabedatei \"%s existiert nicht, oder es fehlen die Berechtigungen!\n"
#define E_OUTPUT	"ERROR: Ausgabedatei \"%s\" ist ungültig!\n"
#define E_ADRESSE	"ERROR: Regleradresse \"%s\" ist ungültig!\n"
#define E_TIMEOUT	"ERROR: Ungültiger timeout-delay: %s\n"

//Antwortstrings
#define S_ERFOLGREICH	"OK"
#define	 S_FEHLER	"NO"

//Standardwert für TIMEOUT_DELAY
#define TIMEOUT_DELAY	2

//Einstellen der Fehlerausgabe. Die PHP-Funktion system() nimmt Ausgaben von stderr nicht entgegen!
#ifdef PHP
	#define ERROR_STREAM	stdout
#else
	#define ERROR_STREAM	stderr
#endif

//Sonstiges
#define DELAY1_STEP	4		//Anzahl der Zeichen, nach denen ein Delay kommt
#define DELAY1		2		//Delay in ms
#define DELAY2_STEP	40		//Anzahl der Zeichen, nach denen ein Delay kommt (DELAY2_STEP sollte ein vielfaches von DELAY1_STEP sein)
#define DELAY2		10		//Delay in ms


void *empfange_antwort();
int pruefe_argumente(int argc, char *args[]);
int pruefe_status();
void send();
