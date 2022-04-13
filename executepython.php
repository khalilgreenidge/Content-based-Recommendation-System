<?php

    echo "It worked!";
    $command = escapeshellcmd("python Python/Pandas.py");
    $output = shell_exec($command);

    //print the output from the python script
    echo $output;

?>