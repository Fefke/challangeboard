<?php

################# Check Changes ################# 
	
	if (isset($_POST["pkt"]) || isset($_POST["value"])) {
		$safearray = array (
			'pkt' => array(
				'maxpkt' => $_POST["maxpkt"],
				'midmaxpkt' => $_POST["midmaxpkt"],
				'midminpkt' => $_POST["midminpkt"],
				'minpkt' => $_POST["minpkt"]
			),
			'value' => array(
				'maxvalue' => $_POST["value"][0],
				'midmaxvalue' => $_POST["value"][1],
				'midminvalue' => $_POST["value"][2],
				'minvalue' => $_POST["value"][3]
			)
		);
		
		
		
		$safearray = json_encode($safearray, JSON_UNESCAPED_UNICODE);
		$sql = "REPLACE INTO `config`(`id`, `option`) VALUES (1,'" . $safearray . "')";
		$sql_process = database::query($sql);
	}



############### Check users Group ############### 

if (isset($_SESSION['username'])) {
	$group_check = $_SESSION['username'];
	$sql = database::query("SELECT * FROM users WHERE username='$group_check' ");
	$row=mysqli_fetch_array($sql,MYSQLI_ASSOC);
	$group = $row['group'];	
} else {
	$group = "";
}

######### Array/values aus DB auslesen ########### 
$sql_option = database::query("SELECT `option` FROM `config` WHERE `id` = 1");
if ($sql_option == true) {
	$sql_option = mysqli_fetch_array($sql_option, MYSQLI_ASSOC);
	$sql_option = json_decode($sql_option["option"], true);
}

################ Change for Group ################ 
if ($group == "admin" && !isset($_SESSION['startseite'])) {		
		//Admin | Prefill
		$legende = array(
			'pkt' => array(
				'maxpkt' => '<input class="legende_part" type="number" min="0" name="maxpkt" value="' . $sql_option['pkt']['maxpkt'] . '"/> ',
				'midmaxpkt' => '<input class="legende_part" type="number" min="0" name="midmaxpkt" value="' . $sql_option['pkt']['midmaxpkt'] . '"/>',
				'midminpkt' => '<input class="legende_part" type="number" min="0" name="midminpkt" value="' . $sql_option['pkt']['midminpkt'] . '"/>',
				'minpkt' => '<input class="legende_part" type="number"  min="0" name="minpkt" value="' . $sql_option['pkt']['minpkt'] . '"/>'
			),
			'value' => array(
				'maxvalue' => '<input class="legende_text" type="text"  min="0" max="16" name="value[]" value="' . $sql_option['value']['maxvalue'] . '"/>',
				'midmaxvalue' => '<input class="legende_text" type="text"  min="0" max="16" name="value[]" value="' . $sql_option['value']['midmaxvalue'] . '"/>',
				'midminvalue' => '<input class="legende_text" type="text"  min="0" max="16" name="value[]" value="' . $sql_option['value']['midminvalue'] . '"/>',
				'minvalue' => '<input class="legende_text" type="text"  min="0" max="16" name="value[]" value="' . $sql_option['value']['minvalue'] . '"/>'
			)
		);
	
	
	// for installation::
	$upload = json_encode($legende);
	$sql = "INSERT INTO `config`(`id`, `legend`) VALUES (1,'$upload')";
	$row = database::query($sql);
	//Reseten des POST eintrags
	$_POST['startseite'] = NULL;
	
 } else {
	//default | Prefill
	$legende = array(
		'pkt' => array(
			'maxpkt' => $sql_option['pkt']['maxpkt'],
			'midmaxpkt' => $sql_option['pkt']['midmaxpkt'],
			'midminpkt' => $sql_option['pkt']['midminpkt'],
			'minpkt' => $sql_option['pkt']['minpkt']
		),
		'value' => array(
			'maxvalue' => $sql_option['value']['maxvalue'],
			'midmaxvalue' => $sql_option['value']['midmaxvalue'],
			'midminvalue' => $sql_option['value']['midminvalue'],
			'minvalue' => $sql_option['value']['minvalue']
		)
	);
	
 }
 
 
 
 
?>
	<ul id="punkte" class="head"><?php if ($group == "admin" && !isset($_SESSION['startseite'])) { echo "<li><h3 style='margin:0;padding:5px;'>Legende</h3></li>";}?>
		<li><?php echo $legende['pkt']['maxpkt'];?>- Pkt.: <?php echo $legende['value']['maxvalue']?></li>
		<li><?php echo $legende['pkt']['midmaxpkt'];?> - Pkt.: <?php echo $legende['value']['midmaxvalue']?></li>
		<li><?php echo $legende['pkt']['midminpkt'];?> - Pkt.: <?php echo $legende['value']['midminvalue']?></li>
		<li><?php echo $legende['pkt']['minpkt'];?> - Pkt.: <?php echo $legende['value']['minvalue']?></li>
	</ul>
