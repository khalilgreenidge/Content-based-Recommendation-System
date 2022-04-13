<?php

	session_start();
	
	if(isset($_SESSION["login"])){
		header("Location: signout.php");
		exit();
	}
	else{
		
		//DEFINE VARIABLES
		$email = $pwd = $name = $remember = $dbemail = $dbpwd = $type = "";
		
		//CHECK IF USER SUBMITTED FORM
		if($_SERVER["REQUEST_METHOD"] == "POST" ){


						
			//FILTER RAW DATA
			$email = sanatise($_POST["email"]);
			//$password = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
			$password = $_POST["pwd"];


			echo "Password is ".$password;
			
			$type = $_POST["type"];
									
			if($type == "jobseeker"){
				header("Location: cdashboard.php");	
				
				
				$name = "Jackie Chetty";
				$gender = "female";
			}
				
			else if($type == "recruiter"){
				header("Location: cdashboard.php");	
				
				$name = "Mike Tyson";
				$gender = "male";
				
				$_SESSION["company"] = "Google";
				
				
			}

			//MAKE LOGIN ACTIVE
			$_SESSION["login"] = "yes";
		
			//CREATE SESSION FOR TYPE OF USER
			$_SESSION["type"] = $type;
																		
			//GET NAME FOR SESSION
			$_SESSION["name"] = $name;
			
			//CREATE SESSION FOR EMAIL
			$_SESSION["email"] = $email;
			
			//CREATE SESSION FOR GENDER
			$_SESSION["gender"] = $gender;
			
			//CREATE SESSION FOR COMPANY
			$_SESSION["companyid"] = 1;

		}

			
	}


	function sanatise($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		$data = htmlentities($data);
		return $data;
	}


?>