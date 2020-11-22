# ev-anmeldung
Web-Seite zur Verwaltung der Anmeldungen zum Gottesdienst

# Vorbemerkung

Es handelt sich um eien Quick and Dirty Lösung und nicht alles - besser fast nichts ist fertig und ausgereift. Der Kern, die Anmeldung der Besucher zum Gottesdienst funktioniert. Die Administration im Hintergrund erfordert, aber noch Handarbeit. Als Beispiel sei das Anlegen neuer Gottesdienste per SQL-Befehl genannt.

# Zweck

Diese Web-Seite ist für die Anmeldung zu den Gottesdiensten der Evangelischen Kirchengemeinde Rheinbach unter den Hygiene- und Infektionsschutzmaßnahmen geschrieben. Mit kleinen Anpassungen lässt sie sich für andere Gemeinden verwenden.

# Installation

1.  Download des git  mit *git clone  https://github.com/Byggvir/ev-anmeldung.git*
2.  Kopieren des Inhaltes des Ordners *html* ins (Wurzel-)Verzeichnis des Host. Beispiel: *sudo cp -ru html/* /var/www/html*
3.  Anpassen der Datei *lib/config.conf* mit der Adresse der SITE und der Datenbankverbindung.
4.  Anlegen einer Datei für den Passwordschutz der Verzeichnisse mit *htpasswd [ -c ] <u>.htpasswd</u> <u>username</u>* für
    *   *admin*
    *   *export*
5.  Anlegen und Anpassen der Datei *.htaccess* in den Verzeichnissen
    *   *admin*
    *   *export*

# Aufbau der Anwendung

## Anmelden

Die Besucher melden sich über eine Seite in vier Schritten zu einem Gottesdienst an:

1.  Eingabe der Kontaktdaten
2.  Auswahl der Gottesdienstes aus einer Liste
3.  Abschicken des Formulars
4.  Bestätigen durch Aufrufend es Links und er E-Mail

In der E-Mail ist ein Link enthalten, um die Meldung zu löschen.

Mehrere Familienmitglieder können durch Trennen der Vornamen mit "," angemeldet werden. Es wird jedoch für jedes Familienmitglied ein Ticket erzeugt und eine E-Mail mit einem Bestätigungslink verschickt. Bei vier Familienmitgliedern werden vier E-Mails verschickt und jeder Teilnehmer muss durch Aufrufen des Links in der E-Mail bestätigt werden. Es wird für alle Familienmitglieder dieselbe E-Mail-Adresse gespeichert.

Eine Benutzerverwaltung gibt es nicht. Es werden nur Kontaktdaten gespeichert. Im Prinzip kann jeder jeden mit beliebigen Kontaktdaten anmeden.

Für jeden Gottesdienstbesuch wird ein Ticket mit der Id des Gottesdienstes und des Besuchers gespeichert, sowie ein Token und den Gotetsdienst zu bestätigen oder die Teilnahme abzusagen.

# Teilnehmerlisten

Die Teilnehmerliesten  zum Ausrucken werden durch einen Export / Import einer CSV-Datei in Excel oder LibeOffice Calc erzeugt.

# Daten(bank)

Die Datenband verwendet vier Tabellen:

*   contacts
*   events
*   eventgroups (noch nicht genutzt)
*   tickets

## Tabelle *contacts*

In der Tabelle *contacts* werden die Kontaktdaten der Besucher gespeichert.

*   Id (Interne Id des Datensatzes)
*   PIN (Zufallszahl, derzeit nicht genutzt)
*   Vorname
*   Name
*   Straße
*   PLZ
*   Ort
*   Telefon
*   E-Mail
*   Konfirmand (Ja/Nein)

Zwei Kontakte sind gleich, wenn die obigen Werte byte-gleich sind. D.h. *Thomas Arend Zingsheimstr 31 ...* ist nicht gleich *Thomas Arend Zingsheimstr<u>aße</u>31 ...*. Wer bei einer weiteren Anmeldung nur ein Zeichen ändert, erzeugt einen neuen Kontakt. Füllzeichen werden allerdings getrimmt.

Die Telefonnummer wird in die internationalen Schreibweise *+49...* konvertiert.

Dazu kommen technische Felder, wie zum Beispiel ein  Zeitstempel der letzten Änderung des Eintrages. Damit wird bestimmt, wann der Eintrag zu lsöchen ist.

## Tabelle *events*

In der Tabele *events* werden die Gottesdienste gespeichert.

*   Id (Interne Id des Datensatzes)*   Startzeit
*   Endzeit
*   Titel
*   Untertitel
*   Ort
*   Plätze
*   Reservierte Plätze
*   Maximale Gruppen (Noch nicht genutzt)

## Tabelle *tickets*

In der Tabelle *tickets* werden die Anmeldungen gespeichert. D.h die Datensätze enthalten die Id des Kontaktes und des Gottesdienstes.

*   Id (Interne Id des Datensatzes)
*   Interne Id des Eventdatensatzes
*   Interne Id des Kontaktesdatensatzes
*   Reserviert (derzeit ungenutzt) 
*   Bestätigt (J/Nein)
*   Bestätigungstoken
*   Zeitstemptel

# Caveats

* Installation unterhalb von WordPress in einem eigenen Verzeichnis führt uner Umständen zum Aufruf falscher Seiten.

# ToDo

    * Cron-Job zum regelmäßigen Löschen.
    * Admin-Seiten erweitern