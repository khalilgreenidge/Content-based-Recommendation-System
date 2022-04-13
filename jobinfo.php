	<?php 
		$cid = $var = "";
	
		if(!isset($_GET['cid'])){
			header("Location: jobs.php");
		}
		else{
			$var = test_input($_GET['cid']);
			$cid = $var;
		}
		include 'header.php';
		
	
	?>
	<script>
	  window.fbAsyncInit = function() {
		FB.init({
		  appId      : '120199111950926',
		  xfbml      : true,
		  version    : 'v2.10'
		});
		FB.AppEvents.logPageView();
	  };

	  (function(d, s, id){
		 var js, fjs = d.getElementsByTagName(s)[0];
		 if (d.getElementById(id)) {return;}
		 js = d.createElement(s); js.id = id;
		 js.src = "//connect.facebook.net/en_US/sdk.js";
		 fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>
	<div class="content" id="job-info">
		<div class="jobinfo-container">
			<?php
				if(isset($_GET["r"])){
					if($_GET["r"] == "s"){
						echo '<div id="alert1" class="alert success dropdown">
								  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
								  <i class="fa fa-check" aria-hidden="true"></i> Application sent! 
							  </div>';
					}
					
					else if($_GET["r"] == "r"){
						echo '<div id="alert1" class="alert error dropdown">
								  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
								  <i class="fa fa-times" aria-hidden="true"></i> Try uploading your resume again. 
							  </div>';
					}
					else if($_GET["r"] == "l"){
						echo '<div id="alert1" class="alert error dropdown">
								  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
								  <i class="fa fa-times" aria-hidden="true"></i>  Try uploading your cover letter again. 
							  </div>';
					}
					else if($_GET["r"] == "a"){
						echo '<div id="alert1" class="alert error dropdown">
								  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
								  <i class="fa fa-times" aria-hidden="true"></i> You\'ve applied already. 
							  </div>';
					}
				}
			
			
				include 'connect.php';
				
				
					
				
				
				function test_input($data) {
				  $data = trim($data);
				  $data = stripslashes($data);
				  $data = htmlspecialchars($data);
				  return $data;
				}
				
				$sql = "SELECT * FROM campaigns WHERE id='$var'";
				
				
				$q = mysqli_query($con, $sql);

				if(!$con ||!$q ){
					die('Error: '.mysqli_error($con));
					echo 'something went wrong';
				}
				else{
					while($row = mysqli_fetch_array($q)){
						$companyid = $row["companyid"];
						
						$sql2 = "SELECT name FROM companies WHERE id=".$row['companyid'];
						$q2 = mysqli_query($con, $sql2) or die('Error: '.mysqli_error($con));
						$row2 = mysqli_fetch_array($q2);
						
						if(file_exists("../companies/logos/".$row["companyid"].".png")){ 
							$logo = "../companies/logos/".$row['companyid'].".png";
						}
						else if(file_exists("../companies/logos/".$row['companyid'].".jpg")){ 
							$logo = "../companies/logos/".$row['companyid'].".jpg";
						}						
						else if(file_exists("../companies/logos/".$row['companyid'].".jpeg")){ 
							$logo = "../companies/logos/".$row['companyid'].".jpeg";
						}
						else{
							$logo = "../imgs/profile2.png";
						}
						
						echo "
						<img src='".$logo."' style='width: 100px; height: 100px; margin: 0 auto; display: block;' /> 
						<div id='job-title'>
							".$row['title']."
						</div>
						<div id='job-company'>
							<span class='location'>".$row['location']."</span>
						</div>
						<p id='job-overview'>
							<span style='font-weight: bold;'>Overview:</span> <br/><br/>"
								.$row['overview']."
						</p>
						<p>
							<span style='font-weight: bold;'>Employment Type:</span> ".$row['emp_type']."
						</p>
						<br/>
						<p id='job-salary'>
							<span style='font-weight: bold;'>Salary:</span> <span class='align-right'>"; 
							if($row['salary'] == "hidden")
								echo "This salary has been hidden.";
							else
								echo $row['salary'];
							echo "</span>
						</p>
						<br/>
						<p id='duties'>
							<span style='font-weight: bold;'>Duties:</span>
							<ul>
							".$row['duties']."
							</ul>
						</p>
						<br/>
						<p id='job-requirements'>
							<span style='font-weight: bold;'>Requirements:</span>
							<ul>
							".$row['requirements']."
							</ul>
						</p><br/>";
						
						$time1 = $row["start_date"];
						$time2 = time();
						$days = ($time2 - $time1)/(24*3600);
						
						echo "Posted ".number_format($days)." days ago";
						
					}
					
				}
				
				
				mysqli_close($con);
				
			?>
			
			<br/>
			<br/>
			<?php
				if(!isset($_SESSION["type"]) || $_SESSION["type"] != "jobseeker"){
					echo '<a id="applybutton" class="myBtn tool">Apply			
							<span class="tooltip" id="tooltip">Must be logged in as a jobseeker</span>
						</a>';
				}
				
				//YOU ARE A JOBSEEKER ==> CHECK IF YOU ALREADY APPLIED || CHECK FOR RESUME ==> click apply
				
				else{
					$jid = $_SESSION["email"];
					
					include "connect.php";
					
					//CHECK IF ALREADY APPLIED
					$q1 = mysqli_query($con, "SELECT time FROM applicants WHERE campaign_id=$cid AND jobseeker='$jid' ");
						
					if(!$con || !$q1){
						die('Error: nknkj'.mysqli_error($con));
					}			
					else{
						if(mysqli_num_rows($q1) > 0){
							echo '<a  id="applybutton" class="myBtn tool">Apply			
									<span class="tooltip" id="tooltip">You\'ve already applied.</span>
								</a>';
						}
						else{
							mysqli_close($con);
							
							//CHECK FOR RESUME
							if (!file_exists('../users/resumes/'.md5($jid).'.pdf')) {
								//its not there
								echo '<a class="myBtn tool">Apply			
										<span class="tooltip" id="tooltip">You forgot to add a resume to your profile.</span>
									</a>';
							}
							else{
								//its there => check application requirements
								
								$tag = "checkapplicationrequirements";
								$jobinfo_php = "yes";
								
								include_once 'functions.php';
								
								if($bool[0] == 1 || $bool[1] == 1 || $bool[2] == 1 ){
									
									echo '<a id="applybutton" onclick="applymodal('.$cid.','. $bool[0] .','. $bool[1] .','. $bool[2] .')" class="myBtn tool">Apply			
										<span class="tooltip" id="tooltip">Click to apply</span>
									</a>';	
								}
								else{
									//IF they are requirements show modal ELSE just apply
									echo '<a id="applybutton" onclick="justapply('.$cid.')" class="myBtn tool">Apply			
											<span class="tooltip" id="tooltip">Click to apply</span>
										</a>';
								}
							}
							
						}
					}
					
					
					
				}
											
				
			?>
			
		</div>
		
		<ul id="share">
			Share this job <img src="../imgs/paper.png" style="top: 5px;height: 30px;width: 30px;position: relative"/> <br/>
			<li id="fb" class="tool"><a><i class="fa fa-facebook" aria-hidden="true"></i></a><span class="tooltip share">Facebook</span></li>
			<li id="twit" class="tool"><a><i class="fa fa-twitter" aria-hidden="true"></i></a><span class="tooltip share">Twitter</span></li>
			<li id="ig" class="tool"><a><i class="fa fa-google-plus" aria-hidden="true"></i></a><span class="tooltip share">Google +</span></li>
			<li id="whatsapp" class="tool"><a href="whatsapp://send?"><i class="fa fa-whatsapp" aria-hidden="true"></i></a><span class="tooltip share">Whatsapp</span></li>
			<li id="mail" class="tool"><a href="mail://"><i class="fa fa-envelope" aria-hidden="true"></i></a><span class="tooltip share">Email</span></li>
		</ul>
		
		<div id="alert1" class="alert success" style="display: none">
		  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
		  Success! Application sent.
		</div>
		
		<!-- The Modal -->
		<div id="myModal" class="modal2">

			<!-- Modal content -->
			<div id="modal-content" class="modal-content apply" style="/*width: 30%; */ width: 800px; overflow:hidden;">
				<span class="close" onclick="modal.style.display='none';">&times;</span>
				<h3 id="name" class="jobseeker" style="text-align: center; color: #05096f;">Application</h3>
				<br/>
				
				<form class="fancy-form" name="application" style="width: 100%;float: left;" autocomplete="off" method="post" action="functions.php?tag=apply&cid=<?php echo $var."&pic=".$pic; ?>" enctype="multipart/form-data" onsubmit="return (checkFile('l') && checkFile('r') && checkVideo() );" >
				
					<div id="app-top" style="width: 100%; min-width: 400px; ">
					
					<?php
						// MAKE CONNECTION
						include 'connect.php';
						
					    //GET JOBSEEKER EMAIL
						$je = $_SESSION["email"];
						
						//CHECK IF SCREEN TEST, VIDEO AND LETTER IS REQUIRED
						
						$sql = "SELECT id,screen_test, letter, video FROM campaigns WHERE id =$cid ";
						$q = mysqli_query($con, $sql);
						
						//CHECK FOR ERRORS
						if(!$con ||!$q ){
							die('Error: '.mysqli_error($con));
							echo 'something went wrong';
						}
						else{
							
							while($row = mysqli_fetch_array($q)){
								
								//echo "Screen test: ".$row["screen_test"];
								
								//CHECK SCREEN TEST
								if($row["screen_test"] != ""){
									$screen = "yes";
									
									$sql2 = "SELECT * FROM screen_tests WHERE campaign=".$row['id'];
									$q2 = mysqli_query($con, $sql2) or die('Error: '.mysqli_error($con));
									$row2 = mysqli_fetch_array($q2);
									
									echo '<h3 style="font-weight: 300;color: #05097c">Screen Test</h3>';
									
									echo '<input type="hidden" name="screentest" value="yes" />';
									
									$i = 1;	
									
									while($i<11){
										
										if($row2["q".$i] == "")
											break;
										
										echo '<div class="question">
												<p>'.$row2["q".$i].'</p>
												<input type="text" name="a'.$i.'" id="a'.$i.'" />
											</div>';
										$i++;	
									}
											
									
								}
								
								//IF VIDEO IS REQUIRED
								//echo "Video test: ".$row["video"];
								if($row["video"] != ""){
									$video = "yes";
									
									echo '
									<div id="webcam" style="float:left; width: 100%; min-width: 319px;">
										<h4>Video Response</h4>

										<img id="cam" onclick="showMenu()" src="imgs/camera2.png" style="width: 250px; height: 250px; border-radius: 50%;" />
							
										<label class="dropzone" style="overflow: hidden; position: relative;" id="dropzone">Select/drag a prerecorded video here.<input required type="file" id="video" name="video" accept=".mp4" style="    width: 300px;
											height: 300px;
											position: absolute;
											display: block;
											top: 0;" /></label>
											
									</div> ';
								}
								
								
								//echo "Letter: ".$row["letter"]." Cid: ".$cid;
							
								if($row["letter"] != "") {
									$letter = "yes";
								
									echo '
									<div id="letter" style="margin-top: 20px;">
										<label class="upload"><i class="fa fa-upload"></i>  Select Cover Letter
										<input accept=".pdf" required onchange="checkFile(\'l\')" id="l" type="file" name="letter" class="file" /></label>			
									</div>  ';
								}
								
													
								mysqli_close($con);
								
							}
															
						}
						
					?>
					</div>				
					<div id="app-bottom" style="float:left; width: 100%;">
												
						<div>
							<div id="msg2" style="float: none;" class="bubble"></div>
						</div>
						<br/>
						
						<div>
							<input type="submit" style="margin: 30px auto; display: block;" class="form-button" value="Submit" />
						</div>
					</div>
					
				</form>
				
			</div>
		</div>
		<script src="functions.js"></script>
		<script>
			//impression(<?php echo $cid;?>);	
			
			navigator.getUserMedia  = navigator.getUserMedia ||
                          navigator.webkitGetUserMedia ||
                          navigator.mozGetUserMedia ||
                          navigator.msGetUserMedia;
				
			var mediaRecorder;
			var recordedBlobs;
			var sourceBuffer;
			message = document.getElementById('msg2');
			
			// Get the modal
			var modal = document.getElementById('myModal');
			var modalcontent = document.getElementById('modal-content');
			
			/** 	UNCOMMENT THIS WHEN FIXING THE APPLY BUTTON
				applymodal(2,1,1,0);
			**/
			var theVideo;

			var recordButton = document.getElementById('record');
			
			var playButton = document.getElementById('play');	
			
			function webcam(){
				document.getElementById('cam').style.display = "none";
				document.getElementById('video-menu').style.display = "none";
				
				document.getElementById('video-response').innerHTML = 
				'<input name="video" id="videoFile" value="" style="opacity: 0;" type="text"><video name="video" required id="video" autoplay style="width: 100%; height: 239px;"></video><button type="button" class="controls top" id="record" onclick="toggleRecording()"><i class="fa fa-video-camera" aria-hidden="true"></i></button><button type="button" class="controls bottom" id="play" onclick="playit()" ><i class="fa fa-play" aria-hidden="true"></i></button>';
				
				theVideo = document.getElementById('video');
				
				navigator.mediaDevices.getUserMedia(constraints).
				then(handleSuccess).catch(handleError);
				
				var mediaSource = new MediaSource();
				mediaSource.addEventListener('sourceopen', handleSourceOpen, false);
			}
				
			function videoSelect(){
				
				var vid = document.getElementById('video-response');
				

				if(vid.style.display === "block"){
					
					document.getElementById('cam').style.display = "none";
					document.getElementById('video-menu').style.display = "none";
					
					vid.innerHTML = 
						'<label class="dropzone" style="overflow: hidden; position: relative;" id="dropzone">Select/drag a prerecorded video here.<input required type="file" id="video" name="video" accept=".mp4" style="    width: 300px;height: 300px;position: absolute;display: block;top: 0;" /></label>';
			
					(function(){
						var dropzone = document.getElementById('dropzone');
						
						var upload = function(files){
							
							if(files.length > 1){
								message.style.display = "block";
								message.innerHTML = "Only one video is allowed.";
								return false;
							}
							else{
								var form = document.forms.namedItem("application");
								form.addEventListener('submit', function(ev) {

								  var oOutput = document.querySelector("div"),
									  oData = new FormData(form);

								  oData.append("video", files[0]);

								  if (window.XMLHttpRequest){
										// code for IE7+, Firefox, Chrome, Opera, Safari
									  xmlhttp=new XMLHttpRequest();
								  }
								  else{
										// code for IE6, IE5
									  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
								  }
								
								  xmlhttp.onreadystatechange=function(){
									if (xmlhttp.readyState==4 && xmlhttp.status==200){
										oOutput.innerHTML = xmlhttp.responseText;
									} else {
										oOutput.innerHTML = "Error " +xmlhttp.status + " occurred when trying to upload your file.<br \/>";
									}
								  };
								  xmlhttp.open("POST", "functions.php?tag=apply&cid=1", true);
								  

								 xmlhttp.send(oData);
								  ev.preventDefault();
								}, false);
							}
								
							console.log(files);
						}
						
						dropzone.ondrop = function(e){
							e.preventDefault();
							this.className = "dropzone";
							upload(e.dataTransfer.files);
						}
						
						dropzone.ondragover = function(){
							this.className = 'dropzone dragover';
							return false;
						}
						
						dropzone.ondragleave = function(){
							this.className = "dropzone";
							return false;
						}
						
					}());
			
				}
				
			}

			/* if (!hasGetUserMedia()){}
				alert('getUserMedia() is not supported in your browser');
			} */
			
			/* globals MediaRecorder */
			
			'use strict';

			var constraints = {
			  audio: true,
			  video: true
			};
						
			function handleSuccess(stream) {
				console.log('getUserMedia() got stream: ', stream);
				window.stream = stream;
				if (window.URL) {
					theVideo.src = window.URL.createObjectURL(stream);
				} 
				else {
					theVideo.src = stream;
				}
			}

			function handleError(error) {
			  console.log('navigator.getUserMedia error: ', error);
			}
						
			var state = 0;
			function toggleRecording() {
				if (state === 0) {
					startRecording();
					
					navigator.mediaDevices.getUserMedia(constraints).
					then(handleSuccess).catch(handleError);
					recordButton.className = "controls top recording";
					state = 1;
				}
				else {
					stopRecording();
					recordButton.className = "controls top";
					state = 0;
				}
			}
			
			function handleSourceOpen(event) {
				console.log('MediaSource opened');
				sourceBuffer = mediaSource.addSourceBuffer('video/webm');
				console.log('Source buffer: ', sourceBuffer);
			}
			
			if(theVideo)
			theVideo.addEventListener('error', function(ev) {
			  console.error('MediaRecording.recordedMedia.error()');
			  alert('Your browser can not play\n\n' + recordedVideo.src
				+ '\n\n media clip. event: ' + JSON.stringify(ev));
			}, true);

			function handleDataAvailable(event) {
			  if (event.data && event.data.size > 0) {
				recordedBlobs.push(event.data);
			  }
			}
			
			function handleStop(event) {
			  console.log('Recorder stopped: ', event);
			}
			
			function startRecording() {
				recordedBlobs = [];
				theVideo.muted = true;
				
				var options = {mimeType: 'video/webm;codecs=vp9'};
				
				if (!MediaRecorder.isTypeSupported(options.mimeType)) {
					console.log(options.mimeType + ' is not Supported');
					options = {mimeType: 'video/webm;codecs=vp8'};
					if (!MediaRecorder.isTypeSupported(options.mimeType)) {
					  console.log(options.mimeType + ' is not Supported');
					  options = {mimeType: 'video/webm'};
					  if (!MediaRecorder.isTypeSupported(options.mimeType)) {
						console.log(options.mimeType + ' is not Supported');
						options = {mimeType: ''};
					  }
					}
				}
			
				try {
					mediaRecorder = new MediaRecorder(window.stream, options);
				}
				catch (e) {
					console.error('Exception while creating MediaRecorder: ' + e);
					alert('Exception while creating MediaRecorder: '
					  + e + '. mimeType: ' + options.mimeType);
					return;
				}
			
				console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
				
				recordButton.innerHTML = '<i class="fa fa-stop" aria-hidden="true"></i>';
				playButton.style.display = "none";
				//uploadButton.style.display = "none";
				
				mediaRecorder.onstop = handleStop;
				mediaRecorder.ondataavailable = handleDataAvailable;
				mediaRecorder.start(10); // collect 10ms of data
				console.log('MediaRecorder started', mediaRecorder);
			}
			
			function playit() {
			  var superBuffer = new Blob(recordedBlobs, {type: 'video/webm'});
			  theVideo.src = window.URL.createObjectURL(superBuffer);
			  theVideo.autoplay = true;
			  
			  theVideo.muted = false;    	
			  theVideo.load();
			}

			function stopRecording() {
				mediaRecorder.stop();
				console.log('Recorded Blobs: ', recordedBlobs);
				recordButton.innerHTML = '<i class="fa fa-video-camera" aria-hidden="true"></i>';
				playButton.style.display = "initial";
				//uploadButton.style.display = "initial";
				
				var blob = new Blob(recordedBlobs, {type: 'video/webm'});
				var url = window.URL.createObjectURL(blob);				
				
				//add input
				document.getElementById("videoFile").text = url; 
				
				download();
			}
			
			function download() {
				var blob = new Blob(recordedBlobs, {type: 'video/webm'});
				var url = window.URL.createObjectURL(blob);				
				
				var form = document.forms.namedItem("application");
				form.addEventListener('submit', function(ev) {

				  var oOutput = document.querySelector("div"),
					  oData = new FormData(form);

				  if(blob === null)
					  return false;
				  oData.append("video", blob, "test.webm");

				  if (window.XMLHttpRequest){
						// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
				  }
				  else{
						// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				
				  xmlhttp.onreadystatechange=function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
						oOutput.innerHTML = xmlhttp.responseText;
					} else {
						oOutput.innerHTML = "Error " +xmlhttp.status + " occurred when trying to upload your file.<br \/>";
					}
				  };
				  xmlhttp.open("POST", "functions.php?tag=apply&cid=1", true);
				  

				 xmlhttp.send(oData);
				  ev.preventDefault();
				}, false);
				
			}
			/*
			var link = 'https://jobhunters.co'; //window.location.href;
			var params = {
				method: 'share',
				quote: 'Hey guys, check out this job I found on Jobhunters! Apply before time runs out! Tag a friend/relative who might need it!',
				hashtag: '#BeALion, #Jobhunters',
				app_id: '120199111950926',
				display: 'popup',
			  };
			params['href'] = link;
			
			document.getElementById('fb').onclick = function() {
				FB.ui(params, function(response){});
			}\*/
			
			function checkFile(f){	
			
				var file = document.getElementById(f);
				var theFile  = file.files[0];
				
				if(file){
					if( file.value.slice(-3) === "pdf" ){	
						message.style.display = "none";
						
						if (!window.FileReader) {
							message.style.display = "block";
							message.className += " info";
							message.innerHTML = "Please make sure your file is less than 2 MB";
							return;
						}
						else if(theFile.size > 2000000){
							message.style.display = "block";
							message.className = "bubble";
							message.innerHTML =  "Your file is too big. Must be 2MB or less";
							return false;
						}
						return true;
					}
					else{
						message.style.display = "block";
						message.innerHTML = "You must upload your file in pdf format.";
						return false;
					}	
					
				}
				

				
			}
			
			function checkVideo(){
				video = document.getElementById('videoFile');
				
				if(video){
					if(video.value === ""){
						message.style.display = "block";
						message.innerHTML = "You must upload your video.";
						return false;
					}					
					else
						return true;
				}
				
				
			}
			
			function justapply(cid){
				
					if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							result = this.responseText;
							
							if(result){
								document.getElementById("alert1").style.display = "block";
								document.getElementById("applybutton").style.display = "none";
							}
							else{
								document.getElementById("alert1").className = "alert error";
								document.getElementById("alert1").innerHTML = 
								'<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> That\'s strange. Try again.';
								document.getElementById("alert1").style.display = "block";
							}
						}
					};
					xmlhttp.open("GET","functions.php?tag=justapply&c="+cid,true);
					xmlhttp.send();
				
			}	

			// When the user clicks on the button, open the modal 
			function applymodal(cid, letter, screen, video) {
					
				if(letter == 1 && screen == 0 && video == 0){
					modal.style.display = "block";	
					modalcontent.style.width = "386px";
					modalcontent.style.height = "261px";
					document.getElementById("app-top").style.display = "none";
					document.getElementById("app-bottom").style.padding = "0";
				}
				else if(letter == 1 && screen == 1 && video == 0){
					modal.style.display = "block";	
				} 

				
			}	

			function closer(){
				modal.style.display = "none";
			}	
			
			
		</script>
		
		
	</div>
	
	<?php include 'footer.php';?>