<?php
include "mySQLconnection.php";
$create = {};
$populate = {};

$createDatabase =
		"CREATE DATABASE IF NOT EXISTS `Commission` 
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		USE `Commission`;";

$create.City =
		"CREATE TABLE IF NOT EXISTS 
			`city` (`id` int(11) NOT NULL AUTO_INCREMENT,
 			 `name` varchar(45) DEFAULT NULL,
  			PRIMARY KEY (`id`)
		);";

$populate.City=
		"INSERT INTO `city` (`id`, `name`) VALUES
			(1, 'Harbin'),
			(2, 'Beijing'),
			(3, 'Stockholm');";

$create.Commission =
		"CREATE TABLE IF NOT EXISTS `commission` (
 			`id` int(11) NOT NULL,
 			`boundry` int(11) NOT NULL,
  			`percent` decimal(4,3) NOT NULL,
  			PRIMARY KEY (`id`)
		);";

$populate.Commission =
		"INSERT INTO `commission` (`id`, `boundry`, `percent`) VALUES
			(1, 0, '0.100'),
			(2, 1000, '0.150'),
			(3, 1800, '0.200');";

$create.Product =
		"CREATE TABLE IF NOT EXISTS `product` (
  			`id` int(11) NOT NULL AUTO_INCREMENT,
  			`name` varchar(45) DEFAULT NULL,
  			`price` int(11) NOT NULL,
  			`maxAmount` int(11) NOT NULL,
  			PRIMARY KEY (`id`)
		);";

$populate.Product =
		"INSERT INTO `product` (`id`, `name`, `price`, `maxAmount`) VALUES
			(1, 'Lock', 45, 70),
			(2, 'Stock', 30, 80),
			(3, 'Barrel', 25, 90);";

$create.SalesPersons =
		"CREATE TABLE IF NOT EXISTS `sales_person` (
  			`id` int(11) NOT NULL AUTO_INCREMENT,
  			`name` varchar(45) DEFAULT NULL,
  			PRIMARY KEY (`id`)
		);";

$populate.SalesPersons =
		"INSERT INTO `sales_person` (`id`, `name`) VALUES
			(1, 'Micke'),
			(2, 'Albin'),
			(3, 'Fredrik');";

$create.Report =
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

$create.Sales =
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

$create.getCommissionFunction =
		"DROP FUNCTION IF EXISTS `getCommission`;
		DELIMITER //
		CREATE FUNCTION `getCommission`(`totalSales` int(11)) RETURNS int(11)
			BEGIN
				DECLARE thisBoundry, lastBoundry,loopDone int;
				DECLARE thisCommission, restCommission float;
				DECLARE thisPercent, lastPercent decimal(4,3);
				DECLARE cur cursor for 
					select boundry, percent 
					from commission order by boundry ;
				DECLARE CONTINUE HANDLER FOR NOT FOUND SET loopDone = 1;

				SET loopDone=0;
				SET thisCommission = 0;
				SET restCommission = 0;
				SET lastPercent = 0;
				SET lastBoundry = 0;

				OPEN cur;
				set_commission : LOOP
			
				FETCH cur into thisBoundry, thisPercent;
					if loopDone =1 then
    					leave set_commission;
    	 			end if;   
		
    				if totalSales > thisBoundry then
						SET thisCommission = thisCommission + lastPercent*(thisBoundry-lastBoundry);
	        			SET lastPercent = thisPercent;
    	    			SET lastBoundry = thisBoundry;
       					SET restCommission = (totalSales-thisBoundry)*thisPercent;
					end if;
			
				end LOOP set_commission;	
				CLOSE cur; 

				SET thisCommission =thisCommission+restCommission;

				RETURN thisCommission;
			END //
		DELIMITER ;";

$create.GetItemsLeftFunction = 
		"DROP FUNCTION IF EXISTS `getItemsLeft`;
		DELIMITER //
		CREATE FUNCTION `getItemsLeft`(`product` INT(11), `year` INT(11), `month` INT(11)) 
		RETURNS int(11) NO SQL
			BEGIN
				DECLARE itemsSold, itemsLeft, maxItems int;

				SET itemsSold = (SELECT sum(quantity) FROM sales WHERE product_id = product AND YEAR(sale_date) = year AND MONTH(sale_date) = month);
				SET maxItems = (SELECT maxAmount FROM product WHERE id=product);
				SET itemsLeft = IFNULL(maxItems-itemsSold, maxItems);

				RETURN itemsLeft;
			END //
		DELIMITER ;";


$create.SalesTrigger =
		"DROP TRIGGER IF EXISTS `sales_AINS`;
		DELIMITER //
			CREATE TRIGGER `sales_AINS` AFTER INSERT ON `sales`
 			FOR EACH ROW BEGIN

			DECLARE thisMonth, thisYear, thisIncome int;
			DECLARE thisCommission float;

			SET thisMonth = month(new.sale_date);
			SET thisYear = year(new.sale_date);
			SET thisIncome = (select price from product where id=new.product_id)*new.quantity;
			SET thisCommission = getCommission(thisIncome);

			INSERT INTO report (year_report, month_report ,total_sales, commission) 
						values (thisYear, thisMonth, thisIncome,thisCommission)
						on duplicate key update 
   				 id = new.id,
    			total_sales = total_sales+thisIncome;
    
			END	//
		DELIMITER ;";

$create.ReportTrigger =
		"DROP TRIGGER IF EXISTS `report_BUPD`;
		DELIMITER //
			CREATE TRIGGER `report_BUPD` BEFORE UPDATE ON `report`
 			FOR EACH ROW set new.commission = getCommission(new.total_sales)
			//
		DELIMITER ;";




	mysqli_query($con,$createDatabase);
	mysqli_query($con,$create.City);
//	foreach ($create as $input) {
//	 mysqli_query($con,$input);
//	}

	foreach ($populate as $input) {
	 mysqli_query($con,$input);
	}	


?>