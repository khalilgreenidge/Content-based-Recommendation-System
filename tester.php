<?php



    include 'UserClass.php';

    $user = new User("k.greenidge@jobhuntes.co");

    //echo User::isUser("k.greenidge@jobhunters.co");

    echo $user -> verifyPassword("k.greenidge@jobhunters.co", "P@ssw0rd");

    //echo $user;


?>