<?php
#################### Register User ####################
if (isset($_POST['registernewuser'])){
	############### Define Userdata ###############
        // removes backslashes
	$username = stripslashes($_POST['regusername']);
        //escapes special characters in a string
	$username = mysqli_real_escape_string((new database)->con(),$username); 
	
	
	//Prüfen ob Standard-Passwortr verwendet werden soll
	
	if (!isset($_POST['regpassword']) || empty($_POST['regpassword'])) {
	    $password = "swkn_password";
	} else {
	    $password = stripslashes($_POST['regpassword']);
	}
    
    $password = mysqli_real_escape_string((new database)->con(),$password);
	
	
	########### Passwort verschlüssseln ###########
	
	$password = crypt($password, '$6$rounds=7000$stadtwerke_security_11501997$');//Stadtwerke-Salt
	$_POST['regpassword'] = "";
	##### verschlüsselt mit CRYPT_SHA512-Salt #####

	############### Gruppe abfragen ###############
	if (isset($_POST['admin'])) {
		$group = "admin";
	} else {
		$group = "azubi";
	}
	
	
	############## User-ID erstellen ##############
	$sql = mysqli_query((new database)->con(),"SELECT MAX(id) FROM `users`"); 
	$id = mysqli_fetch_array($sql, MYSQLI_ASSOC);
	$user_id = $id['MAX(id)'] + 1;

	
	
	######### Datenbank eintrag erstellen #########
        $query = "INSERT INTO `users`(`id`, `username`, `password`, `group`) VALUES ('" . $user_id . "','" . $username . "', '" . $password . "', '" . $group . "')";
        $result = mysqli_query((new database)->con(),$query);
        if($result){
			$_SESSION['details'] = "open";
            echo "<h3 style='color: green;'>" . $username . " wurde erfolgreich registriert.</h3>";
        }
		
		
		
	########### Abfragen ob User besteht ##########	
	##### Temporäre HTTP und PHP Daten löschen ####
	$_POST['regusername'] = "";
	$_POST['regpassword'] = "**********";
	

    } else {
		
	}
?>
<div class="form">
	<h2>Registration</h2>
	<form id="register" method="post">
		<input id="regusername" class="imptext" type="text" name="regusername" placeholder="Benutzername" required />
		<input id="regpassword" class="imptext" type="password" name="regpassword" placeholder="Standard-Passwort" title="Passwärter werden mit dem SHA512 Algorithmus &#10;und einem eigenen Stadtwerke-Salt &#10;(einweg) verschlüsselt" />
		<label for="admin">Admin: <input id="admin" type="checkbox" name="admin"/></label>
			<br><br>
		<input type="submit" name="registernewuser" value="Registrieren" />
			<br>
	</form>



</div>