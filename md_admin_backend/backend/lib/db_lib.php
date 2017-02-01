<?php
include_once('config.inc.php');
class dbQuery {
	
	private $dbconn;
	private $dbclose;
	private $sql;
	private $queryresult;
	private $result;
	private $row;
	private $counter;
	private $query;
	private $conn;
	private $closeconn;
	private $data;
	private $displaydata;
	
	public function __construct($sql) {
		$this->sql = $sql;
	}
	

	private function runQuery() {
		//connect to DB, run query, closes DB connection
		$this->dbconn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die ('Cannot connect to database');
		$this->query = mysqli_query($this->dbconn,$this->sql);
		$this->queryresult = $this->query;
		$this->dbclose = mysqli_close($this->dbconn);	
	}
	
	public function rowCount() {
		//returns true if login login details return a single row in db
		$this->runQuery();
		$this->counter = mysqli_num_rows($this->queryresult);
		if ($this->counter == 1) {
			return true;
		}else{
			if ($this->counter !== 1) {
				
				return false;	
			}	
		}
	}


	public function returnQuery() {
		$this->runQuery();
		return $this->queryresult;

	}
	
} // end of dbQuery class






?>
