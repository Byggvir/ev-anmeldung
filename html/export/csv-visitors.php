<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=gottesdienste.csv');

$AnmeldungTest = "Started";

include_once("../lib/db.php");
include_once("../lib/events.php");

// create a file pointer connected to the output stream
// fetch the data

    
$SQL="select 'Id', 'Vorname' , 'Name', 'Straße', 'PLZ', 'Ort', 'Telefon', 'E-Mail'
union all 
( select id, Firstname, Name, Street, PostalCode, City, Phone, EMail from contacts order by Name, Firstname, EMail );" ;
;

$contacts = new evservicesdb();

$contacts->write_csv($SQL);

?>
