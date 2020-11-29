<?php

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

include_once "../lib/lib.php" ;
include_once "../lib/db.php";
include_once "../lib/tickets.php";

/* Retrieve the results fom database and print out the rows  */

class visitor extends evservicesdb {

  
/*
    Create object.
 */ 
 
    public function __construct () {
    
        parent::__construct();

    }
    

/*    
    List all in HTML table
*/
    function list ($eid) {
    
        
// Table header
?>

<div class="table-wrapper">

<table>
<thead>


<th id="thsel" class="contactsel">
Auswahl
</th>
<th id="thnr" class="contactnr">
Nr.
</th>

<th id="thname" cclass="contactname">
Nachname
</th>

<th id="thfirstname" class="contactfirstname">
Vorname
</th>

<th id="thstreet" class="contactstreet">
Straße
</th>

<th id="thpostalcode" class="contactpostalcode">
PLZ
</th>

<th id="thcity" class="contactcity">
Ort
</th>

<th id="thphone" class="contactphone">
Telefon
</th>

<th id="themail" class="contactemail">
E-Mail
</th>

<th id="thconfirmed" class="contactconfirmed">
Bestätigt
</th>

</tr>
</thead>

<?php     
        if (empty($eid) or ! is_numeric($eid) or $eid==0) {
        
            print ( "<caption>Kein Gottesdienst ausgewählt.</caption>" );
            
        } else {
            $SQL = 'select Name, Firstname, Street, PostalCode, City, Phone, EMail, confirmed from events as e inner join tickets as t on e.id = t.eid inner join contacts as c on c.id = t.cid where e.id = '. $eid . ' order by Name, Firstname;' ; 
        
        if ( $this->select($SQL) ) {
        
            print ("<tbody>" . PHP_EOL ) ;
            $i=0;
    
            while ($this->fetchrow()) {

                /* Table of Records */
                $i++;
    
                print ( '<tr>' . PHP_EOL);
    
				print ( '<td class="center result radiobutton">' . PHP_EOL);
				print ( '<input type="radio" id="contact'
					. $this->id
					. '" name="contact" value="'
					. $this->id
					. '" '
					.  checked($this->id , $cid )
					. '>' ) ;

				print ( "</td>" );
                print ( '<td class="left result ">' . $i . '</td>' .  PHP_EOL );
            
                foreach ($this->data as $key => $value) {
                    
                    if (is_bool($this->data[$key]) === true) {
                    
                    $pvalue = janein($value);
                
                    } else {
                
                        $pvalue = $value;
                    }
                    print ( '<td class="left result col' . strtolower($key) . '">' . $pvalue . '</td>' . PHP_EOL);
                }

                print ( "</tr>" . PHP_EOL);
    
            } /* end while */ 
            print ("</tbody>" . PHP_EOL ) ;
        } /* end if */
        else {
                print ( "<caption>Keine angemeldeten Besucher gefunden.</caption>" );
        }
    }
?>
</table>
</div>
<?php 
        
    } /* end of contact.list */

}
?>
