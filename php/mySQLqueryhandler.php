<?php
include "mySQLconnection.php";
include "mySQLinitiate.php";

//Getting sales_persons from mySQL
if($_POST['action']=='getSalesPersons'){
	$data = array(); 		// array to pass back data

	$sql="SELECT id, name FROM sales_person";	
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

//Getting cities from mySQL
if($_POST['action']=='getRoles'){
	$data = array(); 		// array to pass back data
			
	$sql="SELECT * FROM role";	
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
	$month = substr($_POST[inDate],4,2);
	$result = mysqli_query($con,"SELECT getItemsLeft(1, '$year', '$month') as locks, 
									getItemsLeft(2, '$year', '$month') as stocks,
									getItemsLeft(3, '$year', '$month') as barrels");
		
	if (!$result){
		die('Error: ' . mysqli_error($con));
	}else{
		// A result was gathered from the db
		// Converting the query result to an array
		$data = mysqli_fetch_assoc($result);
		echo json_encode($data);
	}	
}

//Getting sales statistics from mySQL
if($_POST['action']=='getYear'){
	$data = array(); 		// array to pass back data
		
	$sql="SELECT YEAR(sale_date) year FROM sales ORDER BY YEAR(sale_date) desc, MONTH(sale_date)";	

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

//Get the month of chosen year
if($_POST['action']=='getMonth' && !is_null($_POST[year]) && $_POST[year] != ""){
	$data = array(); 		// array to pass back data
			
	$sql="SELECT MONTH(sale_date) month 
			FROM sales 
			WHERE YEAR(sale_date) = $_POST[year]
			ORDER BY MONTH(sale_date)";	

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


//Get the total sales of the month
if($_POST['action']=='getSales' && !is_null($_POST[year]) && !is_null($_POST[month]) && $_POST[month] != "" && $_POST[year] != ""){
	$data = array(); 		// array to pass back data
	$year = $_POST[year];	
	$month = $_POST[month];
	$result = mysqli_query($con,"SELECT IFNULL(sum(s.quantity*p.price),0) total 
							FROM sales s
                            left join product p on s.product_id = p.id
							WHERE YEAR(s.sale_date) = $year
								AND MONTH(s.sale_date) = $month");
		
	if (!$result){
		die('Error: ' . mysqli_error($con));
	}else{
		// A result was gathered from the db
		// Converting the query result to an array
		$data = mysqli_fetch_assoc($result);
		echo json_encode($data);
	}	
}

//Get the sales and commission of the month per person
if($_POST['action']=='getPersonalSales'){
	$data = array(); 		// array to pass back data
	$year = $_POST[year];	
	$month = $_POST[month];
	if(!is_null($_POST[year]) && !is_null($_POST[month]) && $_POST[month] != "" && $_POST[year] != ""){
		$result = mysqli_query($con,"SELECT sp.id id,
								IFNULL(sp.name, 'No sales') name, 
								IFNULL(sum(s.quantity*p.price),0) sales, 
								getCommission(sum(s.quantity*p.price)) commission
								FROM sales s
								LEFT JOIN sales_person sp ON s.sales_person_id = sp.id
								LEFT JOIN product p ON s.product_id=p.id
								WHERE YEAR(sale_date) = $year
								AND MONTH(sale_date)=$month
								GROUP BY sp.name
								ORDER BY sp.id");
			
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
}
//Get the sales and commission of the month per person
if($_POST['action']=='getCitySales'){
	$data = array(); 		// array to pass back data
	$year = $_POST[year];	
	$month = $_POST[month];
	if(!is_null($_POST[year]) && !is_null($_POST[month]) && $_POST[month] != "" && $_POST[year] != ""){
		$result = mysqli_query($con,"SELECT IFNULL(c.name, 'No sales') name, 
								IFNULL(sum(s.quantity*p.price),0) sales 
								FROM sales s
								LEFT JOIN city c ON s.city_id = c.id
								LEFT JOIN product p ON s.product_id=p.id
								WHERE YEAR(sale_date) = $year
								AND MONTH(sale_date)=$month
								GROUP BY c.name");
			
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
}

//Get the number of items sold per person of the month
if($_POST['action']=='getItemsSold'){
	$data = array(); 		// array to pass back data
	$year = $_POST[year];	
	$month = $_POST[month];
	if(!is_null($_POST[year]) && !is_null($_POST[month]) && $_POST[month] != "" && $_POST[year] != ""){
	$result = mysqli_query($con,"SELECT sp.name person, 
					p.name product, 
					sum(s.quantity) itemsSold
					FROM sales s
					LEFT JOIN product p ON s.product_id = p.id
					LEFT JOIN sales_person sp on s.sales_person_id = sp.id
					WHERE YEAR(s.sale_date) = $year
					AND MONTH(s.sale_date) = $month
					GROUP BY s.sales_person_id, p.id
					ORDER BY s.sales_person_id");
			
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
}

//Update role of chosen person
if($_POST['action']=='updateRole'){
$role = $_POST[role];
$person = $_POST[salesPerson];
	$sql="UPDATE sales_person 
			SET role = $role
			WHERE id = $person";

	if (!mysqli_query($con,$sql)){
		die('Error: ' . mysqli_error($con));
	}
}
?>

