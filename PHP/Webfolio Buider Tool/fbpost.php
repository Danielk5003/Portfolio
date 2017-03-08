<?php
	session_start();
	$_SESSION["fbid"]=$_POST['fbid'];
	$_SESSION["first"]=$_POST['fb_first'];
	$_SESSION["last"]=$_POST['fb_last'];
    //require_once 'login.php'; //storing login details in another file
	$db_server= new mysqli("mysql.ccacolchester.com", "danielk5003", "1335003","danielk5003"); // login variables
		if ($db_server->connect_error)
		{
			die("Connection failed: " . $db_server->connect_error);  //Status check for connectivity (if failed, error message)	
		}

    if (isset($_POST['fbid'],$_POST["fb_first"],$_POST["fb_last"]))
    {
		$fbid= $_POST['fbid'];
		$fb_first=$_POST['fb_first'];
		$fb_last=$_POST['fb_last'];
		
	$stmt = $db_server->prepare("INSERT INTO students(first_name, last_name,fbid) 
		      VALUES (?,?,?)"); // preparing the query for inserting
			$stmt->bind_param("sss",$fb_first,$fb_last,$fbid);  // declaring each of the parameters type 
			  /* 
				 Inserting data into database by defining the database name, table name and columns
				 user is able to input the data (via url due to no form available currently) and it will be inserted to the
				 columns 
			  */
			  
	$stmt->execute();
	}
	else
	{
		$db_server->close(); //close the connection to the database
    }
?>