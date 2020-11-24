<?php
/**
 * contacts.php
 *
 * @package default
 */


/*
 * Autor: Thomas Arend
 * Stand: 05.11.202ß8
 *
 * Better quick and dirty than perfect but never!
 *
 * Securety check: No direct calls are allowed
 */

global $AnmeldungTest;

isset($AnmeldungTest) or exit ("No direct calls!" ) ;

include_once "lib.php" ;
include_once "maillib.php";
include_once "db.php";
include_once "tickets.php";

/* Retrieve the results fom database and print out the rows  */

class contact extends evservicesdb {

	public $id   = 0;
	public $Firstname = '';
	public $Name  = '';
	public $Street = '';
	public $PostalCode = '53359';
	public $City = 'Rheinbach';
	public $Phone = '';
	public $EMail = '';
	public $Konfirmand = 0;
	public $DonotDelete = 0;

	/*
    Create object.
 */

	/**
	 *
	 */
	public function __construct() {

		parent::__construct();

	}



	/**
	 *
	 * @param array   $arr
	 */
	public function set(array $arr) {

		if (array_key_exists('id', $arr)) {
			$this->id = trim( $arr['id']);
		}

		if (array_key_exists('PIN', $arr)) {
			$this->PIN = trim( $arr['PIN']);
		}

		if (array_key_exists('Firstname', $arr)) {
			$this->Firstname = trim( $arr['Firstname']);
		}

		if (array_key_exists('Name', $arr)) {
			$this->Name = trim( $arr['Name']);
		}

		if (array_key_exists('Street', $arr)) {
			$this->Street = trim( $arr['Street']);
		}

		if (array_key_exists('PostalCode', $arr)) {
			$this->PostalCode = trim( $arr['PostalCode']);
		}

		if (array_key_exists('City', $arr)) {
			$this->City = trim( $arr['City']);
		}

		if (array_key_exists('Phone', $arr)) {
			$this->Phone = trim( $arr['Phone']);
		}

		if (array_key_exists('EMail', $arr)) {
			$this->EMail = trim( $arr['EMail']);
		}

		if (array_key_exists('Konfirmand', $arr)) {
			$this->Konfirmand = trim( $arr['Konfirmand']);
		}

		if (array_key_exists('DonotDelete', $arr)) {
			$this->DonotDelete = trim( $arr['DonotDelete']);
		}

	}


	/**
	 *
	 * @param unknown $reset (optional)
	 */
	function copyrow($reset = FALSE) {

		parent::copyrow();

		$this->set($this->rres);

	}


	/**
	 *
	 * @return unknown
	 */
	function check_contact() {

		$error = "";

		if ( empty($this->Firstname) 
		
            or ! preg_match("/^[a-zA-Z-\. äöüÄÖÜß]*$/",$this->Firstname )) { 
            $error.= " Vorname" ;
        }
        
        if ( empty($this->Name) 
            or ( !preg_match("/^[a-zA-Z- äöüÄÖÜß]*$/",$this->Name )
		     ) ) { $error.= " Name" ;}
		
		if ( empty($this->Street) 
            or ( ! preg_match("/^[a-zA-Z0-9-\. äöüÄÖÜß]*$/",$this->Street )
		     ) ) { $error.= " Straße" ;}
		
		if ( ! preg_match("/^[0-9]{5}$/",$this->PostalCode ) ) { $error.= " PLZ" ;}
		
        if ( empty($this->City) 
            or ( ! preg_match("/^[a-zA-Z0-9- äöüÄÖÜß]*$/",$this->City )
		     ) ) { $error.= " Ort" ;}
		
		$this->Phone = preg_replace('/[^0-9+]/', '', $this->Phone);
        $this->Phone = preg_replace('/^0/', '+49', $this->Phone);

		if ( empty($this->Phone)
            or ! preg_match("/^\+?[0-9]{4,15}$/",$this->Phone ) ) { $error.= " Telefon" ;}
		
		if ( empty($this->EMail) 
            or(! filter_var($this->EMail, FILTER_VALIDATE_EMAIL)) ) { $error.= " E-Mail" ;}

		return $error;

	} /* end of check_contact */


