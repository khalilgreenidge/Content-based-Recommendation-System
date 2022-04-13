<?php

    spl_autoload_register('myAutoLoader');

    function myAutoLoader($className){
        
        /*
        
        $path = "classes/";
        $ext = ".php";
        $fullPath = $path . $className . $ext;

        if(!file_exists($fullPath))
            return false;

        include_once $fullPath;

        */

        $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $path = 'classes/';

        $ext = '.php';

        include_once $path . $className. $ext;

    }

  

?>