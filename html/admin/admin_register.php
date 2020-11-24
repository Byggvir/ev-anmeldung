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
include_once "../lib/contacts.php" ;
include_once "../lib/tickets.php" ;

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
<?php 


    if (array_key_exists('signin', $_POST)) {
        $signin = $_POST['signin'];
    }
    else {
        $signin = "";
    }
    
    $C = new contact($_POST);
    
    if (array_key_exists('contact', $_POST)) {
        $CSQL = 'SELECT * FROM contacts where id = ' . $_POST['contact'] . ';';
    } 
    else {
        $CSQL = 'SELECT * FROM contacts ORDER BY Name, Firstname LIMIT 1;';
    }
    
    error_log($CSQL);
        
    $C->select($CSQL);
    $C->fetchrow();

    $E = new event();
  
    if (array_key_exists('event', $_POST)) {
        $ESQL = 'SELECT * FROM events where id = ' . $_POST['event'] . ';';
    }
    else {
        $ESQL = "SELECT * FROM events ORDER BY Starttime LIMIT 1;";
    }

    $E->select($ESQL);
    $E->fetchrow();
    
    if ( ! empty($signin) and empty($_POST['event']) ) {
        $message .= "Kein Gottesdienst ausgewählt"; 
    } else {
        if ( ! empty($signin) and empty($_POST['contact']) ) {
        $message .= "Kein Besucher ausgewählt"; 
    } else {

	switch ($signin) {

	case "OK" :

			$error = $C->check_contact();
			if ($error == "" ) {
				
				$message .= $C->add_ticket($E) . '<br />';

				} else {

				$message .= "Fehlende oder unzulässige Daten in " . $error . '<br />';
			}

		break;

	}
}

}
?>


<h1>EvKG Rheinbach: Besucherverwaltung</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="adminform" >

<main class="container">


<section class="box visitorbox">

<h2>Liste der regelmäßigen Gottesdienst-Besucher</h2>

<fieldset>

<?php 

    $C->list($C->id);
    
?>

</fieldset>


</section>

<section class="box eventbox">

<h2>Liste der Gottesdienste</h2>

<fieldset>

<?php

    $E->list($E->id,$long=FALSE);
  
?>

</fieldset>

<div class="menuebutton">
<button id="signin"
    name="signin"
    type="submit"
    value="OK"
    style="color: green; font-weight: bold;">Anmelden</button>
</div>
</div>
<div class="message" style="height: 3em;">
<?php
if ( $message != "" ) {

	echo '<p>' . $message . '</p>';

}
?>
</div>

</section>

</main>

</form>

</body>
</html>
