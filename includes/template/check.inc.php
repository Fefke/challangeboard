<?php
########## Check User ##########
/**/
$funny_action = array(
	"1" => "Spiele nicht mit dem Feuer!",
	"2" => "Warum ist >Abkürzung< so ein langes Wort?",
	"3" => "Gibt's ein anderes Wort für Synonym?",
	"4" => "Warum sind Möhren orangener als Orangen?",
	"5" => "FBI: Du hast keinen Zugang!"
);


$user_check = $_SESSION['username'];
$login_user = NULL;
$sql = mysqli_query( (new database)->con(),"SELECT * FROM users WHERE username= '$user_check' ");
if ($sql != true) {
	$_SESSION = NULL;
	session_destroy();
	session_start();
		/* Redirect auf eine andere Seite im aktuell angeforderten Verzeichnis */
	$host  = $_SERVER['HTTP_HOST'];
	header("Location: http://$host/");
	echo "<script type='text/javascript'>window.location = 'http://".$host."';</script>";
	exit();
	$_SESSION['info'] = "Diesen Benutzer gibt es nicht!";
	exit();
} else {
	$row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
	$login_user = $row['username'];
}

if(isset($_POST["login"])){
	header("Location: /");
	$_SESSION['info'] = "Ungültiger Account!";
	exit();
} else if (!isset($login_user)) {
	header("Location: /");
	$zufallsspruch = rand(1,5);
	$_SESSION['info'] = $funny_action["" . $zufallsspruch . ""];
	exit();
}
?>