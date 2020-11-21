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
	
    <title>EvKG Rheinbach: Gottesdienst-Verwalung</title>

</head>

<body>

<h1>EvKG Rheinbach: Besucherverwaltung</h1>

<form action="admin_events.php" method="post" id="eventform" >

<main class="container">


<?php

$DEBUG = false;

// Initialisierung

?>

  
<section class="adminbox">

<h2>Gottesdienste</h2>

<?php 

$events = new event();
$events->list(1);

 
?>

</section>


</main>
</form>

</body>
</html>
