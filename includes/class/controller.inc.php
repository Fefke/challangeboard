<?php
class controller {
	
	public function challange_board($type) {	
		$db = (new database);//Neue Datenbanken instanz
        //Variablen		
            $id = 0;	
		//SQL Query
		$sql = "SELECT * FROM `challange_board`";
		$ergebnis = $db->query($sql);
		
		############### erstellen der Tabelle ###############
		echo '<table id="board" class="board" name="safe_cb_changes">';
				
		################ Dynamischer Inhalt #################
		//Für Benutzergruppen spezifische Ausgabe
		
		if ($type == "admin") {
			##### Admins #####
			echo '<tr><th class="id">ID</th> <th class="bes">Beschreibung</th> <th class="pkt" title="Punkte">Pkt.</th> <th class="name">Name</th><th class="arch" title="Archivieren bewirkt neben dem offensichtlichen\nnoch das erstellen einer Gewinnerlaubnis\nfür den entsprechenden Benutzer\n(sprich er bekommt die Punkte gutgeschrieben)\n&#10149; Zeile wird hier entfernt">&#9996;	&#10004;</th></tr>';//Kopfzeile
			echo '<form class="board" id="admin_sf" method="post" name="admin_safe">';
			if ($ergebnis == false || mysqli_num_rows($ergebnis) <= 0) {
				
				$max_archive = database::query("SELECT MAX(`id`) FROM `archive`");
				$max_archive = mysqli_fetch_array($max_archive);
				$id = $max_archive["MAX(`id`)"] + 1;
				if ( empty($id) || $id == 0) {$id = 1;}
					echo "<tr>";
					echo "<td><input class='boardids' name='id[]' type='hidden' value='" . $id . "'/>1</td>";
					echo "<td><input class='bes' name='bes[]' type='text' value=''/></td>";
					echo "<td><input class='pkt' name='pkt[]' type='number' min='0' value=''/></td>";
					echo "<td><input class='name' name='name[]' type='text' value=''/></td>";				
					echo "<td><input class='arch' name='arch[]' type='checkbox' value=''/></td>";
					echo "</tr>";
				
			} else {			
				while ($zeile = mysqli_fetch_array($ergebnis, MYSQLI_ASSOC)){                  
					$id = $id + 1;
					echo "<tr>";
					echo "<td><input class='boardids' name='id[]' type='hidden' value='" . $zeile['id'] . "'/>" . $id ."</td>";
					echo "<td><input class='bes' name='bes[]' type='text' value='" . $zeile['beschreibung'] . "'/></td>";
					echo "<td><input class='pkt' name='pkt[]' type='number' min='0' value='" . $zeile['punkte'] . "'/></td>";
					echo "<td><input class='name' name='name[]' type='text' value='" . $zeile['name'] . "'/></td>";				
					echo "<td><input class='arch' name='arch[]' type='checkbox' value='" . $zeile['id'] . "'/></td>";
					echo "</tr>";
				}
			}          
			
		}
		else if ($type == "azubi") 
		{
            ##### Für Azubi #####
			echo '<tr><th class="id">ID</th> <th class="bes">Beschreibung</th> <th class="pkt" title="Punkte">Pkt.</th> <th class="name">Name</th></tr>';//Kopfzeile
			echo '<form method="post" id="azubi_sf" name="azubi_safe">';
			while ($zeile = mysqli_fetch_array($ergebnis, MYSQLI_ASSOC)){
                $id = $id + 1;
				echo "<tr>";
				echo "<td><input class='id' name='id[]' type='hidden'  value='" . $zeile['id'] . "'/>" . $id ."</td>";
				echo "<td>" . $zeile['beschreibung'] . "</td>";
				echo "<td>" . $zeile['punkte'] . "</td>";			  
				//Abfrage ob bereits Eingetragen
				if ($zeile['name'] != $_SESSION['username'] && !empty($zeile['name'])) { echo "<td>" . $zeile['name'] . "</td>";}
				else if ($zeile['name'] == $_SESSION['username']){echo "<td><input class='name' name='name[]' type='checkbox'  value='". $zeile['id'] ."' checked/></td>";} 
				else { echo "<td><input class='name' name='name[]' type='checkbox' value='". $zeile['id'] ."'/></td>";}
			 echo "</tr>";
			}
			
		} 
		else 
		{
			##### Default #####			
			echo "<tr><th class='id'>ID</th> <th class='bes'>Beschreibung</th> <th class='pkt' title='Punkte'>Pkt.</th> <th class='name'>Name</th></tr>";//Kopfzeile
			if ($ergebnis == false || mysqli_num_rows($ergebnis) <= 0) {
				echo "<tr>
					<td>-</td>
					<td><strong style='color: red;'>Es liegen keine Einträge vor!</strong></td>
					<td>-</td>
					<td>-</td>
				</tr>";				
			} else {
				while ($zeile = mysqli_fetch_array( $ergebnis, MYSQLI_ASSOC)){		  					
					$id = $id + 1;
					echo "<tr>";
					echo "<td>" . $id . "</td>";
					echo "<td>" . $zeile['beschreibung'] . "</td>";
					echo "<td>" . $zeile['punkte'] . "</td>";
					echo "<td>" . $zeile['name'] . "</td>";
					echo "</tr>";
				}
			}		}
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

	
###########################################################
#####	UPLOAD	###########################################
###########################################################

	
    public function upload_cb() {
				
		if (!isset($_POST['safe_cb_changes'])) {
		    echo '<script>alert("Die Änderungen konnten aufgrund eines unbekannten Fehlers nicht eingetragen werden!  \n\nError Code: upload_cb()\n\nBitte Admin melden!\n=>Für weitere Benutzung Seite aktualisieren...");</script>';
		    exit;
		}
		
		if ( $_SESSION['group'] == 'admin') {
		    ##### Admins (alles) #####
			if (isset($_POST['id']) && isset($_POST['bes']) && isset($_POST['pkt']) && isset($_POST['name'])) {
				//Erstelle backup in cb_backup Tabelle vom Challangeboard
                $backup = mysqli_query((new database)->con(),"REPLACE INTO `cb_backup` (id, beschreibung, punkte, name) SELECT id, beschreibung, punkte, name FROM `challange_board`;");
                                
                                
                #### Variablen #####
                                
                $id = $_POST['id'];
				$bes = $_POST['bes'];
				$pkt = $_POST['pkt'];
				$name = $_POST['name'];	
				//Archiveierung vorhanden?				
                if (isset($_POST['arch'])) {$arch = $_POST['arch'];}
                                
                                
                ### Vorbereitung ###
                                
                $result = "SELECT MAX(`id`) AS `max_id` FROM `cb_backup`";
                $result = mysqli_query( (new database)->con(), $result );
                $max_id = mysqli_fetch_array($result);
                $differenz = $max_id["max_id"] - max($id);//löschen von zu löschenden Einträge
				
                if ($differenz >= 1) {
                    $rightid = max($id) + 1;
					for ($i = $rightid; $i <= $max_id["max_id"]; $i++) {
                                $result = "DELETE FROM `challange_board` WHERE `id` = $i";
                                database::query($result);
                            }				
                    }	
                //Upload
				$index = -1;
                foreach($id as $row) {			
                    $index = $index + 1;
					//Breaker für leerfall
					if (empty($bes[$index]) && empty($pkt[$index]) && empty($name[$index])) {break;}
					//SQL Query
					$sql = "REPLACE INTO `challange_board` (`id`,`beschreibung`,`punkte`,`name`) VALUES ('" . $row . "','" . $bes[$index] . "','" . $pkt[$index] . "','" . $name[$index] . "');";
					$updaten = mysqli_query( (new database)->con(), $sql );
				}
                                
                                
                                
                ##### ARCHIVIERUNG #####
                                
				if (isset($arch) && $arch != NULL) {
                                        foreach($arch as $row) {
                                                //$row gibt den Wert der Checkbox -> also die ID, aus!	
                                                //SQL Query				
                                                if (is_numeric($row)) {	
                                                        //In Archiv einfügen		
                                                        $sql = "INSERT INTO `archive` (id, beschreibung, punkte, name) 
                                                        SELECT id, beschreibung, punkte, name FROM `challange_board` WHERE `id` = $row;";
                                                        $updaten=mysqli_query((new database)->con(),$sql);
                                                        //CB delete				
                                                        $sql = "DELETE FROM `challange_board` WHERE `id` = $row;";													
                                                        $updaten=mysqli_query((new database)->con(),$sql);														
                                                        //IDs müssen nachrücken!							
                                                        // ALLe nach $row - $row													
                                                  }									
                                               }				
                                    }
			}//ADMIN Safe
                        
        }//ADMIN Selection
        else if ($_SESSION['group'] == 'azubi') 
        {
		    ##### Azubi #####						
            if (isset($_POST['name']) && isset($_POST['id'])) {
				$id = $_POST['id'];
				$name = $_POST['name'];
			} else {
				$name = NULL;
			}
					
			##### Alte Einträge löschen #####
				
			$sql = "UPDATE `challange_board` SET `name`= '' WHERE `name` = '" . $_SESSION['username'] . "';";
			$delit = mysqli_query((new database)->con(),$sql); 
					
			if ($name != NULL) {
				foreach($name as $row) {
					//$row gibt den Wert der Checkbox -> also die ID, aus!
					//SQL Query
					if (is_numeric($row)) {
						//Füge dich als Verantwortlicher ein
						$sql = "UPDATE `challange_board` SET `name`='" . $_SESSION['username'] . "' WHERE id =	" . $row . ";";
						$updaten=mysqli_query((new database)->con(),$sql);
					}
				}
			}		
		}
		else 
		{//Der Fall, dass gar nichts passt
			echo "<script type='text/javascript'>alert('Du hast keine Berechtigung etwas in die Datenbank zu schreiben!');</script>";			
		}	
	
	//RESET given POST
	$_POST['id'] = NULL;
	$_POST['bes'] = NULL;
	$_POST['pkt'] = NULL;
	$_POST['name'] = NULL;	
	$_POST['arch'] = NULL;
	$_POST = NULL;
	unset($_POST);	
	}
} //class controller
?>