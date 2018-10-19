<div class="form">
	<h2>Benutzer Management</h2>
	<form id="userman" name="userman" method="post">
	    
        <table class="board">
        <tr><th class='id'>ID</th> <th>Name</th> <th>Gruppe</th>  <th title="Punkte">Pkt.</th><th style="width: 20px;" title="Reset Passwort">R.P.</th></tr>

<?php
############## Change User DB update ################

if ($_SESSION['group'] == "admin" && isset($_POST['safe_user_changes']) && $_POST['safe_user_changes'] != "nichtspeichern!") {
    
	$uid = $_POST['uid'];
	$uusername = $_POST['uusername'];
	$ugroup = $_POST['ugroup'];
	$upkt = $_POST['upkt'];
    
	
    ############# all Changes Einheit #############
    foreach($uid as $row) {
        //Index
        $index = $row - 1;
		//SQL Query
		if ($row = $uid[$index]) {
			$sqlui = 'UPDATE `users` SET `username` = "' . $uusername[$index] . '", `group` = "' . $ugroup[$index] . '", `punkte` = "' . $upkt[$index] . '" WHERE id = ' .$uid[$index] . ';';
			$updaten = database::query($sqlui);
		}
	}
    
	
    ############### PASSWORT RESETEN ###############
    if (isset($_POST['resetpasswd'])) {
        $resetpasswd = $_POST['resetpasswd'];
        ########## RPasswort verschlüssseln ###########
    	$password = crypt('swkn_password', '$6$rounds=7000$stadtwerke_security_11501997$');//Stadtwerke-Salt
    	##### verschlüsselt mit CRYPT_SHA512-Salt #####
    	
        foreach($resetpasswd as $row) {
    		//SQL Query
    		$sql = 'UPDATE `users` SET `password`= "' . $password . '"  WHERE `username` = "' . $row . '" ;';
    		$updaten = database::query($sql);
    	}
    
    }
    
    
    //RESET - doppelt hält besser :)
    
    $_POST["safe_user_changes"] = "nichtspeichern!";
    $_POST['uid'] = NULL;
	$_POST['uusername'] = NULL;
	$_POST['ugroup'] = NULL;
	$_POST['upkt'] = NULL;
	
    unset($_POST["safe_user_changes"]);
    unset($_POST['uid']);
    unset($_POST['uusername']);
    unset($_POST['ugroup']);
    unset($_POST['upkt']);
    unset($_POST['resetpasswd']);
	
	
	//Abfrage ob eigene Gruppe geändert
	$sql="SELECT * FROM users WHERE username='" . $_SESSION['username'] . "';";
	$sql = database::query($sql);
	$user = mysqli_fetch_array($sql,MYSQLI_ASSOC);	
		
	if ($user['group'] != "admin") {
		echo "<script type='text/javascript'>location.reload();</script>";
	} else
	//details wieder öffnen
	$_SESSION['details'] = "open";
}



#################### Change User ####################

    $sqlu = "SELECT `id`, `username`, `group`, `punkte` FROM `users`";
    $query = database::query($sqlu);
    
    ################### Ausgabe ###################

    while ($zeile = mysqli_fetch_array( $query, MYSQLI_ASSOC)){		  
			  echo "<tr>";
			  echo "<td><input class='id' name='uid[]' type='hidden' value='" . $zeile['id'] . "'/>" . $zeile['id'] ."</td>";
			  echo "<td><input class='' name='uusername[]' type='text' value='" . $zeile['username'] . "'/></td>";
			  //Voreingestelltes Select für Gruppen
			  
			  if ($zeile['group'] == "admin") {
    			  echo "<td>
    			           <select style='background-color:red;color:white;' class='pkt' name='ugroup[]' selected='" . $zeile['group'] . "'>
                                <option value='admin' selected>Admin</option>
                                <option value='azubi' >Azubi</option>
                            </select></td>";
			  } else {
    			       echo "<td>
    			           <select class='pkt' name='ugroup[]' selected='" . $zeile['group'] . "'>
                                <option value='admin' >Admin</option>
                                <option value='azubi' selected>Azubi</option>
                            </select></td>";
			  }
			  
			  echo "<td><input class='pkt' name='upkt[]' type='text' value='" . $zeile['punkte'] . "'/></td>";
			  echo "<td><input class='pkt' name='resetpasswd[]' type='checkbox' value='" . $zeile['username'] . "'/></td>";
			  echo "</tr>";
			}

    $_POST["safe_user_changes"] = "nichtspeichern!";
    $_POST['uid'] = NULL;
	$_POST['uusername'] = NULL;
	$_POST['ugroup'] = NULL;
	$_POST['upkt'] = NULL;

?>
        </table>
        <input type="submit" name="safe_user_changes" value="Speichern" style="max-width: 200px;">
	</form>
</div>