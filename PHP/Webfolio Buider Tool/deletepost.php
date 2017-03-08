<!DOCTYPE html>
<?php
require_once "login.php"; //storing login details in another file
	$db_server= new mysqli($db_hostname, $db_user, $db_password,$db_database); // login variables
		if ($db_server->connect_error)
		{
			die("Connection failed: " . $db_server->connect_error);  //Status check for connectivity (if failed, error message)	
		}
	$post_id = $_POST['post_id'];

		$stmt = $db_server->prepare ("DELETE FROM post WHERE post_id = ?");
			$stmt->bind_param("i",$post_id); // bind parameter to integer (post_id) 
			  /* 
				 deleting data in database by defining the database name, table name and rows
				 user is able to delete the data (via url due to no form available currently) and it will be removed from
				 the database 
			  */
			$stmt->execute();
			
		if ($stmt->errno) // if error occurred, show error message.
		{
			echo "Error! " . $stmt->error;
		}
		else
		{
			$stmt->close(); // closing the prepared statement
			$db_server->close(); //close the connection to the database
		}


?>