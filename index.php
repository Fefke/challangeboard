<?php 
session_start();
include "includes/class/controller.inc.php";
//Connect with (Constant) data from config.php
require "includes/config.inc.php";
//Bring in the database class
require "includes/class/database.inc.php";

//Echo Token Info
if (isset($_GET["auth_token"]) && $_GET["auth_token"] == "GTthDfybrgwScCCf") {
     echo '<div style="position:relative;top:0;width:100%;padding:10px;background-color:#f47742;"><p>[AuthToken] Bitte gib deinen Vornamen ein und ändere nach dem Login Vorgang dein Passwort.</p></div>';
}

//for administration
$_SESSION['startseite'] = true;

?>
<!DOCTYPE html>

<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<META NAME=”ROBOTS” CONTENT=”NOINDEX, FOLLOW”>


	<title title="Startseite">SWKN | Challenge-Board</title>


        <link rel="apple-touch-icon" href="img/logo/swk_logo_big.png"/>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="stylesheet" href="css/style.css" type="text/css">

	
	<script language="javascript" src="includes/js/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script language="javascript" src="includes/js/controller.js" type="text/javascript"></script>	



</head>
<body>

	<?php 
                $_GET['startseite'] = true;
		include "includes/template/legende.inc.php";
	?>	

	<?php include "includes/template/login.inc.php";?>	

	<div class="main" id="board">
                <h1 class="tsb">Challenge-Board</h1>
		<div id="board">
			<?php (new controller)->challange_board('table');?>
                </div>
        </div>
        
        <?php
                include "includes/template/footer.inc.php";
        ?>
</body>

</html>

