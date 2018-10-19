<?php
if (isset($_POST["passwd_safe"])) {	
	if ($_POST['new_passwort'] != "********" && $_POST["new_passwort"] == $_POST["password_check"]) {
		$password = $_POST['new_passwort'];
		//Reseten des POSTs
		$_POST['new_passwort'] = "********";
		$_POST["password_check"] = "********";
		//Pa.sswort mit SWK-Salt vershlüsseln
		$password = crypt($password, '$6$rounds=7000$stadtwerke_security$');
		$query = "UPDATE `users` SET `password`= '" . $password . "' WHERE `username` = '" . $_SESSION['username'] . "';";
        $result = database::query($query);

		if($result){
            echo "<h3 style='color: green;'>Passwort wurde erfolgreich geändert.</h3>";
        } else {
			 echo "<h3 style='color: red;'>Passwort wurde <stong>NICHT</stong> geändert.</h3>";
		}
	} else {
		echo "<h3 style='color: red;'>Die Passwörter sind <stong>NICHT</stong> gleich.</h3>";
	}
unset($_POST["passwd_safe"]);//Working fine!
}
?>

<details>
	<summary>Einstellungen</summary>
		<form id="change_passwd" name="password_change" method="post">
			<h2>Passwort ändern</h2>
			<p class="link_info"><a href="/info?info=passwd">Info</a></p>
			<input id="newpasswd" type="password" name="new_passwort" placeholder="Neues Passwort" required>
			<input id="newpasswd2" type="password" name="password_check" placeholder="Wiederholen" required>
			<input id="passwordsubmit" name="passwd_safe"  type="submit" value="Übernehmen*" disabled="disabled">
		</form>		
		<p class="link_info"><a href="../info/#Haftungsausschluss" target="_blank">Haftungsausschluss</a></p>
	
</details>