<?php
	
	include 'header.php';
?>
	<div class="content" id="jobs" style="height: 80%; background-color: #0e2c4b;">
		
				
		
		<div class="form-container" style="height: 420px">
			<h1>Sign In</h1>
			
			<div class="tab" style="width: fit-content; margin: auto; height: 49px;">
				<button class="tablink" onclick="openTab(event, 'company')">Recruiter</button>
			</div>
							
			<form id="company"  class="tabcontent" style="display: block" method="post" action="signinController.php">
				
				<div class="form-item"> 
					<input type="text" placeholder="Email" id="username" name="email" />
					<input type="hidden" name="type" value="recruiter" />
					<?php 
						if(isset($_GET["back"]))
							echo '<input type="hidden" name="back" value="'. $_GET["back"] .'" />';
					?>
				</div>
				<div class="form-item"> 
					<input type="password"  placeholder="Password" id="pwd" name="pwd" />
				</div>
				<!--div class="form-item"> 
					<input type="checkbox" id="chkbox" name="remember" value="yes" />
					<label for="chkbox">Remember me</label>
				</div-->
				<br/>
				<div class="form-item"> 
					<input style="padding: 0; background-color: #ff9800" type="submit" class="big button" value="Sign in" />
				</div>
				<div class="form-item"> 
					<!-- <p><a href="forgetpwd.php">Forgot password?</a></p> -->
					<p><a href="#">Forgot password?</a></p>
				</div>
				<div class="form-item"> 
					<p><a href="#">Create a FREE account</a></p>
					<!-- <p><a href="signup.php">Create a FREE account</a></p> -->
				</div>
			</form>
			
		</div>	
		
		<script src="signin.js"></script>
		
	</div>	

<?php
	include 'footer.php';
?>