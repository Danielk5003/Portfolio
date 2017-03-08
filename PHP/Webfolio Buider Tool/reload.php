<?php
	session_start();
require_once "login.php"; //storing login details in another file
	$db_server= new mysqli($db_hostname, $db_user, $db_password,$db_database); // login variables
		if ($db_server->connect_error)
		{
			die("Connection failed: " . $db_server->connect_error);  //Status check for connectivity (if failed, error message)	
		}
		$fbid= $_SESSION['fbid'];
		
	$query = "SELECT post_id, post_title, post_content FROM students 
			  inner join post on students.fbid = post.fbid
			  WHERE students.fbid = $fbid";
	$result = mysqli_query($db_server, $query);
	
	 $response = array(); //declaring response as array 

    while($row = mysqli_fetch_assoc($result)) // loop for data in the database
    {
        $response[] = $row; // using response to store information from database
    }
	    print json_encode($response); //  print out data stored in response as json
	
?>