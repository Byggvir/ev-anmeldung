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
include_once "../lib/contacts.php" ;

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

<form action="contacts.php" method="post" id="contactform" >

<main class="container">


<?php

filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$DEBUG = false;

// Initialisierung


?>

  
<section class="adminbox">

<h2>Kontaktdaten der Besucher</h2>

<?php 

$contacts = new contact($_POST);

$contacts->list($contacts->id);

 
?>

</section>


</main>
</form>

</body>
</html>
