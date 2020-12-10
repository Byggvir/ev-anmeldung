<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=gottesdienste.csv');

$AnmeldungTest = "Started";

include_once("../lib/db.php");
include_once("../lib/events.php");

// create a file pointer connected to the output stream
// fetch the data

    
$SQL="select 'Id', 'Begin' , 'Ende', 'Titel', 'Untertitel', 'Ort', 'Besucher'
union all 
( select e.id, Starttime, Endtime, Title, Subtitle, Place, count(t.eid) from events as e left join tickets as t on t.eid=e.id group by t.eid order by Starttime );" ;
;

$contacts = new evservicesdb();

$contacts->write_csv($SQL);

?>
