//Aufruf: ./receive tty logfile append max_chars max_time [befehl]

#include <stdio.h>
#include <stdlib.h>
#include <pthread.h>
#include <unistd.h>
#include <string.h>
#include <signal.h>
#include "receive.h"

//Dateipointer
FILE* befehl;
FILE* logfile;
FILE* tty;

int status = UNDEFINED;		//Status des Aufnahmethreads

pthread_t thread;	//Aufnahmethread

unsigned long int max_chars;	//Maximale Zahl an aufzuzeichnenden Zeichen
unsigned long int max_time;					//Zeit, nach der die Aufnahme beendet wird


int main(int argc, char *argv[])
{

	//Sighandler einrichten
	signal(SIGINT, killed);		//Abfangen von STRG+C
	signal(SIGTERM, killed);	//Abfangen von kill -15

	if(pruefe_argumente(argc, argv)==EXIT_FAILURE)
		return EXIT_FAILURE;

	if(argc == 7)
		sende_befehl();
	fclose(tty);		//Schnittstelle im Schreibmodus beenden
	tty = fopen(argv[1], "r");	//Schnittstelle im Lesemodus öffnen

	//Aufnahmethread starten
	pthread_create(&thread, NULL, record,NULL);
	pthread_detach(thread);

	//Warteschleife, bis Zeit abgelaufen
	for(/*dummy*/; max_time > 0; max_time--)
	{
		sleep(1);
	}

	//Aufnahmethread beenden
	pthread_cancel(thread);
	printf(M_TIME);

	clean();		//Aufräumen

	return EXIT_SUCCESS;
}

//----------------------------------------------------------------------
int pruefe_argumente(int argc, char *argv[])
{
	//PRÜFEN DER ARGUMENTE
	//Stimmt die Zahl der angegebenen Argumente?
	if(argc != 6 && argc != 7)
	{
		fprintf(ERROR_STREAM, E_SYNTAX);
		return EXIT_FAILURE;
	}
	//Lässt sich die Schnittstelle öffnen?
	tty = fopen(argv[1],"w");
	if(tty == NULL)
	{
		fprintf(ERROR_STREAM, E_TTY, argv[1]);
		return EXIT_FAILURE;
	}
	//Ist der Dateischreibemodus richtig angegeben?
	if(strcmp(argv[3],"a") != 0 && strcmp(argv[3],"w") != 0)
	{
		fprintf(ERROR_STREAM, E_APPEND);
		fclose(tty);
		return EXIT_FAILURE;
	}
	//Lässt sich das Logfile erstellen
	logfile = fopen(argv[2],argv[3]);
	if(logfile == NULL)
	{
		fprintf(ERROR_STREAM, E_LOGFILE, argv[2]);
		fclose(tty);
		return EXIT_FAILURE;
	}
	//Ist die Zahl der aufzunehmenden Zeichen richtig angegeben?
	max_chars = atol(argv[4]);
	if(max_chars <= 0)
	{
		fprintf(ERROR_STREAM, E_MAX_CHARS);
		fclose(logfile);
		fclose(tty);
		return EXIT_FAILURE;
	}
	//Ist der maximal Aufnahmezeitraum richtig angegeben?
	max_time = atol(argv[5]);
	if(max_time <= 0)
	{
		fprintf(ERROR_STREAM, E_TIME);
		fclose(logfile);
		fclose(tty);
		return EXIT_FAILURE;
	}
	//Ist eine Befehlsdatei angegeben, wenn ja, überprüfen!
	if(argc == 7)
	{
		befehl = fopen(argv[6],"r");
		if(befehl == NULL)
		{
			fprintf(ERROR_STREAM, E_BEFEHL, argv[6]);
			fclose(logfile);
			fclose(tty);
			return EXIT_FAILURE;
		}
	}
	return EXIT_SUCCESS;
}

//------------------------------------------------------------------
void sende_befehl()
{
	signed char puffer;

	//Gebe Befehle auf Schnittstelle aus
	while(1)
	{
		puffer = fgetc(befehl);
		if(puffer != EOF)
			fputc(puffer, tty);
		else
			break;
	}
	fclose(befehl);		//Befehl-Datei schließen
}

//--------------------------------------------------------------------
void* record()
{
	signed char puffer;

	//Schnittstelle aufnehmen, bis maximale Zeichenzahl erreicht.
	for(/*dummy*/; max_chars > 0; max_chars--)
	{
		puffer = fgetc(tty);
		fputc(puffer, logfile);
		fflush(logfile);	//Puffer leeren
	}

	printf(M_CHARS);
	clean();	//Aufräumen
}

//---------------------------------------------------------------------
void clean()
{
	//geöffnete Dateien schließen
	fclose(tty);
	fclose(logfile);

	exit(EXIT_SUCCESS);
}

//----------------------------------------------------------------------
void killed(int sig)
{
	printf(M_KILLED);
	pthread_cancel(thread);
	clean();
}
