<?php
class database {
	
	public function con() {
		return mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	}
	
	
	function test() {
		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  echo "";
		}
	} // Funktion Verbindung testen	
}
?>
