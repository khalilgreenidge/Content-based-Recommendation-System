<?php 
	$active = "candidates"; 
	include 'den-head.php';
	
?>
	
	<div class="content" style="">
		<h1 class="title">All Candidates - <?php echo $_GET["c"]; ?> </h1>
		
		<div style="margin-bottom: 50px;width: 100%; float: left;">
			<button onclick="showModal()" class="rectangle" style="top: 90px; left: 30px;">Generate Data</button>
			<button onclick="location.href='results.php?cid=<?php echo $_GET['cid'] . '&c='.$_GET['c'] ?>&algo=CS';" class="rectangle" style="left: 180px; top: 90px; background-color: #0e2c4b;">
				<img style="float: left; margin-right: 5px" src="imgs/neural.png" width="20" height="20" />Predict using Cosine Similarity</button>
			
			<?php

				if($_GET["cid"] != 1){
					echo '
					<button onclick="location.href=\'results.php?cid='.$_GET["cid"] . '&c='.$_GET['c'].'&algo=KNN" class="rectangle" style="left: 180px; top: 90px; background-color: #68717a">
					<img style="float: left; margin-right: 5px" src="imgs/neural.png" width="20" height="20" />KNN Unavailable</button>
					';
				}
				else{
					echo '	
					<button onclick="location.href=\'results.php?cid='. $_GET["cid"] . '&c='.$_GET['c'].'&algo=KNN\'" class="rectangle" style="left: 180px; top: 90px; background-color: #0e2c4b;">
					<img style="float: left; margin-right: 5px" src="imgs/neural.png" width="20" height="20" />Predict using KNN</button>
					';
				}
				
				
			?>
		</div>
		<br/>
		<br/>

		<?php 

			include 'autoloader.php';

			//get cid
			$cid = $_GET["cid"];
			
			$system = new User();
			$applicants = $system->getApplicants($cid);
			
			$size = count($applicants);
			$i = 0;
			$images = array("man.png", "man2.png", "blackman.png", "manager.png", "woman.png", "girl.png");


			while($i < $size){
				$img = rand(0, count($images)-1);
				echo '
				<div class="rec-3x1" style="width: 24.9vw">
					<img class="avatar" src="imgs/'.$images[$img].'" />	
					
					<div class="bio">
						<h3>'. $applicants[$i].'</h3>	
						<span>Bio:</span>				
					</div>
					
					<a class="tool small info" onclick=""> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
						<span class="tooltip small info">View resume</span>
					</a>
				</div>';
				
				$i += 1;
			}

		?>
			
		<!--div class="rec-3x1">
			<img class="avatar" src="imgs/man2.png" />
			
			<div class="bio">
				<h3>Elon Musk</h3>
				<span>Bio:</span>							
			</div>	
			<a class="tool small info" onclick="learnmore()"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
				<span class="tooltip small info">View resume</span>
			</a>
		</div>
			
		<div class="rec-3x1">
			<img class="avatar" src="imgs/man3.png" />			
			
			<div class="bio">
				<h3>Steve Jobs</h3>
				<span>Bio:</span>
			</div>	

			<a class="tool small info" onclick="learnmore()"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
				<span class="tooltip small info">View resume</span>
			</a>	
		</div>
			
		<div class="rec-3x1">
			<img class="avatar" src="imgs/woman.png" />

			<div class="bio">
				<h3>Erykah Badu</h3>
				<span>Bio:</span>					
			</div>

			<a class="tool small info" onclick="learnmore()"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
				<span class="tooltip small info">View resume</span>
			</a>	
		</div-->
		
		<!-- The Modal -->
		<!-- The Modal -->
		<div id="myModal" class="modal2">

			<!-- Modal content -->
			<div class="modal-content test" style="width: 50%;" id="test">
				<span class="close" onclick="modal.style.display='none';">&times;</span>
				
				<h1>Generate Test Samples</h1>
				<div>
					How many applicants would you like? Min of 50.<input type="number" name="numOfCandidates" id="samplesize" max="800"/>
				</div>
					
				<div>
					<button class="big-button" onclick="generate(<?php echo $_GET['cid'];?>)">Done</button>
				</div>
			</div>
				
			<script>
				// Get the modal
				var modal = document.getElementById('myModal');

				// Get the <span> element that closes the modal
				var span = document.getElementsByClassName("close")[0];
				
				function showModal(){
					document.getElementById('myModal').style.display = "block";
				}
				
				// When the user clicks anywhere outside of the modal, close it
				window.onclick = function(event) {
					if (event.target == modal) {
						modal.style.display = "none";
					}
				}

				function generate(cid){

					size = document.getElementById("samplesize").value;

					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {

						
							console.log("response: " + this.responseText);

							//close modal and refresh page
							modal.style.display = "none";

							
							if(this.responseText)
								location.reload();
							

						}
					};
					xmlhttp.open("GET","candidatesController.php?cid="+cid+"&size="+size,true);
					xmlhttp.send();
					
				}

			</script>
			
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
	
	</div>
		
<?php include 'toe.php';?>