<?php
include "mySQLconnection.php";

//Getting data from mySQL
	if($_POST['action']=='get'){
		$data = array(); 		// array to pass back data
		$sql="SELECT sum(locksSold) as locksSold, sum(stocksSold) as stocksSold, sum(barrelsSold) as barrelsSold
		  FROM Sale";
		
		$result = mysqli_query($con,$sql);
		
		if (!$result){
			die('Error: ' . mysqli_error($con));
		}else{
			// A result was gathered from the db
			// Converting the query result to an array
			while( $row = mysqli_fetch_assoc($result)){
  			  $data[] = $row;
  			}
  			
  		echo json_encode($data);
  	}
  }

//Sending input data to mySQL
	if($_POST['action']=='send'){
		$errors         = array();  	// array to hold validation errors
		$data 			= array(); 		// array to pass back data

		// validate the variables ======================================================
		if (empty($_POST['year']))
			$errors['year'] = 'Date is required.';

		if (empty($_POST['salesPerson']))
			$errors['salesPerson'] = 'Name alias is required.';

		// return a response ===========================================================
		// response if there are errors
		if (!empty($errors)) {

			// if there are items in our errors array, return those errors
			$data['success'] = false;
			$data['errors']  = $errors;
		} else {

			// if there are no errors, return a message
			$data['success'] = true;
			$data['message'] = 'Success!';
	

			//Insert into database
			$sql="INSERT INTO Sale (year, person, city ,locksSold, stocksSold, barrelsSold) 
			VALUES ('$_POST[year]','$_POST[salesPerson]','$_POST[city]','$_POST[locksSold]'
					,'$_POST[stocksSold]','$_POST[barrelsSold]')";

			if (!mysqli_query($con,$sql)){
				die('Error: ' . mysqli_error($con));
			}
		}

	// return all our data to an AJAX call
	echo json_encode($data);
}

?>

