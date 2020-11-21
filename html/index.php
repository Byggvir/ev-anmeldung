<?php
/**
 * index.php
 *
 * @package default
 */


?>
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
include_once "lib/events.php" ;
include_once "lib/contacts.php" ;
include_once "lib/tickets.php" ;

$DEBUG = FALSE;
$message = "";
$debugmsg = "";

filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);


$event = new event();
if (array_key_exists('event', $_POST) and is_numeric($_POST['event'])) {
	$eid = $_POST['event'];
	$event->look_up($eid);
} else {
	$event->look_up(NULL);
	$eid=$event->id;
}


if (array_key_exists('signin', $_POST)) {
	$signin = $_POST['signin'];
}
else {
	$signin = "";
}

$PARAMS = $_POST;

if (array_key_exists('Firstname', $PARAMS)) {
	$Firstnames = explode(',', $PARAMS['Firstname']);
}

$C = new contact();
$C->set($PARAMS);


if ( ! empty($signin) and empty($eid) ) {
	$message .= "Kein Gottesdienst ausgewählt";
} else {

	switch ($signin) {

	case "OK" :

		$temp = $C->Firstname;
		foreach ($Firstnames as $value) {
			$C->id = NULL;

			$C->Firstname = trim($value);
			$message .= $value.": ";
			$error = $C->check_contact();
			if ($error == "" ) {
				$message .= $C->add_contact($event) . '<br />';
			} else {

				$message .= "Fehlende oder unzulässige Daten in " . $error . '<br />';
			}
		}
		$C->Firstname = $temp;

		break;

	case "Konfirmand" :
		$message .= $C->add_konfi($event);
		break;

	}
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

    <title>Gottesdienst-Anmeldung Evangelische Kirchengemeinde Rheinbach</title>

</head>

<body>

<div id="header" class="page-header">
<div class="page-logo">
<img src="images/logo.png" alt="Logo Ev. KG Rheinbach" style="float:left;width:276px;height:100px;">
</div>
<div class="page-text"> 
<h1>Anmeldung zu den Gottesdiensten</h1>

<p>
Aufgrund der Corona-Pandemie sind die Plätze in unseren Gottesdiensten begrenzt. Deshalb bitten wir Sie sich frühzeitig anzumelden.
</p>
</div>
</div>
<form action="index.php" method="post" id="anmeldung" >

<input  type="hidden"
        id="cid"
        name="cid"
        value="<?php echo $C->id ; ?>">

<main class="container">
<section class="box">
<h3>Schritt 1: Kontaktdaten eingeben</h3>
<p>
Zum Anmelden geben Sie Ihre Kontaktdaten ein, wählen <u>einen</u> Gottesdienst aus der Liste und klicken Sie auf <span style="font-weight: bold; color: green">Anmelden als Besucher</span>.
</p>
<p>
Konfirmanden geben nur <strong>Vor-und Nachname</strong> ein und klicken auf <span style="font-weight: bold; color: green">Anmelden als Konfirmand</span>.
</p>

<h2>Kontaktdaten</h2>

<p>Vornamen mehrerer Familienmitgliedern durch "," getrennt eingeben.</p>

<table>

<tr>
<td>
<label form="anmeldung">Vorname</label>
</td>
<td>
<input type="text"
    name="Firstname"
    id="Firstname"
	value="<?php echo $C->Firstname ; ?>"
	maxlength="128" />
</td>
</tr>

<tr>
<td>
<label form="anmeldung">Nachname</label>
</td>
<td>
<input type="text"
    name="Name"
    id="Name"
	value="<?php echo $C->Name ; ?>"
	maxlength="64" />
</td>
</tr>

<tr>
<td>
<label form="anmeldung">Straße</label>
</td>
<td>
<input type="text"
    name="Street"
    id="Street"
	value="<?php echo $C->Street ; ?>"
	maxlength="64" />
</td>
</tr>

<tr>
<td>
<label form="anmeldung">PLZ</label>
</td>
<td>
<input type="text"
    name="PostalCode"
    id="PostalCode"
	value="<?php echo $C->PostalCode; ?>"
	maxlength="5" />
</td>
</tr>

<tr>
<td>
<label form="anmeldung">Stadt</label>
</td>
<td>
<input type="text"
    name="City"
    id="City"
	value="<?php echo $C->City ; ?>"
	maxlength="64" />
</td>
</tr>

<tr>
<td>
<label form="anmeldung">Telefon</label>
</td>
<td>
<input type="text"
    name="Phone"
    id="Phone"
	value="<?php echo $C->Phone ; ?>"
	maxlength="16" />
</td>
</tr>

<tr>
<td>
<label form="anmeldung">E-Mail</label>
</td>
<td>
<input type="text"
    name="EMail"
    id="EMail"
	value="<?php echo $C->EMail ; ?>"
	maxlength="64" />
</td>
</tr>

</table>

</section>

<section class="box">

<h3>Schritt 2: Gottesdienst wählen</h3>

<p>
W&auml;hlen Sie unten einen Gottesdienst aus. Derzeit k&ouml;nnen Sie nur einen Gottesdienst ausw&auml;hlen. Die Seite wird anschließend mit den Kontaktdaten wieder aufgerufen, so dass Sie sich für weitere Gottesdienste anmelden können.
</p>

<h2>Liste der Gottesdienste</h2>

<fieldset>

<?php

$events = new event();

$SQL = "SELECT * FROM events ORDER BY Starttime;";

$events->list($eid, FALSE);

?>

</fieldset>
</section>

<section class="box">

<h3>Schritt 3: Formular absenden und anmelden</h3>

<p>
Klicken Sie unten auf <span style="font-weight: bold; color : green">Anmelden</span> Anschließend erhalten Sie eine E-Mail mit einem Link um Ihre Anmeldung zu bestätigen.
</p>

<h2>Anmelden</h2>

<div class="menue">
<div class="menuebutton">
<button id="signin"
    name="signin"
    type="submit"
    value="OK"
    style="color: green; font-weight: bold;">Anmelden als Besucher</button>
</div>

<div class="menuebutton">

<button id="signin"
    name="signin"
    type="submit"
    value="Konfirmand" >Anmelden als Konfirmand</button>
</div>

<div class="menuebutton">
<address>
  <p class="center">Oder <a href="tel:+4922264760">02226 4760</a> anrufen.</p>
</address>
</div>
</div>
<div class="message">
<?php
if ( $message != "" ) {

	echo '<p>' . $message . '</p>';

}
?>
</div>


</section>
<?php

if ($DEBUG) {

?>

<section class="box debug">

<?php
	print($debugmsg);
?>

</section>

<?php
}
?>



</main>
</form>

</body>
</html>
