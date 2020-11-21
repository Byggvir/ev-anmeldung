<?php
/**
 * maillib.php
 *
 * @package default
 */

include_once "lib.php";
include_once "config.php";
include_once "contacts.php";
include_once "events.php";
include_once "tickets.php";


global $AnmeldungTest;

isset($AnmeldungTest) or exit("No direct calls!");


/**
 *
 */
 
 
function SendConfirmMail( $contact , $event , $ticket ) {
    
    global $SITE;

    $to = $contact->EMail;
    $key = $ticket->confirmtoken;
	$datum = DateTimeDEU($event->Starttime);
	
	$message = "
Guten Tag,

zur Sicherheit muss die Anmeldung zum Gottesdienst am

        $datum

bestätigt werden.

Dazu muss der folgenden Link, aufgerufen werden. Eine Anmeldung ver-
fällt, wenn sie nicht spätestens 48 Stunden nach der vollen Stunde 
der Anmeldung bestätigt wurde.

    https://$SITE/confirm.php?key=$key

Mit folgendem Link kann eine Anmeldung widerrufen werden, wenn
der Gottesdienst noch nicht begonnen hat.

    https://$SITE/revoke.php?key=$key

In diesem Fall werden die Daten gelöscht und es ist eine Neuanmeldung
erforderlich.

Ob Sie an einem Gottesdienst teilgenommen haben, ergibt sich nur aus der
Liste (Papier) am Eingang.

Datenschutz:

Wir speichern folgende Daten für die Kontaktverfolgung im Rahmen 
unseres Hygiene- und Infektionschutzkonzeptes auf der Grundlage der
Corona-Schutzverordnung des Landes NRW in der jeweils gültigen Fassung.

    1. Vorname 
    2. Name
    3. Straße und Hausnummer
    4. Postleitzahl
    5. Ort
    6. Telefon
    7. E-Mail

sowie

    8. Angemeldete Gottesdienste

Ihre Kontaktdaten werden vier Wochen nach dem letzten Gottesdienst,
zu dem Sie sich angemeldet haben, gelöscht. Wenn die Daten 1. - 7. bei
den Anmeldungen identisch sind, wird daraus nur ein Kontakt, ansonsten 
ergeben sich für eine Person mehrere Kontakte einträge.

Die Kontaktdaten der Konfirmanden werden erst nach der Konfirmation
gelöscht. Konfirmation können sich mit Vorname und Name anmelden.

Zum Schutz vor Trollen, die massenhafte Anmeldungen generieren,
wird Ihre IP-Adresse unabhängig von Ihren Kontaktdaten gespeichert. D.h. 
eine Zuordnung Name - IP-Adresse ist uns nicht möglich.

Mit freundlichen Grüßen

Thomas Arend
";

    $header = 'From: Anmeldung Gottesdienst <thomas@tux-lt.dyn.byggvir.de>' . "\n" .
    'Reply-To: admin@ev-kircherheinbach.de' . "\n" .
    'X-Mailer: PHP/' . phpversion();

	$subject = "Anmeldung zum Gottesdienst am/um " . $datum;

    if (mail($to, $subject, $message, $header) ) {

	
	}
}


?>