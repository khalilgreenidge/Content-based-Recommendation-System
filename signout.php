<?php
	session_start();
	
	//DESTROY SESSION
	session_destroy();
	
	// set the expiration date to one hour ago
	setcookie("email", "", time() - 3600);
	setcookie("name", "", time() - 3600);
	setcookie("type", "", time() - 3600);
	setcookie("company", "", time() - 3600);
	setcookie("companyid", "", time() - 3600);
	
	$url = "";
	
	if(isset($_GET["back"])) {
		$url = $_GET["back"];
		header("Location: signin.php?back=".$url);
	}
	else	
		header("Location: signin.php");
?>