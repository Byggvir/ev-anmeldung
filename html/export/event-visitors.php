<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=gottesdienstbesucher.csv');

$AnmeldungTest = "Started";

include_once("../lib/db.php");
include_once("../lib/contacts.php");
include_once("../lib/events.php");

// create a file pointer connected to the output stream
// fetch the data

    if (array_key_exists('event', $_GET)) {
        $eid = $_GET['event'];
    } else {
        $events=new event();
        $events->select('select * from events where CURRENT_TIME <= Starttime limit 1;');
        $events->fetchrow();
        $eid = $events->id;
    }
    
$SQL="select 'Nr', 'Name' , 'Vorname', 'Straße', 'PLZ', 'Ort', 'Telefon', 'E-Mail', 'Bestätigt'  
union all 
( select @i:=@i+1, Name, Firstname, Street, PostalCode, City, Phone, EMail, confirmed from tickets as t join contacts c on t.cid = c.id  where t.eid = " . $eid . " order by c.Name, c.Firstname);" ;
;

$contacts = new evservicesdb();

$contacts->write_csv($SQL);

?>
