<form id="logout" name="logout" method="post">
	<input class="board_button" type="submit" name="logout" value="Ausloggen">
</form>
<?php
if (isset($_POST['logout'])) {
	//SESSION Schliesen
	session_destroy();
	$_SESSION = NULL;
	$_SESSION["info"] = "Logout erfolgreich";	
	/* Redirect auf eine andere Seite im aktuell angeforderten Verzeichnis */
	$host  = $_SERVER['HTTP_HOST'];
	//exit(header("Location: " . WS_DIR_HTTP_HOME));
        echo "<script>window.location('" . WS_DIR_HTTP_HOME . "');</script>";
}
?>