<details <?php 
if (isset($_SESSION['details']) && $_SESSION['details'] == "open") {
	echo $_SESSION['details'];
	$_SESSION['details'] == NULL;
	unset($_SESSION['details']);
}?>
>
	<summary>Admin Tools</summary>
	<div id="register">
		<?php include "tools/register.inc.php";?>
	</div>
	<div id="userman" style="border-top: 2px solid black;">
	    <?php include "tools/userman.inc.php";?>
	</div>
</details>