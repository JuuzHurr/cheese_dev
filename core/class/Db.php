<?php

class Db {

	public static $mysqli;
	public static $query;

	function __construct($_db = DB_DB, $_host = DB_HOST, $_usr = DB_USR, $_pwd = DB_PWD) {
		
		self::$mysqli = new mysqli($_host, $_usr, $_pwd, $_db);

		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}
		
	}

	public static function sql($query) {
		self::$query = $query;
	}

	public static function fetch() {

		if(isset(self::$query)){

			if ($result = mysqli_query(self::$mysqli, self::$query)) {

				$a_results = array();

			    /* fetch associative array */
			    while ($obj = mysqli_fetch_object($result)) {
			        $a_results[] = $obj;
			    }

			    if( is_array($a_results) && count( $a_results) == 1 ){
			    	$a_results = $a_results[0];
			    }

			    /* free result set */
			    mysqli_free_result($result);

			    return $a_results;
			}
		
		} return false;
		
	}
	
	private function execute(){

		if(isset(self::$query)){

			// let's make sure inserted query was valid and prepare it -> prevents sql injections
			if(!($stmt = self::$mysqli->prepare(self::$query))) {
			    trigger_error("Prepare failed: (" . self::$mysqli->errno . ") " . self::$mysqli->error);
			}else{
				// Query execution
				if(!$stmt->execute()) {
				    trigger_error("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
				    $stmt->close();
				}
			}

		} return false;
	}

}

?>
