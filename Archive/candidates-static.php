<?php 
	$active = "candidates"; 
	include 'den-head.php';
	
?>
	
	<div class="content" style="height: 100vh">
		<h1 class="title">All Candidates - <?php echo $_GET["c"]; ?> </h1>
		

		<button onclick="showModal()" class="rectangle" style="top: 90px; left: 30px;">Generate Data</button>
		<button class="rectangle" style="left: 180px; top: 90px; background-color: #0e2c4b;">Predict</button>


		<div class="rec-3x1">
			<img class="avatar" src="imgs/man.png" />	
			
			<div class="bio">
				<h3>Alan Emtage</h3>	
				<span>Bio:</span>				
			</div>
			
			<a class="tool small info" onclick=""> <i class="fa fa-graduation-cap" aria-hidden="true"></i>
				<span class="tooltip small info">View resume</span>
			</a>
		</div>
			
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
								
				
				<!--div id="add-container">
					<a class="add" id="add" style="margin-bottom:20px;  width: 35px; height: 35px; font-size: 24px;
						float: right;" onclick="addQuestion()">+</a>
				</div-->
				<div>
					<button class="big-button" onclick="generate(1)">Done</button>
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

							console.log("success");

							para = document.createElement("p");
							text = document.createTextNode("Candidates Generated.");
							para.appendChild(text);

							alert = document.getElementById("alert1");
							alert.appendChild(para);
							alert.display = "block";

							console.log(this.responseText);

							//close modal and refresh page
							modal.style.display = "none";
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