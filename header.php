<?php
	//session_start();
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(isset($_SESSION["email"])){
		//Search for profile photo
		if(file_exists("../users/profilepics/".md5($_SESSION["email"]).".png?")){ 
			$pic = "../users/profilepics/".md5($_SESSION["email"]).".png?".time();
		}
		else if(file_exists("../users/profilepics/".md5($_SESSION["email"]).".jpg")){ 
			$pic = "../users/profilepics/".md5($_SESSION["email"]).".jpg?".time();
		}
		else if(file_exists("../users/profilepics/".md5($_SESSION["email"]).".jpeg")){
			$pic = "../users/profilepics/".md5($_SESSION["email"]).".jpeg?".time();
		}
		else{
			//check for gender
			if($_SESSION["gender"] == "male")
				$pic = "../imgs/avatars/avatar2.png";
			else
				$pic = "../imgs/avatars/avatar1.png";
		}
	} 
	else{
		$pic = "../imgs/user2.png";
		
	}

	/* if(isset($_GET)){
		print_r($_GET);
		
		foreach($_GET as $x => $x_value) {
			echo "signin.php?back=".basename($_SERVER['PHP_SELF'])."?".$x."=".$x_value; echo "<br>";
		}
		
		exit();
	} */
		

		
?>
<html DOCTYPE!>
<head>
	<title>MSc. Project </title>
	<link rel="shortcut icon" href="imgs/logo2.png" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link href='//fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
	<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />	
	<meta name="description" content="The Social Network for Employment. Find your dream job in the Barbados. Find internships, full-time, part-time, temporary, and voluntary jobs in Barbados. Get job alerts to your phone via text or by email. Apply 
	to jobs, and get interviews.">
	<meta name="keywords" content="job advertising, posting jobs in Barbados, Jobs in Barbados, Job Vacancies in Barbados, Jobs, Jobs in the Caribbean, Caribbean Jobs, Search for Jobs, 
	Search for candidates, apply to jobs online, Set interviews, vacancies in Barbados, jobs, bajan jobs, real jobs, looking for work, good paying jobs, jobs in Barbados, 
	job vacancies, employment, employment agencies, looking for employment, employment in Barbados, recruitment in Barbados, local jobs, find a job in Barbados, 
	job seekers, recent jobs,caribbean jobs, sales jobs, it jobs, marketing jobs, legal jobs, caribbean careers, caribbean recruitment, the caribbean, caribbean salary survey">
	<meta property="og:url"                content="http://www.nytimes.com/2015/02/19/arts/international/when-great-minds-dont-think-alike.html" />
	<meta property="og:type"               content="article" />
	<meta property="fb:app_id" 			   content="120199111950926" />
	<meta property="og:title"              content="Job Opportunity" />
	<meta property="og:description"        content="How much does culture influence creative thinking?" />
	<meta property="og:image"              content="http://static01.nyt.com/images/2015/02/19/arts/international/19iht-btnumbers19A/19iht-btnumbers19A-facebookJumbo-v2.jpg" />
</head>
<body>	
	<div id="wrap">
	<div id="header">		
		
		<ul id="topnav">
			<li><img src="imgs/logo2.png" width="50" height="50" style="margin-top: 10px;"/> </li>
			<li><a>MSc. Project</a></li>		
			<!--li><a href="about.php">About us</a></li-->			
		</ul>
		
		<!--script src="menu.js"></script-->
		
		<div id="ctr" style="display: none;position: fixed; top: 40%; left: 5%; width: 100px; height: 50px; background-color: white; color: black">It's here</div>
		
		<div id="hamburger" onclick="navi()">&#9776;</div>
	</div>