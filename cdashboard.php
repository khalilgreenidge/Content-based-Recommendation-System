<?php 
	$active = "dashboard"; 
	include 'den-head.php';
	
?>
	<script>
		function executePython(){

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {

					console.log(this.responseText);

					para = document.createElement("p");
					text = document.createTextNode(this.responseText);
					para.appendChild(text);

					alert = document.getElementById("alert1");
					alert.appendChild(para);
					alert.display = "block";

					console.log(this.responseText);
				}
			};
			xmlhttp.open("GET","executepython.php",true);
			xmlhttp.send();


		}

	</script>
	
	<div class="content">
		<h1>Dashboard </h1>
		
		<!-- Print Modal -->
		
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
		
		<?php 

			include 'autoloader.php';

			//get companyid
			$companyid = $_SESSION["companyid"];
			
			$system = new User();
			$campaigns = $system->getCampaignsLimited($companyid);
			
			$size = count($campaigns);
			$i = 0;

			//print_r($campaigns);
			
			while($i < $size){

				$applicants = $system->getApplicants($campaigns[$i]["id"]);
				$numOfApplicants = count($applicants);

				//echo "Testing campaign ids: ".$campaigns[$i]["id"];
				
				echo '
				<div class="rec-large animated bounce ">
					<h2><a href="candidates.php?cid='.$campaigns[$i]["id"].'&c='.$campaigns[$i]["title"].'">'.$campaigns[$i]["title"].'</a></h2>								
					<div id="rank"><img style="float: left; margin-right: 5px" src="imgs/trophy.png" width="20" height="20" /><a href="candidates.php?cid='.$campaigns[$i]["id"].'&c='.$campaigns[$i]["title"].'">  View All Candidates</a></div>
				';

				$j = 0; //reset j each campaign
				$images = array("man.png", "man2.png", "blackman.png", "manager.png", "woman.png", "girl.png");

				if($numOfApplicants > 0){
					while($j < $numOfApplicants){
						$img = rand(0,count($images) - 1);
						echo '
							<div class="rec-3x1">
								<img class="avatar" src="imgs/'.$images[$img].'" />	
								
								<div class="bio">
									<h3>'. $applicants[$j].'</h3>	
									<span>Bio:</span>				
								</div>					
								<a class="tool small info" onclick=""> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
									<span class="tooltip small info">View resume</span>
								</a>
							</div>
						';

						$j+=1; //increment counter
					}
				}
				else
					echo '<p>No applicants have applied as yet. Click "View candidates" then generate some</p>';

				echo'
				</div>
				';


				/*echo '
				<div class="rec-3x1">
					<img class="avatar" src="imgs/man.png" />	
					
					<div class="bio">
						<h3>'. $campaigns[$i].'</h3>	
						<span>Bio:</span>				
					</div>					
					<a class="tool small info" onclick=""> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
						<span class="tooltip small info">View resume</span>
					</a>
				</div>';
				*/
				
				$i += 1;
			}

		?>


		
		<!--div class="rec-large animated bounce ">
			<h2><a href="candidates.php?cid=1&c=I.T. Manager">I.T. Manager</a></h2>
						
			<div id="rank"><img style="float: left; margin-right: 5px" src="imgs/trophy.png" width="20" height="20" /><a href="candidates.php?cid=1&c=I.T Manager">  View All Candidates</a></div>
			
			
			<div class="column">
				<img class="avatar" src="imgs/man.png" />
				<a class="tool small bookmark " onclick="this.style.color='#ffd600'"><i class="fa fa-bookmark" aria-hidden="true"></i>
					<span class="tooltip small bookmark">Click to bookmark</span>
				</a>
				<a class="tool small reject" onclick="learnmore('freshprince_kg@hotmail.com', 'Akela Jones')"> <i class="fa fa-times" aria-hidden="true"></i>
					<span class="tooltip small reject">Reject</span>
				</a>
				<h3>Alan Emtage</h3>
				
				<div class="qual">
					<span>Education:</span>
					<ul>
						<li>Stanford University</li>
					</ul>

					<span>Experience:</span>
					<ul>
						<li>eBay, Software Engineer 10 yrs</li>
					</ul>
				</div>
				
				<a class="tool small info" onclick="learnmore('freshprince_kg@hotmail.com', 'Akela Jones')"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
					<span class="tooltip small info">View resume</span>
				</a>
			</div>
			
			<div class="column">
				<img class="avatar" src="imgs/man2.png" />
				<a class="tool small bookmark " onclick="this.style.color='#ffd600'"><i class="fa fa-bookmark" aria-hidden="true"></i>
					<span class="tooltip small bookmark">Click to bookmark</span>
				</a>
				<a class="tool small top-right" onclick="interview(2,'khalilgreenidge16@gmail.com')"><i class="fa fa-calendar" aria-hidden="true"></i>
					<span class="tooltip small calendar">Set interview</span>
				</a>
				
				<h3>Elon Musk</h3>
				
				<div class="qual">
					Education:
					<ul>
						<li>University of Pennsylvania</li>
						<li>Queen's University</li>
					</ul>
				</div>	
				<a class="tool small info" onclick="learnmore('freshprince_kg@hotmail.com', 'Akela Jones')"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
					<span class="tooltip small info">View resume</span>
				</a>
			</div>
			
			<div class="column">
				<img class="avatar" src="imgs/man3.png" />
				<a class="bookmark" onclick="this.style.color='#ffd600'"><i class="fa fa-bookmark" aria-hidden="true"></i></a>
				<a class="tool small top-right" onclick="interview(3,'khalilgreenidge16@gmail.com')"><i class="fa fa-calendar" aria-hidden="true"></i>
					<span class="tooltip small calendar">Set interview</span>				
				</a>
				<h3>Steve Jobs</h3>
				<div class="qual">
					Education:
					<ul>
						<li>Reed College</li>
					</ul>
				</div>	
				<a class="tool small info" onclick="learnmore('freshprince_kg@hotmail.com', 'Akela Jones')"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
					<span class="tooltip small info">View resume</span>
				</a>	
			</div>
			
			<div class="column">
				<img class="avatar" src="imgs/woman.png" />
				<a class="bookmark" onclick="this.style.color='#ffd600'"><i class="fa fa-bookmark" aria-hidden="true"></i></a>
				
				<h3>Charlette Brown</h3>
				<div class="qual">
					Education:
					<ul>
						<li>UWI</li>
						<li>BCC</li>
					</ul>
				</div>
				<a class="tool small info" onclick="learnmore('837ec5754f503cfaaee0929fd48974e7', 'Akela Jones')"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
					<span class="tooltip small info">View resume</span>
				</a>	
			</div>

		</div-->
		<div id="alert1" class="alert success dropdown" style="display: none">
		  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
		  <i class="fa fa-check" aria-hidden="true"></i> 
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
				document.getElementById('resume').data = "users/resumes/" + email + ".pdf?<?php echo time()?>";
				document.getElementById('j-name').innerHTML = name + " - Resume";
			}			

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}
			
						
			window.onclick = function(event) {
				if (event.target.className == "rec-large animated bounce" || event.target.className == "column"|| event.target.className == "qual"|| event.target.className == "avatar") {
					
					for (i = 0; i < events.length; i++) {
						events[i].style.display = "none";
					}
					
				}
			}
		
		  google.charts.load('current', {'packages':['corechart']});
		  google.charts.setOnLoadCallback(drawChart);

		  function drawChart() {
			var data = google.visualization.arrayToDataTable([
			
				<?php echo( implode(",", $campaigns) ); ?>
				/*['Campaign', 'Views', 'Impressions'],
				['IT Manager',  1000,      400],
				['HR Manager',  1170,      460],
				['Financial Controller',  660,       1120],
				['Marketing Associate',  1030,      540]*/
			]);

			var options = {
				title: 'Campaign Performance',
				curveType: 'function',
				legend: { position: 'bottom'},
				animation: {
					startup: true,
					duration: 3000,
					easing: 'out', 
				},
				hAxis: {
					title: 'Time'
				},
				vAxis: {
					title: 'hits'
				}
			};

			var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

			chart.draw(data, options);
		  }
		</script>
		
	</div>
		
<?php include 'toe.php';?>