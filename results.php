<?php 
	
	$active = "candidates"; 
	include 'den-head.php';

	ini_set('max_execution_time', '0');
?>
	
	
	<div class="content" style="height: 100vh">
		<h1 class="title">Results - <?php echo $_GET["c"]; ?> </h1>
		

		<button id="generate" onclick="javascript:window.print()" class="rectangle" style="right: 50px; position: absolute; top: 100px;">Print Report</button>

		<div>
			<?php

			if($_GET["algo"] == "CS"){
				echo '<p>
						The cards below show the top résumés using Cosine Similarity algorithm.
					</p>';
			}
			else{
				echo '<p>
						The cards below shows the predictions for each candidate using the KNN algorithm.
					</p>';
			}

				
			?>	
		</div>
		


		<!--div class="column candidates">
			<img class="avatar" src="imgs/man.png" />	
			
			<h3>Alan Emtage</h3>			
			<h3 class="score">Cosine Similarity (Score): 98%</h3>
			

			<div class="qual">
				<span>Education:</span>
				<ul>
					<li>Stanford University, MSc. Computer Science</li>
				</ul>

				<span>Experience: </span>
				<ul>
					<li>eBay, Software Engineer 10 yrs</li>
				</ul>
			</div>
			
			<a class="tool small info" onclick="learnmore('freshprince_kg@hotmail.com', 'Akela Jones')"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
				<span class="tooltip small info">View resume</span>
			</a>
		</div-->

		<?php 

			include 'autoloader.php';

			//get cid
			$cid = $_GET["cid"];
			
			$system = new User();
			
			
			$applicants = json_decode($system->predict($_GET["algo"], $cid), true);  //test CS using campaign 1
			
			//print_r($applicants);

			if($_GET["algo"] == "CS"){
				$size = count($applicants["name"]);
				$i = 1; //it starts from one in cosine similarity because we skip job description
				$images = array("man.png", "man2.png", "blackman.png", "manager.png", "woman.png", "girl.png");

				//echo 'SIZE: '.$size;
				
				while($i < $size+1){
					$img = rand(0, count($images)-1);
					echo '
					<div class="rec-3x1">
						<img class="avatar" src="imgs/'.$images[$img].'" />	
						
						<div class="bio">
							<h3>'. $applicants["name"][$i].'</h3>	
							<span>Similarity: '.round($applicants["cosine score"][$i], 3).'</span>				
						</div>
						
						<a class="tool small info" onclick=""> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
						</a>
					</div>';
					
					$i += 1;
				}
			}
			else{  //kNN
				$applicants = json_decode($system->predict($_GET["algo"], $cid), true);  //test KNN using campaign 1
			
				//print_r($applicants);

				
				$size = count($applicants["name"]);
				$i = 0; //it starts from one in cosine similarity because we skip job description
				$images = array("man.png", "man2.png", "blackman.png", "manager.png", "woman.png", "girl.png");

				
				while($i < $size){
					$img = rand(0, count($images)-1);
					echo '
					<div class="rec-3x1 '.str_replace(" ", "-", strtolower($applicants["class"][$i])).'">
						<img class="avatar" src="imgs/'.$images[$img].'" />	
						
						<div class="bio">
							<h3 style="color: #214b78">'. $applicants["name"][$i].'</h3>	
							<span style="color: #deeaff;">Prediction: '.$applicants["class"][$i].'</span>				
						</div>
						
						<a class="tool small info" onclick=""> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
							<span class="tooltip small info">View resume</span>
						</a>
					</div>';
					
					$i += 1;
				}
				
			}

			

			
		?>
			
		
		<!-- The Modal -->
		<div id="myModal" class="modal2">

			<!-- Modal content -->
			<div class="modal-content a" style="">
				<span id="jid"></span>
				<span class="close" onclick="modal.style.display='none';">&times;</span>
				<h3 id="j-name" style="text-align: center; color: #7b7a7a;"></h3>
				<object id="resume" data="" type="application/pdf" width="100%" style="height: 90%">
				  <p>It's probably taking a while to load. Click <a href="../users/resumes/<?php echo md5($_SESSION["email"]);?>.pdf">here</a> to download.</p>
				</object>
			</div>
			
		</div>
		
		<br/><br/>
		<!-- COMMENT FOR STATIC DATA-->
		<div id="alert1" class="alert success dropdown" style="display: none">
		  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
		  <i style="color: #a3e7a6;" class="fa fa-check" aria-hidden="true"></i><p></p>
		</div>
		
		<div id="alert2" class="alert error dropdown" style="display: none">
		  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
		  <i style="color: white; float: left;" class="fa fa-times" aria-hidden="true"></i> <p style="float: left; margin: 0 0 0 5px;" id="error-fields"></p>
		</div>
				
		<div id="alert1" class="alert success dropdown" style="display: none">
		  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
		  <i class="fa fa-check" aria-hidden="true"></i> <p> Interview set </p>
		</div>
	
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			
			// Get the modal
			var modal = document.getElementById('myModal');
			
			//event popups
			var events = document.getElementsByClassName("event");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks on the button, open the modal 
			function learnmore(jid, name) {
				modal.style.display = "block";
				var email = jid;
				document.getElementById('resume').data = "resumes/techcv.pdf?<?php echo time()?>";
				document.getElementById('j-name').innerHTML = name + "Resume";
			}			

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}
			
			function interview(id){
				popup = document.getElementById(id);
				popup.style.display = "block";
			}
			
			
			window.onclick = function(event) {
				if (event.target.className == "rec-large animated bounce" || event.target.className == "column"|| event.target.className == "qual"|| event.target.className == "avatar") {
					
					for (i = 0; i < events.length; i++) {
						events[i].style.display = "none";
					}
					
				}
			}
				
		  

		</script>
		
	</div>
		
<?php include 'toe.php';?>