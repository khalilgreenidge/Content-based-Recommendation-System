<?php

    $cid = $_GET["cid"];
    $size = $_GET["size"];

    include 'autoloader.php';

    $generator = new User();
    

    if($generator->generateCandidates($cid, $size)){
        //echo "It worked! ";
        echo true;
    }        
    else{
        //echo 'Something went wrong';
        echo false;
    }

?>