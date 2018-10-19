<?php
		########## User Info ##########
if ( isset($_POST['info']) ) {
	echo "<script> alert(' " . $_POST['info'] . " ');</script>";
	$_POST['info'] = "";
}
		##########  UI END   ##########
		$error = ""; //Variable for storing our errors.
		if(isset($_POST["login"])){								
	
		if( empty($_POST["username"]) || (empty($_POST["password"]) && !isset($_GET["auth_token"]))){
			$error = "Beide Felder müssen gefüllt werden.";			
		} else {
		########## Set Settings ##########
                $auth_token = "GTthDfybrgwDcCCf";
		// Define $username and $password
		$username=$_POST['username'];		
		######## Process Password ########
		$password= (isset($_GET["auth_token"]) && $_GET["auth_token"] == $auth_token && empty($_POST['password'])) ? "swkn_password" : $_POST['password'];
		$password = crypt($password, '$6$rounds=7000$stadtwerke_security_11501997$'); //Mit Stadtwerke Salt
		###### Reset Password Post #######
		$_POST['password'] = NULL;
		//Reset the POST -> also for safety: as early as possible
		 $_POST['username']= NULL;
		 $_POST['password']= '**********';
		// To protect from MySQL injection
		$username = stripslashes($username);
		$password = stripslashes($password);
                
		$username = mysqli_real_escape_string( (new database)->con(), $username);
		$password = mysqli_real_escape_string( (new database)->con(), $password);

		 
		########## Run Actions ##########
		//Check username and password from database
		$sql = "SELECT * FROM users WHERE username='$username' and password='$password'";
		$result = database::query($sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);		
		
		
		//If username and password exist in our database then create a session.
		//Otherwise echo error.
		if($row['username'] == $username && $password == $row['password']){
			$_SESSION['username'] = $username; // Initializing Session
			$_SESSION['group'] = $row['group']; // Initializing Group
			#header("Location: " . WS_DIR_HTTP_HOME . $redirect . "");
			#exit;
		} else {
			$error = "Diesen Benutzer gibt es nicht.";
		}
	}
	
	if (isset($error)) {
		 $_SESSION["info"] = $error;
	}	
}
?>

<?php if (isset($_SESSION['username'])) {	echo '<div style="height: 8em;" class="head disabled" id="login">';
    //Logout input
        include "logout.inc.php";
        switch ($_SESSION['group']) {
            case 'admin':
            echo '
            <br>
            <a id="redirect" href="' . WS_DIR_HTTP_HOME . 'admin">Admin Panel</a>';
            break;
            case 'azubi':
            echo '			<br>
            <a id="redirect" href="' . WS_DIR_HTTP_HOME . 'azubi">Azubi Panel</a>';
            break;
            default:
            break;
        }
    } else {?>
<div class="head" id="login">
	<form action="" method="post" name="login">
		<label for="username"> Name: 
                        <input id="username" type="text" name="username" required />
		</label>
         <?php if(isset($_GET["auth_token"])){?>
		<label for="password"> Passwort: 
                        <input id="password" type="password" name="password" title="ohne Passwort kein Passport!" placeholder="Token erkannt"/>
		</label>
         <?php } else {?>
                 <label for="password"> Passwort: 
                        <input id="password" type="password" name="password" title="ohne Passwort kein Passport!" required/>
		</label>
         <?php } ?>
		<input name="login" type="submit" value="Login" />
	</form>
   <?php } ?>
</div>

