<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=gottesdienstbesucher.csv');

$AnmeldungTest = "Started";

include_once("../lib/db.php");
include_once("../lib/contacts.php");

// create a file pointer connected to the output stream
// fetch the data

    if (array_key_exists('event', $_GET)) {
        $eid = $_GET['event'];
    } else {
        $eid = 0;
    }
  
$contacts = new evservicesdb();
$contacts->write_csv("select Name, Firstname as Vorname, Street as 'Straße', PostalCode as PLZ, City as Ort, Phone as Telefon, EMail as 'E-Mail', confirmed as 'Bestätigt' from tickets as t join contacts c on t.cid = c.id where t.id = ". $eid . " oder by Name;");

?>
