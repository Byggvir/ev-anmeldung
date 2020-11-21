<?php
/**
 * tickets.php
 *
 * @package default
 */


include_once "db.php";
include_once "lib.php";

class ticket extends evservicesdb {

	public $id  = 0;
	public $eid = 0;
	public $cid = 0;
	public $reserved = 0;
	public $confirmed = 0;
	public $confirmtoken = "";
    public $ts = NULL;



	/**
	 *
	 * @param unknown $id
	 */
	function __constructor1($id) {

		parent::__construct();
		$this->id = $id;
		$this->ts = time();

	}





	/**
	 *
	 * @param unknown $reset (optional)
	 */
	function copyrow($reset = FALSE) {

		parent::copyrow();

		$this->id = $this->rres['id'];
		$this->eid = $this->rres['eid'];
		$this->cid = $this->rres['cid'];
		$this->reserved = $this->rres['reserved'];
		$this->confirmed = $this->rres['confirmed'];
		$this->confirmtoken = $this->rres['confirmtoken'];
		$this->ts = $this->rres['ts'];

	}





	/**
	 *
	 * @return unknown
	 */
	function fetchrow($reset = FALSE) {

		if (parent::fetchrow($reset)) {
			$this->copyrow($reset);
			return TRUE;
		} else {
			$this->id = NULL;
			return FALSE;
		}

	}





	/**
	 *
	 * @return unknown
	 */
	function new_ticket() {

        $this->confirmtoken = bin2hex(random_bytes(16));
		$SQL = 'insert into tickets '
			. ' values ( NULL'
			. ' , ' . $this->eid
			. ' , ' . $this->cid
			. ' , ' . $this->reserved
			. ' , ' . $this->confirmed
			. ' , "' . $this->confirmtoken . '"'
			. ' , NULL'  
			. ');';

        if (parent::insert($SQL) === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


	/**
	 *
	 * @param unknown $eid
	 * @param unknown $cid
	 */
	function lookup( $eid , $cid) {

		$SQL = 'select * from tickets where eid =' . $eid . ' and cid = ' . $cid . ' limit 1;';
		if ($this->select($SQL)) {
			$this->fetchrow();
		} else {
			$this->id = NULL;
		}

	}

	function confirm ($confirmtoken) {
    
        $SQL = 'select * from tickets where confirmtoken = "' .$confirmtoken .'";';
        $this->select($SQL);
        $this->fetchrow(TRUE);
        if ($this->confirmed) {
            return (true);
        } else {
            $SQL = 'update tickets set confirmed = TRUE where confirmtoken = "' .$confirmtoken .'";';
            return ($this->update($SQL));
        }
        
    }
	function revoke($confirmtoken) {
    
        $SQL = 'select * from tickets where confirmtoken = "' .$confirmtoken .'";';
        $this->select($SQL);
        $this->fetchrow($SQL);
        if ($this->confirmtoken == $confirmtoken) {
            $SQL = 'delete from tickets where confirmtoken = "' .$confirmtoken .'";';
            return ($this->delete($SQL));
        } else {
            return (FALSE);
        }
        
    }


}


?>
