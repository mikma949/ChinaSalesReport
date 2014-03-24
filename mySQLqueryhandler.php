<?php
include "mySQLconnection.php";

//Getting sales_persons from mySQL
if($_POST['action']=='getSalesPersons'){
$data = array(); 		// array to pass back data

$sql="SELECT * FROM sales_person";	
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
//Getting cities from mySQL
if($_POST['action']=='getCities'){
$data = array(); 		// array to pass back data
		
$sql="SELECT * FROM city";	
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
//Getting number of items left to sell from mySQL
if($_POST['action']=='getItemsLeft'){
$data = array(); 		// array to pass back data
$year = substr($_POST[inDate],0,4);	
$month = substr($_POST[inDate],5,2);
$month = strtr ($month, array ('-' AND -'0' => ''));	
$result = mysqli_query($con,"SELECT getItemsLeft(1, '$year', '$month') as locks, 
									getItemsLeft(2, '$year', '$month') as stocks,
									getItemsLeft(3, '$year', '$month') as barrels");
		
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
//Getting sales statistics from mySQL
if($_POST['action']=='getSales'){
$data = array(); 		// array to pass back data
		
$sql="SELECT *	FROM report ORDER BY year_report,month_report";	

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

//Insert into database
$sql="INSERT INTO sales (sale_date,sales_person_id,city_id,product_id,quantity) 
		VALUES ('$_POST[inDate]','$_POST[salesPerson]','$_POST[city]','$_POST[locks]','$_POST[locksSold]'),
			   ('$_POST[inDate]','$_POST[salesPerson]','$_POST[city]','$_POST[stocks]','$_POST[stocksSold]'),
			   ('$_POST[inDate]','$_POST[salesPerson]','$_POST[city]','$_POST[barrels]','$_POST[barrelsSold]')";

	if (!mysqli_query($con,$sql)){
		die('Error: ' . mysqli_error($con));
	}
}
?>

