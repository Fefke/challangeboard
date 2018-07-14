<?php
###################################################################################################
###█##█###█##█████##█████##█████##█######█############█████##█#####█##█##█#########▓###▓###########
###█##██##█##█########█####█###█##█######█############█######█#####█##█#█##########▓▓##▓###########
###█##█#█#█##█████####█####█████##█######█############█████##█#██##█##██####█████##▓#▓#▓###########
###█##█##██######█####█####█###█##█######█################█##███#███##█#█##########▓##▓▓###########
###█##█###█##█████####█####█###█##█████##█████########█████##██###██##█##█#########▓###▓###########
###################################################################################################
################################ C H A L L E N G E - B O A R D ####################################
###################################################################################################

# All Copyrights deserved by: Stadtwerke Karlsruhe GmbH (Abt. TP/GA), Pfannkuchstr. 3, 
# 76185 Karlsruhe, Baden-Württemberg, Germany.
#
# Created by Felix Blank : version 1.0 (BETA) | Jahr: 2018
# 
#
#									 I N S T R U C T I O N S									  #
#
# If this file is opened with an Version of PHP (newer then 7.1) an automatic progress will create
# or reset tables within a database defined at:
# /includes/config.inc.php -> define all constans with your DB-Data
# 
# Please don't forget to delete this file before hosting the website!
# It wont delete any of your data but will overwrite an default admin user (for reset) and also 
# the legend.
#

###################################################################################################
####################  Includieren von Zusätzen  ###################################################
###################################################################################################

include "../includes/class/controller.inc.php";
//Connect with (Constant) data from config.php
require "../includes/config.inc.php";
//Bring in the database class
require "../includes/class/database.inc.php";

###################################################################################################
#################  Create Tables -> or clear them  ################################################
###################################################################################################

############### Create ###############
//Das Challangeboard
$challange_board = mysqli_query((new database)->con(),"
CREATE TABLE IF NOT EXISTS `challange_board` (
			id INT NOT NULL,
    		beschreibung TEXT NOT NULL,
			punkte INT,
			name VARCHAR(255),
			PRIMARY KEY (id)
);");

//Die Benutzer
$users = mysqli_query((new database)->con(),"
CREATE TABLE IF NOT EXISTS `users` (
 `id` int(25) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `group` varchar(50),
  `punkte` int(250),
  `online` bit,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);");

//Einstellungen (Admin)
$config = mysqli_query((new database)->con(),"
CREATE TABLE IF NOT EXISTS `config` ( 
    `id` int NOT NULL,
    `option` text,
	PRIMARY KEY (`id`)
);");


//Archiv
$challange_board = mysqli_query((new database)->con(),"
CREATE TABLE IF NOT EXISTS `archive` (
			id INT NOT NULL,
    		beschreibung TEXT NOT NULL,
			punkte INT,
			name VARCHAR(255),
			gewonnen BIT,
			PRIMARY KEY (id)
);");


//Gewinner
$users = mysqli_query((new database)->con(),"
CREATE TABLE IF NOT EXISTS `winner` (
  `username` varchar(50) NOT NULL,
  `gewollt` varchar(50),
  `beschreibung` text,
  `expires` TIMESTAMP,
  PRIMARY KEY (`username`)
);");


//Backup Tabelle für das Board
$users = mysqli_query((new database)->con(),"
CREATE TABLE IF NOT EXISTS `cb_backup` (
			id INT NOT NULL,
    		beschreibung TEXT NOT NULL,
			punkte INT,
			name VARCHAR(255),
			PRIMARY KEY (id)
);");


/*
Neue Werte einfügen
INSERT INTO `challange_board`(`id`, `beschreibung`, `punkte`, `name`) VALUES (1,1,1,1)
Neu Werte/erbesserungen einfügen
UPDATE `challange_board` SET `beschreibung`= 1,`punkte`= 1,`name`= 1 WHERE id = 1
*/





###################################################################################################
#################  Fill config  ###################################################################
###################################################################################################

//Create Default admin user -> Default Password
$sql = "REPLACE INTO `users` (`id`,`username`,`password`,`group`,`punkte`) VALUES (1, 'admin', '" . "'$6$rounds=7000$stadtwerke_secur$FiMtE/YWpN17eeywkci55HJSarkUOlnbpOJ4KWp7V.IowoqaR/ymrnbWNEAuZkNX0q3polm8hnzX8aXZmKavI1'" . "', 'admin', 100)";
$row = mysqli_query((new database)->con(),$sql);



//Default
	$legende = array(
		'pkt' => array(
			'maxpkt' => '100',
			'midmaxpkt' => '80',
			'midminpkt' => '50',
			'minpkt' => '30'
		),
		'value' => array(
			'maxvalue' => 'Kuchen',
			'midmaxvalue' => 'Muffin',
			'midminvalue' => '1kg Haribo',
			'minvalue' => 'Überraschung'
		)
	
	);
//Upload Default (later chngeable)
	$upload = json_encode($legende, JSON_UNESCAPED_UNICODE);
	$sql = "REPLACE INTO `config` (`id`, `option`) VALUES (1,'$upload')";
	$row = mysqli_query((new database)->con(),$sql);
	
//Erstelle backup in cb_backup Tabelle vom Challangeboard
	$backup = mysqli_query((new database)->con(),"
	REPLACE INTO `cb_backup` (id, beschreibung, punkte, name) SELECT id, beschreibung, punkte, name FROM `challange_board`;
	");
	
 ?>
 
 <!DOCTYPE html>
 
 <html>
 <head>
	<meta charset="utf-8">
	
	<style>
	.info {
		font-family: Verdana;
		#inhalte-werden-zentriert {
	  display: flex;
	  align-items: center;
	  justify-content: center;
}
	}
	
	</style>
	
	
 </head>
 
 <body>
 
	<div class="info">
		<img width="32px" src="../img/info/loader.gif"/>
	</div>
 
 </body>
 
 </html>
 
 
 <?php
 
 sleep(3);
 header("Location: /");
 ?>
 
 
 