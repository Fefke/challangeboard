<?php
	############### FOOTER ###############
	########## Safing controller #########
        
        
       if (isset($_SESSION["info"]) && $_SESSION["info"] != "") {

		$info = $_SESSION["info"];

		echo '<script>alert("' . $info . '");</script>';

		$_SESSION["info"] = "";

	}
        
?>

<footer>
        <a id="allowed" href="info/">Impressum</a>
        <a id="allowed" href="info/?info=datenschutz">Datenschutz</a>
</footer>

<!--Include JS-Files-->
<script src="<?php echo $_SERVER['SERVER_NAME']; ?>/includes/js/controller.js" language="javascript" type="text/javascript"></script>