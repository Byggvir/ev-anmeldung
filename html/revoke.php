<!DOCTYPE html>
<html lang="de-DE" class="no-js">

<?php

/*
 * Autor: Thomas Arend
 * Stand: 30.12.2018
 *
 * Better quick and dirty than perfect but never!
 *
/* Security token to detect direct calls of included libraries. */ 

$AnmeldungTest = "Started";

include_once "lib/lib.php" ;

include_once "lib/db.php" ;
include_once "lib/tickets.php" ;

$DEBUG = FALSE;
$message = "";
$debugmsg = "";

filter_var_array($_GET, FILTER_SANITIZE_SPECIAL_CHARS);

if (array_key_exists('key', $_GET)) {
    $key = $_GET['key'];
}
else {
    $key = 0;
}


?>

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
	
    <title>EvKP Rheinbach: Bestätigen der Gottesdienst-Abmeldung</title>

</head>

<body>

<main class="container">

<section class="box">
<?php

    $t = new ticket();
    preg_match('/^[0-9a-f]{32}$/', $key,$matches);

    if ( $t->revoke($key)) {

 ?>
        <p class="success">Abmeldung erfolgreich!</p>


<?php

 } else {
 ?>
        <p class="failure">Die Abmeldung konnte nicht bestätigt werden!<br />Sie waren zu keinem Gottesdienst angemeldet.</p>
        <address>
            <p>Alternativ können Sie im Büro unter <a href="tel:+4922264760">02226-4760</a> anrufen.
            </p>
        </address>

<?php
 }
?>



</section>
</main>


</body>
</html>
