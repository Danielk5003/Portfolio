<?php

	require_once "login.php"; //storing login details in another file
	$db_server= new mysqli($db_hostname, $db_user, $db_password,$db_database); // login variables
		if ($db_server->connect_error)
		{
			die("Connection failed: " . $db_server->connect_error);  //Status check for connectivity (if failed, error message)	
		}
	$post_id = htmlentities(mysqli_real_escape_string($db_server,$_POST['postid']));
	$post_title =htmlentities(mysqli_real_escape_string($db_server,$_POST['updatetitle']));
	$post_content = htmlentities(mysqli_real_escape_string($db_server,$_POST['updatecontent']));

	if (empty($post_title) || empty($post_content))
		{
			echo " you need to fill in all available fields ";
			die(); 
		}
		$stmt = $db_server->prepare ("UPDATE post SET post_title=?, post_content =? WHERE post_id = ?");
			$stmt->bind_param("ssi",$post_title,$post_content,$post_id); // binding parameters to string, string and integer to the fields
			  /* 
				 updating data in database by defining the database name, table name and columns
				 user is able to update the data (via url due to no form available currently) and it will be updated to the
				 columns 
			  */
			$stmt->execute();
			
		if ($stmt->errno) // if error occurred, show error message.
		{
			echo "Error! " . $stmt->error;
		}


			$stmt->close(); // closing the prepared statement
			$db_server->close(); //close the connection to the database 
?>

