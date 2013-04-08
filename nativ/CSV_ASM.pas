// Programm wandelt Exel Datei in Assembler-Datei um
// Es werden Leerzeichen und Leerzeilen ignoriert
// Achtung Exel-Datei als .csv (Dos csv) abspeichern


program CSV_ASM;

//{$MODE Delphi}

//{$APPTYPE CONSOLE}
uses
  SysUtils;
var
In_Datei,Aus_Datei,Aus_Datei2           : TextFile;
Zeile                                   : string;
Zeile2                                  : string;
Verzeichnis                             : string;
AddrRegler                              : string;
strDatei                                : string;
strInDatei                              : string;
strMeldungDatei                         : string;
strTempDatei                            : string;
IntAddrRegler                           : integer;
NeueZeile                               : integer;
Fehler                                  : integer;
Position                                : integer;
PosSp                                   : integer;
i                                       : integer;
index                                   : integer;
IndexArray                              : integer;
Int_Abschlusszeile                      : integer;
strIndex                                : string;
NaechsteTabelle                         : boolean;
ArrayParam                              : array[1..30] of Integer;
Z_Zeile                                 : integer;
CRC                                     : integer;
Z_Komma                                 : integer;

Procedure LeseZeile;
Begin
  repeat
    readln(In_Datei,Zeile);
    Zeile := Trim(Zeile);
  until ((Zeile <> '') or eof(In_Datei));
  if (eof(In_Datei)and (Zeile = '')) then exit;
  repeat
     PosSp := Pos(',',Zeile);
     if (PosSp > 0) then
       Zeile[PosSp] := '!'
  until  (PosSp = 0);
  //---------------------------------------------
  repeat
     PosSp := Pos(';',Zeile);
     if (PosSp > 0) then
       Zeile[PosSp] := ','
  until  (PosSp = 0);
  Position :=  Pos(',',Zeile);
  Zeile2 := Copy(Zeile,0,Position-1);
  Delete(Zeile,1,Position-1);
  val(Zeile2,NeueZeile,Fehler);
  Int_Abschlusszeile := NeueZeile;
  if (NeueZeile <> -1) then
  Begin
    str(NeueZeile,Zeile2);
  End
  Else
  Begin
    Zeile2 := '-1';
    NaechsteTabelle := true;
  End;
  Zeile := Zeile2+Zeile;
  str(index,strIndex);

  if (Int_Abschlusszeile = -1) then
  Begin
     inc(IndexArray);
     inc(index);
  End;
End;

Procedure Init;
Begin
  index := 0;
  IndexArray := 1;
  NaechsteTabelle := false;
  CRC := 0;
End;


Procedure ErzeugeMakro;
Begin
  i := 1;
  repeat
    Position :=  Pos(',',Zeile);
    Zeile2 := Copy(Zeile,0,Position-1);
    Delete(Zeile,1,Position);
    val(Zeile2,NeueZeile,Fehler);
    if (Fehler = 0) then
    Begin
       ArrayParam[i] := NeueZeile;
       inc(i);
       Z_Komma := i;
    End
    Else
    if Position <> 0then
    Begin
        PosSp := Pos('!',Zeile2);
        if (PosSp > 0) then
          Zeile2[PosSp] := ',';
        writeln('Eingabefehler in Zeile ',Z_Zeile,' Spalte ',i,' -> ',Zeile2);
        writeln('ERROR ','Eingabefehler in Zeile ',Z_Zeile,' Spalte ',i,' -> ',Zeile2);
        close(Aus_Datei);
        Erase(Aus_Datei);
        halt(1);
     End;
  until  (Position = 0);

  if (Z_Komma <  ((IntAddrRegler * 6)+2)) then
  Begin
        writeln('ERROR ','Regler ',IntAddrRegler,' nicht in CSV-Datei');
        close(Aus_Datei);
        Erase(Aus_Datei);
        halt(1);
  End;

  val(Zeile,NeueZeile,Fehler);
  if (Fehler = 0) then
    ArrayParam[i] := NeueZeile;

  write(Aus_Datei,hexStr(ArrayParam[1],4),',');
  write(Aus_Datei,hexStr(ArrayParam[2],4),',');
  i := 3 + ((IntAddrRegler-1)*6);
  Begin
    write(Aus_Datei,hexStr(ArrayParam[i],4),',',hexStr(ArrayParam[i+1],4),',');
    write(Aus_Datei,hexStr(ArrayParam[i+2],4),',',hexStr(ArrayParam[i+3],4),',');
    writeln(Aus_Datei,hexStr(ArrayParam[i+4],4),',',hexStr(ArrayParam[i+5],4));
  End;
End;

Begin
  Init;

  if (ParamCount = 3) then
       Verzeichnis := ''
  else
      Verzeichnis := Paramstr(4);

  strDatei :=  Paramstr(2);
  AddrRegler := Paramstr(3);
  val(AddrRegler,IntAddrRegler,Fehler);
  Position :=  Pos('.csv',strDatei);
  strDatei := Copy(Paramstr(2),0,Position-1);
  strMeldungDatei := 'SK_RPQ_'+ AddrRegler+'_'+ strDatei + '.rpq';
  strDatei := Verzeichnis + strMeldungDatei;
  strTempDatei := Verzeichnis + 'tmp.a30';

  if ParamCount < 3 then
  Begin
     writeln;
     Writeln('ERROR call: Input Verzeichnis CSV_ASM Verzeichnis Inputfile Inputfile Adresse Regler Verzeichnis Output');
     halt(1);
  End;

//  writeln('Converter  CSV zu Regler Sollwertkurve');
//  writeln('Input: ',Paramstr(1));
  writeln('Output: ',strDatei);

  strInDatei := Paramstr(1) + Paramstr(2);

  assign(In_Datei,strInDatei);
  assign(Aus_Datei,strTempDatei);
  assign(Aus_Datei2,strDatei);

  Try
     reset(In_Datei);
  Except
     writeln;
     Writeln('ERROR File ',Paramstr(1),' not found');
     halt(1);
  End;
  rewrite(Aus_Datei);
  readln(In_Datei,Zeile); // Entferne Ueberschrift
  LeseZeile;

  Z_Zeile := 2;
  ErzeugeMakro;
  inc(Z_Zeile,1);
  repeat
    LeseZeile;
    if (eof(In_Datei) and (Zeile = ''))  then
     break;

    if  ((NaechsteTabelle) AND (NeueZeile <> -1)) then
    Begin
       NaechsteTabelle := false;
    END;
    ErzeugeMakro;
    inc(Z_Zeile,1);

  until ((eof(In_Datei)) or (NaechsteTabelle));
  writeln(Aus_Datei,'ENDE');

  dec(IndexArray);
  rewrite(Aus_Datei2);

  close(Aus_Datei);
  reset(Aus_Datei);
  writeln(Aus_Datei2,'//cmd,Ind,SInd, Lng, CRC,0000,0000,0000');
  writeln(Aus_Datei2,'//ms,Dout, Soll, P  , I  , D  , St , Q  ');
  write(Aus_Datei2,'sk',hexStr(IntAddrRegler,2),',3014',',0001,');
  writeln(Aus_Datei2,hexStr(Z_Zeile-2,4),',',hexStr(CRC,4),',0000,0000,0000');

  repeat
     readln(Aus_Datei,Zeile);
     writeln(Aus_Datei2,Zeile);
  until eof(Aus_Datei);

writeln(Paramstr(1),' erfolgreich zu ',strMeldungDatei,' konvertiert');

  close(In_Datei);
  close(Aus_Datei);
  close(Aus_Datei2);
  Erase(Aus_Datei);

end.
