<?php
/**
 * lib.php
 *
 * @package default
 */


/**
 *
 * @param unknown $id_a
 * @param unknown $id_b
 * @return unknown
 */
 
function checked($id_a, $id_b) {

	if ( $id_a == $id_b ) {
		return "checked";
	}
	else {
		return "";
	}
}


/**
 *
 * @param unknown $msg
 */
function mydebug($msg) {

	global $debugmsg ;
	$debugmsg .="<p>" . $msg ."</p>";

}

function janein ($b) {
    
    if ($b) {
        return ("Ja");
    } else {
        return ("Nein");
    };

}

function DateTimeDEU ( $datetime ) {

    $temp = new DateTime($datetime);
	return ($temp->format('d.m.Y H:i'));

}
?>
