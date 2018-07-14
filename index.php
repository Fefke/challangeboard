<?php 
session_start();
include "includes/class/controller.inc.php";
//Connect with (Constant) data from config.php
require "includes/config.inc.php";
//Bring in the database class
require "includes/class/database.inc.php";
//for administration
$_SESSION['startseite'] = true;

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />	<META NAME=”ROBOTS” CONTENT=”NOINDEX, FOLLOW”>
	<title title="Startseite">SWKN | Challange-Board</title>
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
		<br>
		<a id="allowed" href="info/">Impressum</a>
	</div>
	
	<?php
	//Zusätze zum Inhalt	//Infos	include "info/info.inc.php";	
	if (isset($_SESSION["info"]) && $_SESSION["info"] != "") {
		$info = $_SESSION["info"];
		echo '<script>alert("' . $info . '");</script>';
		$_SESSION["info"] = "";
	}	
	?>		
</body>
</html>
