<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>WebFolios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</head>
<body>
<script>
// obligatory Facebook script
		window.fbAsyncInit = function() {
			FB.init({
					appId      : '766685630036033',
					cookie     : true,  // enable cookies to allow the server to access 
                        // the session
					xfbml      : true,  // parse social plugins on this page
					version    : 'v2.1' // use version 2.1
				});
		studentList();
					// check login status and display FB login form if necessary
			// make appropriate selection of homepage
			FB.getLoginStatus(function(response) {
				// user already logged into FB in this browser
				if (response.status === 'connected') {
						FB.api('/me', function(response) {
					$.post("fbpost.php",
						{
							fbid:response.id,
							fb_first:response.first_name,
							fb_last:response.last_name,
						});
					//If user login, grab those information to send to database.
				});
					console.log('Already logged in.')
					testAPI();
					getLoggedInHomepage(response); // I call my function to display list of posts
				}
				// ask user to login because they aren't at the moment
				else {
					FB.login(function(response) {
						if (response.authResponse) {
							console.log('Welcome!  Fetching your information.... ');
							getLoggedInHomepage(response); 	 // I call my function to display list of posts	
							testAPI();
						}else {
							console.log('User cancelled login or did not fully authorize.');
							document.getElementById('status').innerHTML = '<h2 class="notlogged">Please login to see your webfolio! </h2>';
						}
					});
				}
				
			});
		};	
		// This function returns the homepage data for a user that is logged into Facebook
		// 1. displays the user's FB id in the status div (for information, while developing - you shouldn't leave it there)
		// 2. displays the list of posts retrieved from database for that student only
		// 3. Links to allow the user to update and delete each post
		function testAPI() 
			{
				console.log('Welcome!  Fetching your information.... ');
				FB.api('/me', function(response) {
				console.log('Successful login for: ' + response.name);
				document.getElementById('name').innerHTML = '<h2 class="name">Welcome ' + response.first_name + ' ' + response.last_name +'! </h2>';
				document.getElementById("add").innerHTML = "<input id='addbutton' name='PostButton' value='Add Post' onclick='showForm()' class='btn btn-primary'>";
			})};  // used to display button, user name and console log on user login or logged in.
		function getLoggedInHomepage(resp) {
			document.getElementById("status").innerHTML = "";

			$.getJSON("getprofile.php",
			{
			      fbid:resp.authResponse.userID, //grabbing user facebook id
			},
			 function(data,status){
					
				// create empty string variable
				// this will contain the text (HTML) to be output to the page
				var infoHTML = "<div id='post'> <table class='table table-hover table-condensed table-responsive' id='post_table'> <thead> <tr> <th> Title </th> <th> Content </> </tr> </thead> <tbody>";
				
				// loop through every JSON object and turn it into HTML for displaying
				$.each(data, function(index, value) {
					infoHTML += " <p class = 'post' id=" + value.post_id + "><tr> <td>" + value.post_title + "</td>  <td>" + value.post_content + " </td> <td> <a href='#' class='btn btn-info btn-sm' onclick='updatePost("+value.post_id+")'  role='button'>Update</a> &nbsp; <a href='#' class='btn btn-info btn-sm' role='button' onclick='deletePost("+value.post_id+")'>Delete</a> </td> </tr></p>";
				}); // end of each()
				
				infoHTML +="</tbody> </div>";
				// display the HTML
				document.getElementById("status").innerHTML = infoHTML;
			});			
		}

		// This function returns the homepage data for a user that is NOT logged into Facebook
		// This is just a list of students who have webfolios
		
		// obligatory Facebook script
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		
		// put event handlers in here to handle user events e.g. click
	/*	$(document).ready(function(){ 
			// event handler for links to update and delete post
			// at the moment it causes an alert box to pop up - to show
			// how key info can be retrieved from the event object
			// you will need to replace this alert with suitable content displayed
			// in the page
			$('#status').on('click', 'a', function(e){
				e.preventDefault(); // stop page reload on click
				alert(e.target.text + " " + e.target.parentNode.id  + " " + e.target.parentNode.parentNode.id);
			});
		}); */
		
		
		function deletePost(id)
		{
			var post_id=id;
			alert("Post with the id " + post_id  + " has been deleted");
			$.ajax({
				type:"POST",
				url:"deletepost.php",
				data:{post_id:post_id},
				success: function() {
				$.getJSON("reload.php",
			 function(data,status){
					
				// create empty string variable
				// this will contain the text (HTML) to be output to the page
				var infoHTML = "<div id='post'> <table class='table table-hover table-condensed table-responsive' id='post_table'> <thead> <tr> <th> Title </th> <th> Content </> </tr> </thead> <tbody>";
				
				// loop through every JSON object and turn it into HTML for displaying
				$.each(data, function(index, value) {
					infoHTML += " <p class = 'post' id=" + value.post_id + "><tr> <td>" + value.post_title + "</td>  <td>" + value.post_content + " </td> <td> <a href='#' class='btn btn-info btn-sm' onclick='updatePost("+value.post_id+")'  role='button'>Update</a> &nbsp; <a href='#' class='btn btn-info btn-sm' role='button' onclick='deletePost("+value.post_id+")'>Delete</a> </td> </tr></p>";
				}); // end of each()
				
				infoHTML +="</tbody> </div>";
				// display the HTML
				document.getElementById("status").innerHTML = infoHTML;
			});			
				
				},
				error: function(){
						alert("Something went wrong");
					}
			}) 
			return false;
		} // end of delete post Ajax not fully functional. 
	$(document).ready(function(){
		$("form#submitpost").submit(function(e){
			e.preventDefault();	
				$.ajax({
					type:"POST",
					url:"addpost.php",
					data:{post_title:post_title.value,post_content:post_content.value},
						success: function() {
					$.getJSON("reload.php",
			 function(data,status){
					
				// create empty string variable
				// this will contain the text (HTML) to be output to the page
				var infoHTML = "<div id='post'> <table class='table table-hover table-condensed table-responsive' id='post_table'> <thead> <tr> <th> Title </th> <th> Content </> </tr> </thead> <tbody>";
				
				// loop through every JSON object and turn it into HTML for displaying
				$.each(data, function(index, value) {
					infoHTML += " <p class = 'post' id=" + value.post_id + "><tr> <td>" + value.post_title + "</td>  <td>" + value.post_content + " </td> <td> <a href='#' class='btn btn-info btn-sm' onclick='updatePost("+value.post_id+")'  role='button'>Update</a> &nbsp; <a href='#' class='btn btn-info btn-sm' role='button' onclick='deletePost("+value.post_id+")'>Delete</a> </td> </tr></p>";
				}); // end of each()
				
				infoHTML +="</tbody> </div>";
				// display the HTML
				document.getElementById("status").innerHTML = infoHTML;
			});			
					},
					error: function(){
						alert("Something went wrong");
					}
					});
		});	
	}); // end of add post function, using on form submit to start the function (Ajax not fully functional).
	function showForm()
	{
		$("#hidden_form").css("display", "block");	
	}
	
	function updatePost(id)
		{
			postid.value=id;
			console.log("Update Post Function Activated. ID is " + id + ". ");
			$("#update").css("display","block");
		} // used to pass post  id to hidden input field to submit
		
			$(document).ready(function(){
		$("form#updateform").submit(function(e){
			e.preventDefault();	
				alert("Post has been updated");
				$.ajax({
					type:"POST",
					url:"updatepost.php",
					data:{updatetitle:updatetitle.value,updatecontent:updatecontent.value,postid:postid.value},
						success: function() {
						$.getJSON("reload.php",
			 function(data,status){
					
				// create empty string variable
				// this will contain the text (HTML) to be output to the page
				var infoHTML = "<div id='post'> <table class='table table-hover table-condensed table-responsive' id='post_table'> <thead> <tr> <th> Title </th> <th> Content </> </tr> </thead> <tbody>";
				
				// loop through every JSON object and turn it into HTML for displaying
				$.each(data, function(index, value) {
					infoHTML += " <p class = 'post' id=" + value.post_id + "><tr> <td>" + value.post_title + "</td>  <td>" + value.post_content + " </td> <td> <a href='#' class='btn btn-info btn-sm' onclick='updatePost("+value.post_id+")'  role='button'>Update</a> &nbsp; <a href='#' class='btn btn-info btn-sm' role='button' onclick='deletePost("+value.post_id+")'>Delete</a> </td> </tr></p>";
				}); // end of each()
				
				infoHTML +="</tbody> </div>";
				// display the HTML
				document.getElementById("status").innerHTML = infoHTML;
			});				
					},
					error: function(){
						alert("Something went wrong");
					}
					});
		});	
	}); //end of update function, Ajax not fully functional. 
		
	function studentList()
	{
			$.getJSON("viewall_json.php",
			function(data){
				document.getElementById("student_list").innerHTML = "";
				var dataHTML = "<table class='table table-hover' id='studenttable'><thead><tr><th>Student Full Name</th></tr></thead><tbody>";
				$.each(data,function(index,value){
					dataHTML += "<tr><td> <a href='#' onclick='viewContent("+value.fbid+")'>" + value.name + "</a></td></tr>";
				});
				dataHTML += "</tbody></table>";
				document.getElementById("student_list").innerHTML = dataHTML;
			});
	}
	
	function viewContent(id) //to view content of other users
	{
		var studentId=id; //storing the id from the function to pass to php later
		document.getElementById("status").innerHTML = "";

			$.getJSON("getprofile.php",
			{
			     fbid:studentId //passing to php script as fbid.
			},
			 function(data,status){
					
				// create empty string variable
				// this will contain the text (HTML) to be output to the page
				var infoHTML = "<div id='post'> <table class='table table-hover table-condensed table-responsive' id='post_table'> <thead> <tr> <th> Title </th> <th> Content </> </tr> </thead> <tbody>";
				
				// loop through every JSON object and turn it into HTML for displaying
				$.each(data, function(index, value) {
					infoHTML += " <p class = 'post' id=" + value.post_id + "><tr> <td>" + value.post_title + "</td>  <td>" + value.post_content + " </td></tr></p>";
				}); // end of each()
				
				infoHTML +="</tbody> </div>";
				// display the HTML
				document.getElementById("status").innerHTML = infoHTML;
		
			 });
	}
	
	
