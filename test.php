<?php

include 'autoloader.php';

$system = new User();

//echo $system->generateCandidates(1, 3);

//test get applicants
//$apps = $system->getApplicants(1);
//print_r($apps);
$_GET["algo"] = "KNN";
$cid = 1;

//test predict
//$applicants = json_decode($system->predict($_GET["algo"], $cid), true);
//$applicants = json_decode($system->predict($_GET["algo"], $cid), true);  //test KNN using campaign 1

print_r(json_decode($system->predict($_GET["algo"], $cid), true));

//print_r($applicants);  //test KNN using campaign 1

//echo "C:\xampp\htdocs\Mscproject\kxg087\Localhost\Python"

?>