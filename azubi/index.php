<?php 

session_start();
include "../includes/class/controller.inc.php";

//Connect with (Constant) data from config.php
require "../includes/config.inc.php";

//Bring in the database class
require "../includes/class/database.inc.php";

//Check if user exists
require "../includes/template/check.inc.php";



//Datenbank mit gegebenem Post aktualisieren

if (isset($_POST['safe_cb_changes'])) {
    (new controller)->upload_cb();
    $_POST['safe_cb_changes'] = NULL;

}

//SESSION Eintrag, dass nicht Startseite

$_SESSION['startseite'] = NULL;

//array für Begrüßung

$hello = array(
	"1" => "Hallo",
	"2" => "Hallöchen",
	"3" => "Servus",
	"4" => "Hey",

);


?>

<!DOCTYPE html>

<html>



<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<META NAME=”ROBOTS” CONTENT=”NOINDEX, FOLLOW”>
	
	
	<title>SWKN | Challange-Board</title>

	
	<!--Favicon-->
	<link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico">
	<!--Style-->
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	<!--Javascript deaktiviert-->
	<noscript><p style="position: fixed; background-color: white; padding: 15px; text-align: center; width: 600px; border: 2px solid red; margin: 0 auto;">Anscheinend funktioniert JavaScript bei Dir nicht ganz richtig...</p></noscript>
	<!--JQuerry-->
	<script language="javascript" src="/includes/js/jquery-3.3.1.min.js" type="text/javascript"></script>

</head>



<body>



	<?php include "../includes/template/legende.inc.php";?>


	<div class="head" id="login">
		<?php if (isset($_SESSION["username"])){echo "<p style='margin:0;padding:0;'>" . $hello[rand(1,4)] . ", " . $_SESSION["username"] . "!</p>";}else{echo "Hey!";}?>
		<?php include "../includes/template/logout.inc.php";?>

	</div>

	

	<div class="main" id="board">
		<h1>Challenge-Board</h1>

		<br>
			<?php include "../includes/template/header.inc.php";?>
		<br>
			<?php include "../includes/template/settings.inc.php";?>
		<br>

		<div id="board">
                        <?php (new controller)->challange_board($_SESSION['group']);?>
                </div>
        </div>
	<?php 
                include "../includes/template/footer.inc.php";
        ?>

</body>

</html>

