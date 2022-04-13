<?php

	//get session variables
	session_start();	

	//get class autoloader
	include 'autoloader.php';

	// define variables and set to empty values
	$title = $emp_type = $companyid  = $overview  = $duties = $requirements = $salary = "";
	$time = 0;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
		$title = sanatise($_POST["title"]);
		$emp_type = sanatise($_POST["emp_type"]);
		$companyid = $_SESSION["companyid"];
		$overview = sanatise($_POST["overview"]);
		$duties = sanatise($_POST["duties"]);
		$requirements = sanatise($_POST["requirements"]);
		$keywords = sanatise($_POST["keywords"]);
		$time = strtotime("now");
		
		echo 'Time is: '.$time;

		//add campaign to table using User class
		$system = new User();
		 
		
		if($system->addCampaign($title, $emp_type, $companyid, $overview, $duties, $requirements, $keywords, $time)){
			echo 
			'<div class="alert success">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
				You have successfully added a new campaign!
			</div>
			<script>
				setTimeout(function () {
					window.location.href= \'newcampaign.php\'; // the redirect goes here

				},1000);
			</script>';
		}
		else{
			echo '	
			<div class="alert error">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
				Something went wrong!
			</div>			
			';
		}
			
	}
	
	
	function sanatise($data){
		$data = trim($data);
		return $data;
	}
?>