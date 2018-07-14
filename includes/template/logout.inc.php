<?php
if (isset($_POST['logout'])) {
	//SESSION Schliesen
	session_start();
	session_destroy();
	$_SESSION = NULL;
	session_start();
	$_SESSION["info"] = "Logout erfolgreich";		
	/* Redirect auf eine andere Seite im aktuell angeforderten Verzeichnis */
	$host  = $_SERVER['HTTP_HOST'];
	header("Location: http://$host/");
	echo "<script type='text/javascript'>window.location = 'http://".$host."';</script>";
	exit();
}
?>
<form id="logout" name="logout" method="post">
	<input class="board_button" type="submit" name="logout" value="Ausloggen">
</form>