</script>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">WebFolios</a>
    </div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="index.php">Home</a></li>
					<li><form class="navbar-form" role="search" action="search_2.php" method="post" >
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search for students" name="search_term" id="search_term">
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</div>
				</form></li>
			</div>
				</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><div class = "facebook" > <fb:login-button size="large" autologoutlink="true" scope="public_profile,email">Login with Facebook</fb:login-button> </div></li>
			</ul>
		</div>
	</div>
</nav>
<div id="container-fluid" class="container-fluid">
	<div class ="row" id="contentrow">
		<div class ="col-xs-1">
		</div>
		<div class="col-xs-6" id = "content">
			<div id="name">
			</div>
			<div id="status">
			</div>
			<div id ="add">
			</div>
			<div id="hidden_form">
				<form class="form-horizontal" role="form" name="submitpost" id="submitpost" method="post" action ="addpost.php">
					<div class="form-group">
						<label for="post_title" > Title </label>
						<div>
							<input type="text" class="form-control" id="post_title" name="post_title" placeholder="Post Title" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="post_content"> Content </label>
						<div>
							<input type="text" class="form-control"  id="post_content" name="post_content" placeholder="Post Content" value="">
						</div>
					</div>
					<div>
						<input id="submitbutton" name="submitbutton" type="submit" value="Submit" class="btn btn-primary">
					</div>	

				</form>
			</div>
		</div>
		<div class="col-xs-4">
		<div class="table-responsive"> 
		<div id="student_list">
		</div>
		<div class ="col-xs-1">
		</div>
		</div>
		<div id ="update">
								<form class="form-horizontal" role="form" name="updateform" id="updateform" method="post" action ="updatepost.php">
					<div class="form-group">
						<label for="updatetitle" class="col-sm-2 control-label">Update Title </label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="updatetitle" name="updatetitle" placeholder="Post Title" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="updatecontent" class="col-sm-2 control-label">Update Content </label>
						<div class="col-sm-5">
							<input type="text" class="form-control"  id="updatecontent" name="updatecontent" placeholder="Post Content" value="">
						</div>
					</div>
					<div>
						<input type="hidden"  class="form-control" name="postid" id="postid">
					</div>
					<div class="col-sm-10 col-sm-offset-2">
						<input type="submit" value="Submit" class="btn btn-primary">
					</div>		
				</form>
			</div>
		</div>
	</div>
	<div class="row" id="footerrow">
		<footer class="footer">
			<div class="col-xs-12">
				<p>WebFolios 2015</p>	
			</div>
		</footer>
</div>
</div>	


</body>
</html>