	/**
	 *
	 * @param unknown $eid
	 * @return unknown
	 */
	function add_contact($event) {
	
        // Check if visitor is in contacts table
			
		$LOOKUP = 'select * from contacts where Konfirmand = 0'  
                . ' and Firstname = "' . $this->Firstname . '"'
                . ' and Name = "' . $this->Name . '"'
                . ' and Street = "' . $this->Street . '"'
                . ' and PostalCode = "' . $this->PostalCode . '"'
                . ' and City = "' . $this->City . '"'
                . ' and Phone = "' . $this->Phone . '"'
                . ' and EMail = "' . $this->EMail . '"'
                . ';' ;

        if ($this->select($LOOKUP)) {
            // Contact exists
            $this->fetchrow();
        } else {
            // Add contact
            
            $INSERT = 'insert into contacts (PIN, Firstname, Name, Street, PostalCode,City,Phone,EMail,Konfirmand,DonotDelete) values('  
                . ' floor(rand()*1000000) '
                . ' , "' . $this->Firstname . '"'
                . ' , "' . $this->Name . '"'
                . ' , "' . $this->Street . '"'
                . ' , "' . $this->PostalCode . '"'
                . ' , "' . $this->City . '"'
                . ' , "' . $this->Phone . '"'
                . ' , "' . $this->EMail . '"'
                . ', 0, 0 );' ;
            $this->insert($INSERT);
                
            // Now the contact should in the database
            if ($this->select($LOOKUP)) {
                // Contact exists
                $this->fetchrow();
            } else {
                return ("Schwerer Fehler. Ich weiß nicht warum der Fehler auftreten kann.");
            }
        }
        // Now our visitor should be in contacts table add we can add a ticket
            
        return($this->add_ticket($event));
        
	} /* end of check_data_contacts */


	/**
	 *
	 * @param unknown $eid
	 * @return unknown
	 */
	function add_konfi($event) {

		// Check if Firstname / Name is a Konfirmand
			
		$SQL = 'select * from contacts where Konfirmand = 1 and Firstname = "' .
			$this->Firstname . '" and Name = "' . $this->Name . '";' ;

            
		if ($this->select($SQL)) {
			$this->fetchrow();
			return($this->add_ticket($event));
		} else {
			return "Konfirmand: Vor-/Nachname sind nicht bekannt.";
		}

	}  /* end of add_konfi */

	/*
    List all in HTML table
*/


    public function add_ticket ($event) {

        $ticket = new ticket();
		$ticket->lookup($event->id , $this->id);

		if ( $ticket->id != NULL ) {
			return "Du bist schon angemeldet";
		} else {
    
            $ticket->eid = $event->id;
            $ticket->cid = $this->id;
            $ticket->reserved = 1;
            $ticket->confirmed = 0;
            if ($ticket->new_ticket()) {
                SendConfirmMail($this, $event, $ticket);
                return "Angemeldet: " . DateTimeDEU($event->Starttime);
            } else {
                return "Anmelden fehlgeschlagen";
            }
        }
    }
	/**
	 *
	 */
	function list ($cid) {
        
        $SQL = 'select * from contacts order by Name, Firstname;';
		if ( $this->select($SQL) ) {


			// Table header
?>

<div class="table-wrapper contact-wrapper">

<table>
<thead>
<tr>
<th id="thselect" class="contactselect">
Auswahl
</th>

<th id="thfirstname" class="contactfirstname">
Vorname
</th>

<th id="thname" cclass="contactname">
Nachname
</th>

<th id="thstreet" class="contactstreet">
Straße
</th>

<th id="thplz" class="contactplz">
PLZ
</th>

<th id="thcity" class="contactcity">
Ort
</th>

<th id="thphone" class="contactphone">
Telefon
</th>

<th id="thmail" class="contactmail">
E-Mail
</th>

</tr>
</thead>
<tbody>

<?php

			while ($this->fetchrow()) {

				/* Table of Records */

				print ( '<tr>' );
				print ( '<td class="center result radiobutton">' );
				print ( '<input type="radio" id="contact'
					. $this->id
					. '" name="contact" value="'
					. $this->id
					. '" '
					.  checked($this->id , $cid )
					. '>' ) ;

				print ( "</td>" );

				print ( '<td class="left result">' . $this->Firstname . '</td>' );
				print ( '<td class="left result ">' . $this->Name . '</td>' );
				print ( '<td class="left result ">' . $this->Street . '</td>' );
				print ( '<td class="right result ">' . $this->PostalCode . '</td>' );
				print ( '<td class="left result ">' . $this->City . '</td>' );
				print ( '<td class="left result ">' . $this->Phone . '</td>' );
				print ( '<td class="left result ">' . $this->EMail . '</td>' );

				print ( "</tr>" );

			} /* end while */
?>

</tbody>
</table>
</div>

<?php
		} /* end if */
		else {
			print ( "<p>Keine Kontakte gefunden.</p>" );
		}

	} /* end of contact.list */


}


?>
