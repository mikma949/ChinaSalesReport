<?php
// Create connection to mySQL
$con=mysqli_connect("localhost","root","mysql");
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Create database if not exist
$createDatabase =
		"CREATE DATABASE IF NOT EXISTS `Commission` 
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
mysqli_query($con,$createDatabase);
// Close the connection to make room for a connection to the database,
mysqli_close($con);

// Create connection to created database
$con=mysqli_connect("localhost","root","mysql", "Commission");		
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>