<?php

    class Dbh {
        const host = "localhost";
        const user = "root";
        const pwd = "";
        const dbName = "mscproject";
        protected $pdo = "";

        public function connect(){

            try {
                //code...
                $dsn = "mysql:host=" . self::host . ';dbname=' . self::dbName;
                $pdo = new PDO($dsn, self::user, self::pwd);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch (PDOException $e) {
                echo "Connection failed: ".$e->getMessage();
            }


            
        }

        protected static function disconnect(){
            $pdo = null;
        }

    }

?>