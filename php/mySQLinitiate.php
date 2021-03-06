<?php
include "mySQLconnection.php";

$create['City'] =
		"CREATE TABLE IF NOT EXISTS `city` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
 			`name` varchar(45) DEFAULT NULL,
  			PRIMARY KEY (`id`)
		);";

$populate['City']=
		"INSERT INTO `city` (`id`, `name`) VALUES
			(1, 'Harbin'),
			(2, 'Beijing'),
			(3, 'Stockholm');";

$create['Commission'] =
		"CREATE TABLE IF NOT EXISTS `commission` (
 			`id` int(11) NOT NULL,
 			`boundry` int(11) NOT NULL,
  			`percent` decimal(4,3) NOT NULL,
  			PRIMARY KEY (`id`)
		);";

$populate['Commission'] =
		"INSERT INTO `commission` (`id`, `boundry`, `percent`) VALUES
			(1, 0, '0.100'),
			(2, 1000, '0.150'),
			(3, 1800, '0.200');";

$create['Product'] =
		"CREATE TABLE IF NOT EXISTS `product` (
  			`id` int(11) NOT NULL AUTO_INCREMENT,
  			`name` varchar(45) DEFAULT NULL,
  			`price` int(11) NOT NULL,
  			`maxAmount` int(11) NOT NULL,
  			PRIMARY KEY (`id`)
		);";

$populate['Product'] =
		"INSERT INTO `product` (`id`, `name`, `price`, `maxAmount`) VALUES
			(1, 'Lock', 45, 70),
			(2, 'Stock', 30, 80),
			(3, 'Barrel', 25, 90);";

$create['SalesPersons'] =
		"CREATE TABLE IF NOT EXISTS `sales_person` (
  			`id` int(11) NOT NULL AUTO_INCREMENT,
  			`name` varchar(45) NOT NULL,
  			`password` varchar(45) NOT NULL,
  			`role` int(11) NOT NULL,
  			PRIMARY KEY (`id`)
		);";

$populate['SalesPersons'] =
		"INSERT INTO `sales_person` (`id`, `name`,`password`,`role`) VALUES
			(1, 'Micke','7214140f65353ffce02103596fc6d004',1),
			(2, 'Albin','f0d7738a4515fb57ae41da4ede014b7a',1),
			(3, 'Fredrik','875b9fc5c8b60d689717e465f2ef28bb',1);";

$create['Report'] =
		"CREATE TABLE IF NOT EXISTS `report` (
  			`id` int(11) NOT NULL AUTO_INCREMENT,
  			`year_report` int(11) NOT NULL,
  			`month_report` int(11) NOT NULL,
  			`total_sales` int(11) NOT NULL,
  			`commission` float NOT NULL,
  			`reported` tinyint(1) NOT NULL DEFAULT '0',
  			PRIMARY KEY (`id`),
  			UNIQUE KEY `year_month` (`year_report`,`month_report`)
		);";

$create['Sales'] =
		"CREATE TABLE IF NOT EXISTS `sales` (
  			`id` int(11) NOT NULL AUTO_INCREMENT,
  			`sale_date` date NOT NULL,
  			`sales_person_id` int(11) NOT NULL,
  			`city_id` int(11) NOT NULL,
  			`product_id` int(11) NOT NULL,
  			`quantity` int(11) NOT NULL DEFAULT '0',
  			PRIMARY KEY (`id`),
  			KEY `fk_city_idx` (`city_id`),
  			KEY `fk_sales_person_idx` (`sales_person_id`),
  			KEY `fk_product_idx` (`product_id`)
		);";

$create['Role'] =
		"CREATE TABLE IF NOT EXISTS `role` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
 			`position` varchar(45) DEFAULT NULL,
  			PRIMARY KEY (`id`)
		);";

$populate['Role']=
		"INSERT INTO `role` (`id`, `position`) VALUES
			(1, 'new employee'),
			(2, 'sales person'),
			(3, 'manager'),
			(4, 'administrator');";

//Send all queries to the database.	
	foreach ($create as $input) {
	 mysqli_query($con,$input);
	}

	foreach ($populate as $input) {
	 mysqli_query($con,$input);
	}	


?>