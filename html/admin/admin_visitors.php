<!DOCTYPE html>
<?php

/*
 * Autor: Thomas Arend
 * Stand: 30.12.2018
 *
 * Better quick and dirty than perfect but never!
 *
/* Security token to detect direct calls of included libraries. */ 

$AnmeldungTest = "Started";

include_once "../lib/db.php" ;
include_once "../lib/events.php" ;
include_once "../lib/visitors.php" ;

$DEBUG = FALSE;
$message = "";
$debugmsg = "";


?>

<html lang="de-DE" class="no-js">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="expires" content="0"> 
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="pragma" content="no-cache">
	<meta name="theme-color" content="#00dd00">
	<meta name="description" content="Gottesdienstanmeldung ev. Kirche Rheinbach">
	<meta name="keywords" lang="de" content="Gottesdienst,Rheinbach,Anmeldung,Evangelische Kirche">
	<meta name="format-detection" content="telephone=yes">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	
    <title>EvKG Rheinbach: Rheinbach: Besucherverwaltung</title>

</head>

<body>


<h1>EvKG Rheinbach: Besucherverwaltung</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="adminform" >

<main class="container">


<section class="box adminbox">

<h2>Liste der Gottesdienste</h2>
<p>Zum Anzeigen der Besucher Gottesdienst auswählen und auf <strong>Besucherliste</strong> klicken.</p>

<p><strong>Exportieren</strong> (rechts) lädt eine CSV-Datei der Besucher für Excel / LibreOffice Calc herunter.
</p>
<div class="menue">
<div class="menuebutton">
<button id="OK"
    name="OK"
    type="submit"
    value="OK"
    style="color: green; font-weight: bold;">Besucherliste &gt;&gt;</button>
</div>
</div>
<fieldset>

<?php

    $events = new event();
  
    if (array_key_exists('event', $_POST)) {
        $eid = $_POST['event'];
    }
    else {
        $SQL = "SELECT * FROM events ORDER BY Starttime LIMIT 1;";
        $events->select($SQL);
        $events->fetchrow();
        $eid = $events->data['id'];
    }
  
    $events->list($eid);
  
  
?>

</fieldset>
</section>

  
<section class="box adminbox">

<h2>Besucherliste</h2>

<?php 

    $evt = new event();
    $evt->look_up($eid);
    $start = new DateTime($evt->Starttime);
    $downloadlink = "../export/event-visitors.php?event=" .$evt->id;
    print ('<p>' . $evt->Title . ': ' . $start->format('d. M Y H:i') . ' Uhr <a href="' . $downloadlink . '">Exportieren</a></p>' . PHP_EOL);
    
    unset($evt);
    

$visitors = new visitor();

if (! empty($eid) ) {
    $visitors->list($eid);
}

unset($visitors);

?>

</section>
<?php 

if ($DEBUG) {

?>

<section class="box debug">

<p>
<?php 
    print($debugmsg);
?>

</p>

</section>

<?php
}
?>

  


</main>
</form>

</body>
</html>
