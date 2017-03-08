<?php
session_start();

require_once "login.php"; //storing login details in another file
	$db_server= new mysqli($db_hostname, $db_user, $db_password,$db_database); // login variables
		if ($db_server->connect_error)
		{
			die("Connection failed: " . $db_server->connect_error);  //Status check for connectivity (if failed, error message)	
		}
	$post_title = htmlentities(mysqli_real_escape_string($db_server,$_POST['post_title']));
	$post_content =htmlentities(mysqli_real_escape_string($db_server,$_POST['post_content']));
	$fbid = htmlentities(mysqli_real_escape_string($db_server,$_SESSION['fbid']));

		if (empty($post_title) || empty($post_content))
		{
			echo "you need to fill in all available fields";
			die(); 
		}
		else
		{
		 $stmt = $db_server->prepare("INSERT INTO post (post_title,post_content,fbid)
                                VALUES (?,?,?)");
			$stmt->bind_param("sss",$post_title,$post_content,$fbid);
		$stmt->execute();
		}
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
		

