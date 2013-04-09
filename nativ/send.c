//Beim kompilieren muss man folgende Optionen angeben:
//"-lpthread": sagt dem Linker, dass der die pthread-Library verlinken soll

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <pthread.h>
#include <ctype.h>
#include <time.h>
#include "send.h"

//globale Variablen
FILE* input;						//Pointer der zu schickenden Datei
FILE* output;						//Pointer der Schnittstelle im Schreibmodus
FILE* f_antwort;					//Pointer der Schnittstelle im Lesemodus
int status = TIMEOUT;				//Fehlerstatus mit TIMEOUT vorbelegt -> ist dieser Wert am Ende immer noch gesetzt, so wurde der Thread abgebrochen, bevor er ihn ändern konnte
int timeout = TIMEOUT_DELAY;		//Setzen des Standardwertes für den timeout
int adresse;				//Regleradresse
int adresse_antwort;			//Adresse des Reglers, der geantwortet hat



int main(int argc, char *args[])
{
	pthread_t thread;				//Thread zum Empfangen der Antworts

    if(pruefe_argumente(argc,args)==EXIT_FAILURE)
	{
		return EXIT_FAILURE;
	}

	send();

	//Schnittstelle schließen
	fclose(output);

	f_antwort = fopen(args[2],"r");				//Schnittstelle im Lesemodus öffnen
	pthread_create(&thread, NULL, empfange_antwort, NULL);	//Thread zum Empfangen der Antwort starten
	pthread_detach(thread);					//Speicher nach Beendigung des Threads automatisch freigeben

	//Abwarten bis TIMEOUT oder Antwort von Regler
	int i;
	for(i=0;i<timeout;i++)
	{
		if(status != TIMEOUT)
			break;
		sleep(1);			//Schlafe 1s
	}

	if(status == TIMEOUT)
		pthread_cancel(thread);		//Wenn Zeit abgelaufen und immer noch keine Antwort, Thread killen
	fclose(f_antwort);			//letzte Datei schließen
	fclose(input);	//Schließen des Inputs aus Zeitgründen nach hinten verlegt

	if(pruefe_status()==EXIT_FAILURE)
		return EXIT_FAILURE;
	return EXIT_SUCCESS;
}

/*------------------------------------------------------------------------------*/
void send()
{
	//Übergabeparameter für nanosleep
	struct timespec delay1;
	delay1.tv_sec = (int) DELAY1 / 1000;			//Sekunden aus DELAY
	delay1.tv_nsec = (DELAY1 % 1000) * 1000000;	//Milisekunden aus DELAY
	//Übergabeparameter für nanosleep
	struct timespec delay2;
	delay2.tv_sec = (int) DELAY2 / 1000;			//Sekunden aus DELAY
	delay2.tv_nsec = (DELAY2 % 1000) * 1000000;	//Milisekunden aus DELAY
	
	signed char puffer;
	int i = 0;						//Zählvariable

	//Datei verschicken bis EOF
	while(1)
	{
		puffer = fgetc(input);
		//Rausfiltern von Kommentaren
		if(puffer=='/')
		{
			while(1)
			{
				puffer = fgetc(input);
				if(puffer == '\n')
				{
					puffer = fgetc(input);	//somit stammt das Zeichen im Puffer aus der neuen Zeile
					break;
				}
				else if(puffer == EOF)
					break;
			}
		}

		if(puffer == EOF)
			break;
		if(isalnum(puffer))					//Nur Zahlen und Buchstaben werden weitergegeben
		{
			fputc(puffer, output);
			fflush(output);
			i++;
			if(i % DELAY1_STEP == 0)			//Alle DELAY_STEP zeichen wird DELAY ms geschlafen
				nanosleep(&delay1, NULL);
			if(i % DELAY2_STEP == 0)			//Alle DELAY_STEP zeichen wird DELAY ms geschlafen
				nanosleep(&delay2, NULL);
		}
	}

}

