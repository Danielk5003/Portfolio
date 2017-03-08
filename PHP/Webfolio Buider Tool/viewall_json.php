<?php
	/*
		Name: Daniel Kong id: 1335003 
		Description:
		PHP script to view all records in database (webfolios)
	*/
   // require_once 'login.php'; //storing login details in another file
        $db_server= new mysqli("mysql.ccacolchester.com", "danielk5003", "1335003","danielk5003"); // login variables
        if ($db_server->connect_error)
        {
            die("Connection failed: " . $db_server->connect_error);  //Status check for connectivity (if failed, error message) 
        }
    $query = "SELECT  Concat (first_name,' ', last_name) As name,fbid FROM students WHERE fbid >=50 ";
             
                /* 
					Query by concatenating the first name and last name as name
					then printing name out with fbid id more than 50
				*/
    $result = mysqli_query($db_server, $query);
	
	if (!result) die ("Database access failed: " . mysql_error());
	
    $response = array(); //declaring response as array 

    while($row = mysqli_fetch_assoc($result)) // loop for data in the database
    {
        $response[] = $row; // using response to store information from database
    }
	    print json_encode($response); //  print out data stored in response as json
?>
