<?php
    //namespace users;

    class User {

        //local variables
        protected $email = "";
        protected $password = "";
        protected $name = "";
        protected $dob = "";
        protected $country = "";
        protected $gender = "";
        protected $cell = "";
        protected $last_login = "";
        protected $date_Created = "";

        //Methods

        public function ___construct ($email){

            $email = sanatise($email);

            //Search database for everything and save it in the variables
            userConnect();

            if(isUser($email)){
                    //read data
                $rs = $con->prepare("SELECT * FROM users where email = ? ");
                $rs->bind_param("s", $email);
                $rs->execute();
                
                if(!$con || !$rs){
                    die( "Error: right here".$conn->connect_error);
                }
                else{
                    if($rs>0){
                        while($row = $rs->fetch_assoc() ){
                            $this->$email = $row["email"];
                            $this->$email = $row["password"];
                            $this->$name = $row["name"];
                            $this->$dob = $row["dob"];
                            $this->$country = $row["country"];
                            $this->$gender = $row["gender"];
                            $this->$cell = $row["cell"];
                            $this->$last_login = $row["last_login"];
                        }
                    }
                    
                }
                $returnValue = 1;
            }
            else
                $returnValue = 0;

            

            //Close connection
            userClose();
            
            return $returnValue;
        }

        public function verifyPassword($emailParam, $passParam){

            //first check if user exists
            if(isUser($emailParam)){

                //Search database for everything and save it in the variables
                userConnect();

                //read data
                $rs = $con->prepare("SELECT * FROM users where email = ? ");
                $rs->bind_param("s", $email);
                $rs->execute();
                
                if(!$con || !$rs){
                    die( "Error: right here".$conn->connect_error);
                }
                else{
                    if($rs>0){
                        while($row = $rs->fetch_assoc() ){
                            $this->$email = $row["email"];
                            $this->$email = $row["password"];
                            $this->$name = $row["name"];
                            $this->$dob = $row["dob"];
                            $this->$country = $row["country"];
                            $this->$gender = $row["gender"];
                            $this->$cell = $row["cell"];
                            $this->$last_login = $row["last_login"];
                        }
                    }
                    
                }
                

                //disconnect form DB
                userDisconnect();

                return true;
            }
            else{
                 //it user doesn't exist
                return false;
            }
               

        }

        public function getEmail(){
            return $this->$email;
        }

        public function getPassword(){
            return $this->$name;
        }

        public function getName(){
            return $this->$name;
        }

        public function getDob(){
            return $this->$dob;
        }

        public static function isUser($emailParam){
            //connect to establish a lock
            userConnect();

            //search if user exists
            if(userConnect() != 0){
                
                //prepare and bind
                $rs = $con->prepare("Select email FROM users WHERE email = ?");
                $rs->bind_param("s", $emailParam);
                $rs->execute();

                if(!$con || !$rs){
                    die( "Error: right here".$conn->connect_error);
                }
                else{
                    if($rs>0){
                        return 1;
                    }
                    else
                        return 0;
                }
            }


            //disconnect to release lock
            userDisconnect();
        }

        public function userConnect(){
            
            //create connection
            $server = "localhost"; $user="root"; $pwd=""; $db="mscproject";		
	        $con = new mysqli($servername, $username, $password);

            if($con->connect_error()){
                die("Connection failed: " . $conn->connect_error);
                return 0;
            }
        }

        public function userDisconnect(){
            
            //create connection
            $con->close();
        }



       
    }
    



?>
