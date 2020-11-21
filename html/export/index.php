<!DOCTYPE html>
<?php

/*
 * Autor: Thomas Arend
 * Stand: 21.12.2020
 *
 * Better quick and dirty than perfect but never!
 *
/* Security token to detect direct calls of included libraries. */ 

$AnmeldungTest = "Started";

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
	<link rel="stylesheet" type="text/css" href="css/style.css">
	
    <title>EvKG Rheinbach-Admin</title>

</head>

<body>
<h1>Datenexport für die Gottesdienstanmeldungen</h1>

<h2>Listen</h2>

<ol>
<li>Kontakte <a href="csv-contacts.php" target="_blank"> &gt;&gt;</a></li>
<li>Gottesdienste <a href="csv-events.php" target="_blank"> &gt;&gt;</a></li>
<li>Angemeldete Besucher des nächsten Gottesdienstes <a href="csv-events-visitors.php" target="_blank"> &gt;&gt;</a></li>
</ol>

</body>
</html>
