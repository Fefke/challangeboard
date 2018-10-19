<?php
class database {
	public function con() {
		return mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	}			public static function query($sql) {		return mysqli_query((new database)->con(), $sql);	}		
	function test() {
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();			return false;
		}		return true;
	} // Funktion Verbindung testen	
}
?>