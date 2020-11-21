<?php
/**
 * events.php
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

include_once "db.php";
include_once "lib.php";

/*
+---------------+------------+------+-----+---------+----------------+
| Field         | Type       | Null | Key | Default | Extra          |
+---------------+------------+------+-----+---------+----------------+
| id            | bigint(20) | NO   | PRI | NULL    | auto_increment |
| gid           | bigint(20) | YES  | MUL | NULL    |                |
| Starttime     | datetime   | YES  | MUL | NULL    |                |
| Endtime       | datetime   | YES  | MUL | NULL    |                |
| Title         | char(64)   | YES  | MUL | NULL    |                |
| Subtitle      | char(64)   | YES  | MUL | NULL    |                |
| Place         | char(32)   | YES  | MUL | NULL    |                |
| SeatCapacity  | int(11)    | YES  |     | 10      |                |
| ReservedSeats | int(11)    | YES  |     | 0       |                |
| MaxGroups     | int(11)    | YES  |     | 2       |                |
+---------------+------------+------+-----+---------+----------------+
*/

class event extends evservicesdb {

	public $id            = 0 ;
	public $gid           = 0 ;
	public $Starttime     = NULL ;
	public $Endtime       = NULL ;
	public $Title         = NULL ;
	public $Subtitle      = NULL ;
	public $Place         = NULL ;
	public $SeatCapacity  = 0 ;
	public $ReservedSeats = 0 ;
	public $MaxGroups     = 2 ;
	public $FreeSeats     = 0 ;

	/**
	 *
	 */
	public function __construct() {

		parent::__construct();
	}


	/**
	 *
	 */
	function copyrow($reset = FALSE) {
        
        parent::copyrow();
        
		$this->id = $this->rres['id'];
		$this->gid = $this->rres['gid'];
		$this->Starttime = $this->rres['Starttime'];
		$this->Endtime = $this->rres['Endtime'];
		$this->Title = $this->rres['Title'];
		$this->Subtitle = $this->rres['Subtitle'];
		$this->Place = $this->rres['Place'];
		$this->SeatCapacity = $this->rres['SeatCapacity'];
		$this->ReservedSeats = $this->rres['ReservedSeats'];
		$this->MaxGroups = $this->rres['MaxGroups'];
		
		if (array_key_exists('FreeSeats', $this->rres)) {
			$this->FreeSeats = $this->rres['FreeSeats'];
        } else {
            $this->FreeSeats = NULL;
        }


    }



	/**
	 *
	 * @param unknown $id
	 */
	function look_up($id) {
        
        if (is_null($id) or !is_numeric($id)) {
            $SQL = 'select * from events where Starttime > CURRENT_TIME order by Starttime limit 1;';
        } else {
            $SQL = 'select * from events where id =' . $id . ' and Starttime > CURRENT_TIME order by Starttime limit 1;';
        }
		if ($this->select($SQL)){
            $this->fetchrow(TRUE);
        }

	}


	/**
	 *
	 * @return unknown
	 */
	function insert_into_db() {

		$SQL = 'insert into events '
			. ' values ( NULL'
			. ','  . $this->gid
			. ',"' . $this->Starttime . '"'
			. ',"' . $this->Endtime . '"'
			. ',"' . $this->Title . '"'
			. ',"' . $this->Subtitle . '"'
			. ',"' . $this->Place  . '"'
			. ','  . $this->SeatCapacity
			. ','  . $this->ReservedSeats
			. ','  . $this->MaxGroups
			. ');';


		if ($this->conn->query($SQL) === TRUE) {
			$msg = "Neuer Termin angelegt.";
		} else {
			$msg = "Datenbank: Leider kein neuer Termin angelegt.";
		}

		return $msg;

	}

	/**
	 *
	 */
	function list ($eid, $long=TRUE) {
	    $SQL = 'select e.id as id ,'
	    . ' e.gid as gid ,'
	    . ' e.Starttime as Starttime ,'
	    . ' e.Endtime as Endtime ,'
	    . ' e.Title as Title ,'
	    . ' e.Subtitle as Subtitle ,'
	    . ' e.Place as Place ,'
	    . ' e.SeatCapacity as SeatCapacity ,'
	    . ' e.ReservedSeats as ReservedSeats ,'
	    . ' e.MaxGroups as MaxGroups ,'
	    . ' SeatCapacity - count(t.id) as FreeSeats'
	    . ' from events as e left join tickets as t on t.eid=e.id group by e.id order by Starttime;';
		if ( $this->select($SQL) ) {


			// Table header
?>

<div class="table-wrapper">

<table>
<thead>
<tr>
<th class="colrbfree" colspan="2">
Freie Platze
</th>
<th class="colbegin">
Beginn
</th>

<?php 
    if ($long) {
?>
<th class="colende">
Ende
</th>
<?php 
    }
?>

<th class="coltitle">
Titel
</th>
<?php 
    if ($long) {
?>
<th class="colsubtitle">
Untertitel
</th>
<?php 
    }
?>
<th class="colplace">
Ort
</th>
<?php 
    if ($long) {
?>
<th class="colplace">
Plätze
</th>
<?php 
    }
?>
</tr>

</thead>

<tbody>

<?php

			while ($this->fetchrow()) {

				/* Table of Records */

				if ($this->FreeSeats > 0) {
                    print ( '<tr>' .  PHP_EOL);
				} else {
                    print ( '<tr class="disabled">' .  PHP_EOL);
                        
                }
				print ( '<td class="colrb">' . PHP_EOL);
                print ( '&nbsp;<input type="radio" id="event'
                    . $this->id
                    . '" name="event" value="'
                    . $this->id
                    . '" '
                    .  checked($this->id , $eid ));
                if (!$long and $this->FreeSeats==0) {
                    print (' disabled ');
                    }
                        
                print ( ' /></td>'. PHP_EOL ) ;
                
                print ('<td class="colfree right">'. $this->FreeSeats . '</td>' .PHP_EOL);
				print ( '<td class="left result">' .  DateTimeDEU($this->Starttime) . '</td>' .  PHP_EOL);
				if ($long) { print ( '<td class="left result ">' . DateTimeDEU($this->Endtime) . '</td>' .  PHP_EOL);}
				print ( '<td class="left result ">' . $this->Title . '</td>' .  PHP_EOL);
				if ($long) { print ( '<td class="right result ">' . $this->Subtitle . '</td>' .  PHP_EOL);}
				print ( '<td class="left result ">' . $this->Place . '</td>' . PHP_EOL);
				if ($long) { print ( '<td class="right result ">' . $this->SeatCapacity . '</td>' .  PHP_EOL);}
				print ( "</tr>" . PHP_EOL);

			} /* end while */
?>

</tbody>
</table>
</div>

<?php
		} /* end if */
		else {
			print ( "<p>Keine Gottesdienste gefunden.</p>" );
		}

	} /* end of events.list */


}

?>
