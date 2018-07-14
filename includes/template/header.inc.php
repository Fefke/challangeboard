<?php
	############### HEADER ###############
	########## Safing controller #########	######### Loading controller #########			//Ausgabe der aktuellen Punktzahl
	if ($_SESSION['group'] == "admin" || $_SESSION['group'] == "azubi") {
	//Aktuelle Punktzahl festlegen
		$sql = "SELECT  `punkte` FROM `users` WHERE `username` = '" . $_SESSION['username'] . "';";
		$ergebnis = mysqli_query( (new database)->con(), $sql );
	    while ($zeile = mysqli_fetch_array( $ergebnis, MYSQLI_ASSOC)){		  
                $aktuellepunktzahl = $zeile['punkte'];
			}
	//Aktuelle Gewinner auslesen -> um später für alle eine Meldung zu bringen
		$sql = "SELECT * FROM `winner` WHERE `username` = '" . $_SESSION['username'] . "';";
		$ergebnis = mysqli_query( (new database)->con(), $sql );
	##### Punkte festlegen und ob einlösbar ##### 		//SQL Querry		$sql_option = mysqli_query( (new database)->con(),"SELECT option FROM config WHERE id = 1 ");		if ($sql_option == true) {			$sql_option = mysqli_fetch_array($sql_option, MYSQLI_ASSOC);			$sql_option = json_decode($sql_option["option"], true);			//festlegen der einlösbaren Werte
			if (($aktuellepunktzahl >= $sql_option['pkt']['minpkt']) && ($aktuellepunktzahl < $sql_option['pkt']['midminpkt'])) { //Wenn aktuelle Punktzahl größer als minimalste und kleiner als kleinste Mittlere ist
				$einlösenfür = $sql_option['value']['minvalue'];	
			} else if (($aktuellepunktzahl >= $sql_option['pkt']['midminpkt']) && ($aktuellepunktzahl < $sql_option['pkt']['midmaxpkt'])) { //Wenn aktuelle Punktzahl größer als kleinste Mittlere und kleiner als größte Mittlere ist
				$einlösenfür = $sql_option['value']['midminvalue'];
			} else if (($aktuellepunktzahl >= $sql_option['pkt']['midmaxpkt']) && $aktuellepunktzahl < $sql_option['pkt']['maxpkt']) { //Wenn aktuelle Punktzahl größer als größte Mittlere und kleiner als größte ist
				$einlösenfür = $sql_option['value']['midmaxvalue'];
			} else if ($aktuellepunktzahl >= $sql_option['pkt']['maxpkt']){ //Ab Maximalwert
				$einlösenfür = $sql_option['value']['maxvalue'];
			} else {
				$nichgenugpunkte = "leider!";
				$einlösenfür = "Reicht noch nicht!";
			}
		}
	}
						##### Abfrage ob Punkte eingelöst werden ##### 
	if (($_SESSION['group'] == "admin" || $_SESSION['group'] == "azubi") && isset($_POST['punkteein'])) {		echo var_dump($_POST);		
		##### gelöste Aufbage auslesen ####
		$sql = 'SELECT * FROM `archive` WHERE name = "' . $_SESSION['username'] . '" && `gewonnen` != 1 ;';
		$ergebnis = mysqli_query( (new database)->con(), $sql );		
		while ($zeile = mysqli_fetch_array( $ergebnis, MYSQLI_ASSOC)){
			############ DB eintrag ########### 
			echo $zeile['beschreibung'];
			$sql = "INSERT INTO `winner`(`username`, `gewollt`, `beschreibung`, `expires`) VALUES ('" . $_SESSION['username'] . "','$einlösenfür','" . $zeile['beschreibung'] . "', '');";
			$updaten = mysqli_query( (new database)->con(), $sql );						//User im Archive als Gewonnener eintragen			$sql = 'INSERT INTO `archive`(`gewonnen`) VALUES (1) WHERE name = "' . $_SESSION['username'] . '" && `beschreibung` = ' . $zeile['beschreibung'] . ' && gewonnen` != 1;';			$ergebnis = mysqli_query( (new database)->con(), $sql );						//Users Punkte abziehen			$sql = 'UPDATE `users` SET `punkte`=`punkte`-' . $zeile['punkte'] . ' WHERE `username`= "' . $_SESSION['username'] . '";';			$ergebnis = mysqli_query( (new database)->con(), $sql );			echo var_dump($ergebnis);
		}										
		
		//Beenden
		unset($_POST['punkteein']);
	}
?>

<details>
    <summary>Punkte</summary>
    <br>
        <table class="board">
            <tr>
                <th>
                    Aktuelle Punktzahl: 
                </th>
                <th>
                </th>
            </tr>			
            <tr>
                <td <?php if (isset($aktuellepunktzahl) && $aktuellepunktzahl >= $sql_option['pkt']['minpkt']) { echo'style="background-color: rgba(0,250,50,0.1);"';} ?>>
                    <?php if (isset($aktuellepunktzahl)) {echo $aktuellepunktzahl;} else { echo 0;} ?>
                </td>
                <td>
					<form id="" name="punkte_einloesen" method="post">
						<button name="punkteein" value="<?php echo $_SESSION['username']; ?>" id="punkteein" <?php if (isset($nichgenugpunkte)) {} else {echo "class='enabled'";}?> onclick="" <?php if (isset($nichgenugpunkte)) {echo "disabled";}?>>Punkte einlösen!</button>
					</form>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; border: none;">
                    Du kannst deine Punkte einlösen, für:
                </td>
                <td>
                    <?php echo $einlösenfür; ?>
                </td>
            </tr>
        </table>
</details>

<div class="winner_info">
	
</div>