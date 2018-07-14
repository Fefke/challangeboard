<?php
class controller {
	public function challange_board($type) {
		//SQL Query
		$sql = "SELECT * FROM `challange_board`";
		$ergebnis = mysqli_query( (new database)->con(), $sql );
		
		############### erstellen der Tabelle ###############
		echo '<table id="board" class="board" name="safe_cb_changes">';
		
		################ Dynamischer Inhalt #################
		//Für Benutzergruppen spezifische Ausgabe
		if ($type == "admin") {
			//Für Admins
			echo '<form class="board" id="admin_sf" method="post" name="admin_safe">';
			while ($zeile = mysqli_fetch_array( $ergebnis, MYSQLI_ASSOC)){		  
				echo "<tr>";
				echo "<td><input class='boardids' name='id[]' type='hidden' value='" . $zeile['id'] . "'/>" . $id ."</td>";
				echo "<td><input class='bes' name='bes[]' type='text' value='" . $zeile['beschreibung'] . "'/></td>";
				echo "<td><input class='pkt' name='pkt[]' type='number' min='0' value='" . $zeile['punkte'] . "'/></td>";
				echo "<td><input class='name' name='name[]' type='text' value='" . $zeile['name'] . "'/></td>";
				echo "</tr>";
			}
			
		} else if ($type == "azubi") {
			//Für Azubi
			echo '<form method="post" id="azubi_sf" name="azubi_safe">';
			while ($zeile = mysqli_fetch_array( $ergebnis, MYSQLI_ASSOC)){
				echo "<tr>";
				echo "<td><input class='id' name='id[]' type='hidden'  value='" . $zeile['id'] . "'/>" . $id ."</td>";
				echo "<td>" . $zeile['beschreibung'] . "</td>";
				echo "<td>" . $zeile['punkte'] . "</td>";			  
			  //Abfrage ob bereits Eingetragen
				if ($zeile['name'] != $_SESSION['username'] && !empty($zeile['name'])) {
					echo "<td>" . $zeile['name'] . "</td>";
				} else if ($zeile['name'] == $_SESSION['username']){
					echo "<td>
					<input class='name' name='name[]' type='checkbox'  value='". $zeile['id'] ."' checked/>
					</td>";
				} else {
					echo "<td>
					<input class='name' name='name[]' type='checkbox' value='". $zeile['id'] ."'/>
					</td>";
				}
			 echo "</tr>";
			}
			
		} else {
			//Default | Ohne Einstellungsmöglichkeiten
			if ($ergebnis == false || mysqli_num_rows($ergebnis) <= 0) {
				echo "<tr>
					<td>-</td>
					<td><strong style='color: red;'>Es liegen keine Einträge vor!</strong></td>
					<td>-</td>
					<td>-</td>
				</tr>";				
			} else {
				while ($zeile = mysqli_fetch_array( $ergebnis, MYSQLI_ASSOC)){		  
					echo "<tr>";
					echo "<td>" . $id . "</td>";
					echo "<td>" . $zeile['beschreibung'] . "</td>";
					echo "<td>" . $zeile['punkte'] . "</td>";
					echo "<td>" . $zeile['name'] . "</td>";
					echo "</tr>";
				}
			}
		echo "</table>";
		############## Tabelle fertiggestellt ############		
		###################### FOOTER ####################
		//Speichern Button und andere Dynamische Optionen
		if ($type == "admin" || $type == "azubi") {
			echo '<input type="submit" name="safe_cb_changes" value="Speichern" style="max-width: 200px;"></form>';
		} else {
			echo "<br>";
		}
		echo '<script language="javascript" type="text/javascript" src=""></script>';
	}//public function challange_board($type) 
	public function upload_cb() {
		if (!isset($_POST['safe_cb_changes'])) {
		    echo '<script>alert("Die Änderungen konnten aufgrund eines unbekannten Fehlers nicht eingetragen werden!  \n\nError Code: upload_cb()\n\nBitte Admin melden!\n=>Für weitere Benutzung Seite aktualisieren...");</script>';
		    exit;
		}
		if ( $_SESSION['group'] == 'admin') {
		    //DB Eintrag von Admins (alles)
			if (isset($_POST['id']) && isset($_POST['bes']) && isset($_POST['pkt']) && isset($_POST['name'])) {
				
				$bes = $_POST['bes'];
				$pkt = $_POST['pkt'];
				$name = $_POST['name'];
				foreach($id as $row) {
					//SQL Query
					$sql = "REPLACE INTO `challange_board` (`id`,`beschreibung`,`punkte`,`name`) VALUES ('$row','" . $bes[$index] . "','" . $pkt[$index] . "','" . $name[$index] . "');";
					$updaten = mysqli_query( (new database)->con(), $sql );
				}
			}
		    //DB Eintrag von Azubi (Name nach ID)
				$id = $_POST['id'];
				$name = $_POST['name'];
			} else {
            ##### Alte Einträge löschen #####
				$sql = "UPDATE `challange_board` SET `name`= '' WHERE `name` = '" . $_SESSION['username'] . "';";
				$delit = mysqli_query((new database)->con(),$sql); 
					
				foreach($name as $row) {
                    //$row gibt den Wert der Checkbox -> also die ID, aus!
					//SQL Query
					if (is_numeric($row)) {
						//Füge dich als Verantwortlicher ein
						$sql = "UPDATE `challange_board` SET `name`='" . $_SESSION['username'] . "' WHERE id =  " . $row . ";";
						$updaten=mysqli_query((new database)->con(),$sql);
					}
				}
		} else if ($_SESSION['group'] != "azubi" || $_SESSION['group'] != "admin"){
		    echo "<script type='text/javascript'>alert('Du hast keine Berechtigung etwas in die Datenbank zu schreiben!');</script>";
		}
	
	//RESET given POST
	$_POST['id'] = NULL;
    $_POST['bes'] = NULL;
	$_POST['pkt'] = NULL;
	$_POST['name'] = NULL;
	}
} //class controller
?>