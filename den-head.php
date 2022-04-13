<?php session_start();
	
	date_default_timezone_set('America/Barbados');	
	/*
		LIST OF SESSION VARIABLES:
		
		- admin (admin for a company: yes, or no?)
		- companyid
		- company
		- email
		- type (user type such as recruiter, jobseeker, agent, placement_officer)
		- name
		- gender
		
	*/
	$pic = "";
	
	//CHECK IF ALREADY LOGGED IN
	if(empty($_SESSION["login"])){
		header("Location: signin.php");
	}	
	
	//CHECK IF RECRUITER
	if($_SESSION["type"] !== "recruiter"){
		header("Location: signout.php?back=".basename($_SERVER['PHP_SELF']));
	}
	
	//REDIRECT
	if(isset($_GET["back"]))
		header("Location: ".$_GET["back"]);
	
	
	
	if(isset($_SESSION["email"])){

		//check for gender
		if($_SESSION["gender"] == "male")
			$pic = "imgs/man.png?".time();
		else if($_SESSION["gender"] == "female")
			$pic = "imgs/girl.png?".time();
	
	} 
	
	$total = 0;
	$cartText = "";
	$tableText = "";
	
	
?>

<!DOCTYPE html>
<head>
	<title>MSc. Project | Welcome to the dashboard!</title>
	<link rel="stylesheet" type="text/css" href="style2.css" >
	<link rel="shortcut icon" href="imgs/logo2.png" >
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>
<body>
<div id="wrap">
	<div class="head">
		<ul class="menu">
			<li class="menu-logo"><img src="imgs/logo2.png" width="80px" height="50px" style=""/><p style="float: right; font-size: 17px; margin: 0;">MSc. Project</p></li>
			
			<span>
				<li onclick="userdropdown()" class="userdropdown" style="overflow: hidden;"><a href="#"><img src="<?php echo $pic; ?>" class="user-thumb" /><span><?php if(isset($_SESSION["name"])) echo $_SESSION["name"]; else echo $_COOKIE["name"] ?></span></a>
				<ul id="user-dropdown" style="display: none;">
					<!-- User image -->
				  <li class="user-header">
					<img src="<?php echo $pic;?>" alt="User Image" />
					<div>	
						<span><?php if(isset($_SESSION["name"])) echo $_SESSION["name"]; //else echo $_COOKIE["name"] ?></span>
						<span><?php if(isset($_SESSION["company"])) echo $_SESSION["company"]; //else echo $_COOKIE["company"] ?></span>
					</div>
				 </li>
				  
				  <!-- Menu Body -->
				  <li class="user-body company">
					<ul>
						<li><a href="stats.php"><i class="fa fa-line-chart" aria-hidden="true"></i></a></li>
						<li><a href="campaign.php"><i class="fa fa-bullhorn" aria-hidden="true"></i></a></li>
						<li><a href="candidates.php"><i class="fa fa-briefcase" aria-hidden="true"></i></a></li>
					</ul>					
				  </li>
				  <!-- Menu Footer-->
					<li class="user-footer">
						<button style="float: left; cursor: pointer;" onclick="location.href='settings-emp.php'">Profile</button>
						<button style="float: right; cursor: pointer;" onclick="location.href='signout.php'">Sign out</button>						
					</li>
				</ul>
				</li>
				<!--button class="icons" style="width: 50px"><i class="fa fa-envelope" aria-hidden="true"></i><span>5</span></button-->
				<button class="icons tool" style="width: 50px"><i class="fa fa-bell" aria-hidden="true"></i><span class="counter">5</span>
					<span class="tooltip small bottom" style="left: -35px;">Notifications</span>
				</button>
								
								
				<button onclick="" class="icons tool" style="width: 50px"><i style="font-size: 25px;" class="fa fa-cog" aria-hidden="true"></i>
					<span class="tooltip small bottom">Settings</span>
				</button>
			</span>
		</ul>
	</div>

	<div class="nav company">
		<p>
			<img src="imgs/google-logo.png" />
			<span>
			<?php 
				if(isset($_SESSION["company"])) 
					echo '<br/>'.$_SESSION["company"];
				 //else echo $_COOKIE["company"];  ?></span></p>
		<button class="accordion"><a href="cdashboard.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></button>
		
		<!--RESTRICT STORE JUST FOR ADMIN-->
				
		<button class="accordion"><a><i class="fa fa-bullhorn" aria-hidden="true"></i>Campaign <span></span></a></button>
		<div class="panel">
			<ul class="panel">
				<li><a href="newcampaign.php"><i class="fa fa-plus" aria-hidden="true"></i> New Campaign</a></li>
			</ul>
		</div>
				
	</div>
	
	<script>
		var user,cart = 0;
		function userdropdown(){
			if(user){
				document.getElementById('user-dropdown').style.display = "none";
				user = 0;
			}
			else{
				document.getElementById('user-dropdown').style.display = "block";
				user = 1;
			}
		}
		
		function cartDropdown(){
			
			if(document.getElementById('cart-dropdown') == null)
				return;
			
			if(cart){
				
				document.getElementById('cart-dropdown').style.display = "none";
				cart = 0;
			}
			else{
				document.getElementById('cart-dropdown').style.display = "block";
				cart = 1;
			}
		}
	
		var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
			acc[i].onclick = function(){
				this.classList.toggle("active");

				/* Toggle between hiding and showing the active panel */
				var panel = this.nextElementSibling;
				if (panel.style.maxHeight){
				  panel.style.maxHeight = null;
				} else {
				  panel.style.maxHeight = panel.scrollHeight + "px";
				} 
			}
		}
		
		
		var act = "<?php echo $active; ?>";
		
		var item = document.getElementsByClassName("nav")[0].getElementsByTagName("button");
		
		switch(act){
			case "dashboard":
				item[0].style.borderLeft = "solid #ff9800 5px";
				item[0].getElementsByTagName("i")[0].style.color = "#ff9800";
				break;
								
			case "campaigns":
				item[1].style.borderLeft = "solid #ff9800 5px";
				item[1].getElementsByTagName("i")[0].style.color = "#ff9800";
				break;
				
			case "candidates":
				item[2].style.borderLeft = "solid #ff9800 5px";
				item[2].getElementsByTagName("i")[0].style.color = "#ff9800";
				break;
				
			case "statistics":
				item[3].style.borderLeft = "solid #ff9800 5px";
				item[3].getElementsByTagName("i")[0].style.color = "#ff9800";
				break;
							
			
		}
		
	</script>
	