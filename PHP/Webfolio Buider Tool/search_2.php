<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>WebFolios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
</head>
<body>

<script>

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '766685630036033',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  // This is called with the results from from FB.getLoginStatus().
  
   function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }



  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
	FB.api('/me', function(response) {
		$.post("fbpost.php",
		{
			fbid:response.id,
			fb_first:response.first_name,
			fb_last:response.last_name,
		}
		/*function(data,status){
		// alert pops up once response from server received
		alert("Data: " + data + "\nStatus: " + status);
		}); */
      // Logged into your app and Facebook.
      
	 ); testAPI();
  });} 
	/*else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    } */
  } 
  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
 
  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      //document.getElementById('status').innerHTML =
        //'Thanks for logging in, ' + response.name + '!';
    });
  }
 
  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));


</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">WebFolios</a>
    </div>
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
        <li><div class = "facebook" > <fb:login-button size="large" autologoutlink="true" scope="public_profile,email" onlogin="checkLoginState();">Login with Facebook</fb:login-button> </div></li>
      </ul>
    </div>
  </div>
</nav>
<div class ="container-fluid">
	<div class ="row">
		<div class ="col-xs-3">
		</div>
		<div class="col-xs-6" id="table">
			<div class="table-responsive"> 
				<table class="table table-hover"  id="allstudent">
					<thead>
						<tr class="tabletitle">
							<th> Student Name </th>
							<th> Course Path </th>
						</tr>
					</thead>
					<tbody>
<?php
    /*
        Name: Daniel Kong id: 1335003 Date: Nov 2014
        Description: search function using where like and wild cards
        print out first name, last name and degree from student table
        when the first name and last name match the search term

    */
	require_once "login.php"; //storing login details in another file
		$db_server= new mysqli($db_hostname, $db_user, $db_password,$db_database); // login variables
        if ($db_server->connect_error)
        {
            die("Connection failed: " . $db_server->connect_error);  //Status check for connectivity (if failed, error message) 
        }
				$search_term = htmlentities(mysqli_real_escape_string($db_server,$_POST['search_term']));
                if (empty($search_term)) // Check if  the field is empty (If empty return error message and disconnect
        {
            echo "You need to fill in all available fields";
            die(); 
        }
        else 
        {
        
            $query = "SELECT first_name,last_name,degree  FROM students WHERE `first_name` LIKE '%$search_term%' OR `last_name` LIKE '%$search_term%'";
            /*
                query to select first name, last name and degree from students table
                where the first name or last name name match the search term
            */
              
            $result = mysqli_query($db_server, $query);	
    
            echo "<h2 style='text-align:center'> Search term : " .$search_term ."</h2>";
            while($row = mysqli_fetch_assoc($result)) // loop for data in the database
            {
                $first_name = $row['first_name']; // store query data into first name 
                $last_name = $row['last_name']; // store query data into last name 
                $degree = $row['degree']; // store query data into degree
                echo "<tr>"."<td>".$first_name." ".$last_name ."</td>" ."<td>".$degree."</td>"."</tr>";
            }
        }
    
?>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class ="col-xs-3">
		</div>


<div class="row">
		<footer class="footer">
			<div class="col-xs-12">
				<p class="text-muted">WebFolios 2015</p>	
			</div>
		</footer>
</div>

</body>
</html>
