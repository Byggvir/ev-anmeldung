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
<h1>Administration der Gottesdienstanmeldungen</h1>

<p>Besucher anmelden: <a href="admin_register.php" target="_blank"> &gt;&gt;</a></p>

<h2>Listen</h2>

<ol>
<li>Kontakte <a href="admin_contacts.php" target="_blank"> &gt;&gt;</a></li>
<li>Gottesdienste <a href="admin_events.php" target="_blank"> &gt;&gt;</a></li>
    <ol>
        <li>und angemeldete Besucher <a href="admin_visitors.php" target="_blank"> &gt;&gt;</a></li>
    </ol>
</ol>

</body>
</html>
