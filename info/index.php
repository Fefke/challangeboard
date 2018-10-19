<!DOCTYPE html>
<html>
<head>	
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />		
   
   <title>SWKN | Info</title>
   
   <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico">
   <link rel="stylesheet" href="../css/style.css" type="text/css">
</head>
<body class="normalbg">

<div class="info">
<?php
   if (isset($_GET['info']) && $_GET['info'] == "passwd") {
           include "./passwd.info.inc.php";
   } else if (isset($_GET['info']) && $_GET['info'] == "datenschutz") {
           include "./datenschutz.php";
   } else {
           include "./impressum.php";
   }
?>
</div>
</body>
</html>