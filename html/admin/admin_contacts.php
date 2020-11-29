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

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="contactform" >

<main class="container">


<?php

filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$DEBUG = false;
$message = "";

// Initialisierung

if (array_key_exists('submit', $_POST)) {
	$submit = $_POST['submit'];
}
else {
	$submit = "";
}

$C = new contact($_POST);

if (array_key_exists('contact', $_POST) and is_numeric($_POST['contact'])) {
	$cid = $_POST['contact'];
	$C->look_up($cid);
} else {
	$C->look_up(NULL);
	$cid = $C->id;
}

if ( ! empty($submit) ) {
    
//  $message .= $submit;
    
    switch ($submit) {

	case "ADD" :

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

    case "DELETE" :

		$delC = new contact ();
		if ( ! empty($cid) and is_numeric($cid) ) {
            $delC->look_up ($cid);
            if ( ! is_null($delC->id)) {
                $SQL = "delete from contacts where id = " . $delC->id . ";";
                $message .= $SQL;
                $delC->delete($SQL);
            	$message .= "Kontakt " . $delC->Name . ', ' .$delC->Firstname . ' gelöscht<br />';
			}
        }
		
		break;

	}
}

?>

  
<section class="visitorbox box ">

<h2>Kontaktdaten der Besucher</h2>

<?php 

$C->list($cid);

 
?>

</section>
<section class="box">

<h2>Neuer Kontakt</h2>


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

<div class="menue">

    <div class="menuebutton">

        <button id="submit"
            name="submit"
            type="submit"
            value="ADD"
            style="color: green; font-weight: bold;">Hinzuf&uuml;gen
        </button>
    
    </div>

    <div class="menuebutton">

        <button id="submit"
            name="submit"
            type="submit"
            value="DELETE"
            style="color: green; font-weight: bold;">L&ouml;schen
        </button>
    
    </div>

        <div class="menuebutton">

        <button id="submit"
            name="submit"
            type="submit"
            value="UPDATE"
            style="color: green; font-weight: bold;">&Auml;ndern
        </button>
    
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


</main>
</form>

</body>
</html>
