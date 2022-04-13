<?php $active = "campaigns"; include 'den-head.php'; 
	
?>
	<div class="content">
		<h1>New Campaign</h1>
		<?php
			if(isset($_GET["r"])){
				if($_GET["r"] == "y")
					echo '
						<div id="alert1" class="alert success dropdown" >
						  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
						  New campaign created. <i class="fa fa-check" aria-hidden="true"></i>
						</div>
					';
				else
					echo '
						<div id="alert1" class="alert error dropdown">
						  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
						  <i class="fa fa-info" aria-hidden="true"></i> Something strange happened adding your campaign.
						</div>
					';
			}
		?>
		<br/>
		<div class="tab" style="width: 655px; margin: auto;">
		  <!--button class="tablinks" onclick="openTab(event, 'details')">Details</button-->
		  <button class="tablinks" onclick="openTab(event, 'details')" id="default">Details</button>
		</div>
		
		<div class="den-form new" style="margin: auto" id="details">
		
			<form method="post" action="newcampaignController.php">
				<div>
					Job Title: <input type="text" name="title" placeholder="E.g. Software Engineer" text="Software Engineer" required />
				</div>
				<div>
					Overview: <textarea name="overview" placeholder="Enter a general overview of the job." rows="5" text="" required></textarea>
				</div>
				<br/>
				<div>
					Employment Type: <select name="emp_type" required>
										<option value="Full time" selected>Full time</option>
										<option value="Part time">Part time</option>
										<option value="Internship">Internship</option>
										<option value="Voluntary">Voluntary</option>
										<option value="Contractor">Contractor</option>
										<option value="Other">Other</option>
									 </select>	
				</div>
				<br/>

				<div id="duties" required>
					Duties: <textarea name="duties" rows="5" placeholder="Enter the duties and responsibilities of the job." required></textarea>
				</div>
				<br/>
				<div id="requirements" required>
					Requirements: <textarea name="requirements" rows="5" placeholder="Enter the required or prefered qualifications/experience for the job." required></textarea>
				</div><br/>
				
				<div id="keywords">
					Keywords: <textarea name="keywords" rows="5" placeholder="Enter additional keywords to help find better matches." required></textarea>
				</div>

				<!--div>
					<a class="big-button" onclick="showtest()">Create Test</a>
				</div-->
				
							
				<div> 
					<input class="form-button" type="submit" value="Post Job" />
				</div>
			
			</form>	
		</div>

		
		<script>
			// Get the element with id="defaultOpen" and click on it
			document.getElementById("default").click();
			
			// Get the modal
			var modal = document.getElementById('myModal');

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			
			function showtest(){
				document.getElementById('myModal').style.display = "block";
			}
			
			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}
			
			function addDuties(){
				var input = document.createElement("input");
				var nl = document.getElementById("nl");
				input.type = "text";
				input.required = true;
				input.name = "duties[]";
				document.getElementById("duties").insertBefore(input, nl);
			}
			
			var i = 0;
			
			function addQuestion(){
				var add = document.getElementById("add-container");	
				
				if(i < 5){
					var divcount = (document.getElementById("test").getElementsByTagName("div").length - 1);
								
					
					var node = document.createElement("div");                 // Create a <div> node
					var textnode = document.createTextNode("Question " + divcount + ":");         // Create a text node
					node.appendChild(textnode);                              // Append the text to <div>
					
					var input = document.createElement("input");
					input.type = "text";
					input.name = "questions[]";
					input.id = "q"+divcount;
					
					node.appendChild(input);                              // Append the input field to <div>
					
					document.getElementById("test").insertBefore(node, add);
					
					i++; //counting questions added
				}
				else{
					add.style.display = "none";
				}
				
			}

			function addRequirements(){
				var input = document.createElement("input");
				var nl = document.getElementById("rnl");
				input.type = "text";
				input.required = true;
				input.name = "requirements[]";
				document.getElementById("requirements").insertBefore(input, nl);
			}
						
			var bool = 0;
						
			function deleteRow(r) {
				var i = r.parentNode.parentNode.rowIndex;
				document.getElementById("cart").deleteRow(i);
				bool = 1;
			}
			
					
			function addRow(id) {
				if(bool){
					var table = document.getElementById("cart");
					var row = table.insertRow(1);
					var cell1 = row.insertCell(0);
					var cell2 = row.insertCell(1);
					var cell3 = row.insertCell(2);
					var cell4 = row.insertCell(3);
					var cell5 = row.insertCell(4);
					var cell6 = row.insertCell(5);			
					
					//USE SWITCH STATEMENT TO LET THEM SELECT PACKAGE AFTER TRIAL VERSION
							
					cell1.innerHTML = '<img src="imgs/emerald2.png" /><span>Free Trial</span>';
					cell2.innerHTML = "30 days";
					cell3.innerHTML = "UNLIMITED";
					cell4.innerHTML = "$0.00";
					cell5.innerHTML = "FREE";
					cell6.innerHTML = '<span onclick="deleteRow(this)"><i class="fa fa-trash-o" aria-hidden="true"></i></span>';
					
					bool = 0;
					
					//SHOW DATE
					document.getElementById("date").style.display = "block";
					
					//SET END DATE TO MAX DURATION DEPENDING ON PACKAGE
					switch(id){
						
						case 'emerald':
							//CHANGE THIS WHEN THE LAUNCH IS FINISH
							document.getElementById("endDate").value = "<?php echo date("Y-m-d", strtotime("today +45 days"));?>";
							break;
							
						case 'ruby':
							document.getElementById("endDate").value = "<?php echo date("Y-m-d", strtotime("today +30 days"));?>";
							break;
							
						case 'sapphire':
							document.getElementById("endDate").value = "<?php echo date("Y-m-d", strtotime("today +15 days"));?>";
							break;
						
					}
					
					
				}					
			}
			
			function openTab(evt, cityName) {
				// Declare all variables
				var i, tabcontent, tablinks;

				// Get all elements with class="tabcontent" and hide them
				tabcontent = document.getElementsByClassName("den-form");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}

				//  Remove the class "active" from tabs
				tablinks = document.getElementsByClassName("tablinks");
				for (i = 0; i < tablinks.length; i++) {
					tablinks[i].className = tablinks[i].className.replace(" active", "");
				}

				// Show the current tab, and add an "active" class to the button that opened the tab
				document.getElementById(cityName).style.display = "block";
				evt.currentTarget.className += " active";
			}
			
			function save(){
				alert = document.getElementById('alert1');
				alert.style.display = "block";
			}
			
			
					function details(orderid){
						
						
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
								
								bolly = xmlhttp.responseText;
								
								if(bolly == 1){
									console.log('orderid session created');
									bolly = false;
								}
								else{
									console.log('orderid not created');
									bolly = true;
								}
								
							}
						}
						xmlhttp.open("GET","functions.php?tag=neworder&orderid="+orderid, true);
						xmlhttp.send();
						
						if(bolly == 1)
							openTab(event, 'details');
					}
				
					var thetotal = document.getElementById('total').value;
				
					// Render the PayPal button
					paypal.Button.render({

						// Set your environment

						env: 'sandbox', // sandbox | production
						
						// Show the buyer a 'Pay Now' button in the checkout flow
						commit: true,


						// Specify the style of the button

						style: {
							label: 'buynow',
							fundingicons: true, // optional
							branding: true // optional
						},

						// PayPal Client IDs - replace with your own
						// Create a PayPal app: https://developer.paypal.com/developer/applications/create

						client: {
							sandbox:    'AQxxPYysSUwyjDqK2VknHsd7Zt6b06WnROuzztAj-LJlk6wHb06K55_Odjn5A68delZep8hi1GcuRebz',
							production: '<insert production client id>'
						},

						// Wait for the PayPal button to be clicked

						payment: function(data, actions) {
							return actions.payment.create({
								transactions: [
									{
										amount: { total: document.getElementById('total').value, currency: 'USD' }
									}
								]
							});
						},

						// Wait for the payment to be authorized by the customer

						onAuthorize: function(data, actions) {
							return actions.payment.execute().then(function() {
								window.alert('Payment Complete!');
							});
						}

					}, '#paypal-button-container');

				
		</script>


	</div>
<?php include 'toe.php';?>