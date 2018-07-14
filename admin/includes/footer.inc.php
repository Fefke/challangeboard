<?php
	############### FOOTER ###############
	########## Safing controller #########
?>

<button class="extra" id="delete" title="letzte Reihe löschen" onclick="deleterow()">&#8855;Löschen</button>
<button class="extra" id="add" title="Neue Reihe Hinzufügen" onclick="addRow()"> &#10010; Hinzufügen</button>
<p>*&#9996;	&#10004; &#10132; Archivieren</p>
<style>
#reset_btn_admin {
	z-index: 999999992;
	position: fixed;
	right: 20px;
	bottom: 20px;
	background-color: red;
	font-weight: bold;
	box-shadow: 5px 5px 5px #444444;
}

#delete:not([disabled]) {
	background-color: red;
}

.extra:not([disabled]):hover, #delete:not([disabled]):hover, #reset_btn_admin:hover {
	background-color: grey;
}

.extra[disabled] {
	background-color: #dddddd;
}


</style>

<button class="extra" title="Zurücksetzen von Änderungen\n Auf letzten Speicherwert" id="reset_btn_admin" onclick="location.reload();">Reset</button>