/*------------------------------------------------------------------------------*/
//Überprüfen der Argumente
int pruefe_argumente(int argc, char *args[])
{
		//Überprüfen der Zahl der Argumente, wenn Falsch, abbrechen
	if(argc == 5)
	{
		timeout = atoi(args[4]);
	}
		else if(argc != 4)
		{
			fprintf(ERROR_STREAM, E_SYNTAX);
			return EXIT_FAILURE;
		}

	//Öffnen und überprüfen der Eingabedatei, wenn nicht vorhanden, abbrechen
	input = fopen(args[1],"r");
	if(input == NULL)
	{
		fprintf(ERROR_STREAM, E_INPUT, args[1]);
		return EXIT_FAILURE;
	}

	//Öffnen und überprüfen der Ausgabedatei, wenn nicht gültig, abbrechen
	output = fopen(args[2],"w");
	if(output == NULL)
	{
		fprintf(ERROR_STREAM, E_OUTPUT, args[2]);
		fclose(input);
		return EXIT_FAILURE;
	}

	//Überprüfen der Regleradresse, wenn ungültig, abbrechen
	adresse = atoi(args[3]);
	if(adresse <= 0)
	{
		fprintf(ERROR_STREAM, E_ADRESSE, args[3]);
		fclose(output);
		fclose(input);
		return EXIT_FAILURE;
	}

	//Überprüfen des Timeouts, wenn ungültig, abbrechen
    	if(timeout<=0)
	{
		fprintf(ERROR_STREAM, E_TIMEOUT, args[3]);
		fclose(output);
		fclose(input);
		return EXIT_FAILURE;
	}

	return EXIT_SUCCESS;
}

/*------------------------------------------------------------------------------*/
//Entgegennehmen der Antwort (läuft in eigenem Thread).
void* empfange_antwort()
{
	//Konstruktion um die Länge des längsten Antwortstrings herauszufinden
	int max_laenge;					//Maximallänge einer Antwort
	if(sizeof(S_ERFOLGREICH)<sizeof(S_FEHLER))
			max_laenge = sizeof(S_FEHLER) + 4;	//+4: Adresszeichen 1, Adresszeichen 2, \n und \0
		else max_laenge = sizeof(S_ERFOLGREICH) + 4;

	char s_antwort[max_laenge];			//Puffer (dank max_laenge immer lang genug für den längsten Antwortstring)
	int i;						//Zählvariable

	//Leseschleife
	for(i=0;i<max_laenge;i++)	//Gehe solange durch, bis Puffer voll oder '\n'
	{
		s_antwort[i] = fgetc(f_antwort);
		if(s_antwort[i] == '\n')
		{
			s_antwort[i+1] = '\0';		//Null-Terminierung des Pufferstrings
			break;
		}
	}

	//Abfrage des Pufferinhaltes
	if(strncmp(s_antwort,S_ERFOLGREICH,sizeof(S_ERFOLGREICH)-1) == 0)
	{
		char s_adresse[3];
			s_adresse[0] = s_antwort[sizeof(S_ERFOLGREICH)];
			s_adresse[1] = s_antwort[sizeof(S_ERFOLGREICH)+1];
			s_adresse[2] = '\0';
		adresse_antwort = atoi(s_adresse);
		if(adresse_antwort==adresse)
			status = ERFOLGREICH;
			else
				status = ERFOLGREICH_ADRESSE;
	}
		else if(strncmp(s_antwort,S_FEHLER,sizeof(S_FEHLER)-1) == 0)
		{
			char s_adresse[3];
				s_adresse[0] = s_antwort[sizeof(S_FEHLER)];
				s_adresse[1] = s_antwort[sizeof(S_FEHLER)+1];
				s_adresse[2] = '\0';
			adresse_antwort = atoi(s_adresse);
			if(adresse_antwort==adresse)
				status = FEHLER;
				else
					status = FEHLER_ADRESSE;
		}
		else
			status = MIST;			//MIST ^= Schnittstellenmüll / Falscher Befehl
}

/*------------------------------------------------------------------------------*/
//überprüft den Status der Übertragung
int pruefe_status()
{
	//Status der Übertragung ausgeben
	switch(status)
	{
		case ERFOLGREICH:
		{
			printf(ERFOLGREICH_M, adresse_antwort);
			return EXIT_SUCCESS;
		}
		case ERFOLGREICH_ADRESSE:
		{
			fprintf(ERROR_STREAM, ERFOLGREICH_ADRESSE_M, adresse_antwort);
			return EXIT_FAILURE;
		}
		case FEHLER:
		{
			fprintf(ERROR_STREAM, FEHLER_M, adresse_antwort);
			return EXIT_FAILURE;
		}
		case FEHLER_ADRESSE:
		{
			fprintf(ERROR_STREAM, FEHLER_ADRESSE_M, adresse_antwort);
			return EXIT_FAILURE;
		}
		case MIST:
		{
			fprintf(ERROR_STREAM, MIST_M);
			return EXIT_FAILURE;
		}
		case TIMEOUT:
		{
			fprintf(ERROR_STREAM, TIMEOUT_M);
			return EXIT_FAILURE;
		}
		default:
		{
			fprintf(ERROR_STREAM, IMPOSSIBLE_M);
			return EXIT_FAILURE;

		}
	}
}
