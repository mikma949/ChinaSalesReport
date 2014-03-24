

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sales Report</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/main.css">
	<script src="js/vendor/modernizr-2.6.2.min.js"></script>


	<!-- Saxat från Calender -->
	<!-- CSS ===================== -->
	<!-- load bootstrap and style-->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style>
		body {
			padding-top: 30px;
		}
	</style>

	<!-- JS ===================== -->
	<!-- load angular -->
	<!--script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.3/angular.min.js"></script-->
	<script type="text/javascript" src="./lib/angular/angular.js"></script>
  	<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.js"></script>
	<script type="text/javascript" src="./lib/ui-utils-0.1.1/ui-utils.js"></script>


	<!-- Load Jquery -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<!--script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script-->
	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>
	<script src="js/mainController.js"></script>
	
</head>
<!-- apply angular app and controller to our body -->
<body ng-app="salesReport" ng-controller="formController">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">

				<!-- PAGE HEADER -->
				<div class="page-header"><h1>Sales Report!</h1></div>

				<!-- FORM -->
				<!-- pass in the variable if our form is valid or invalid -->
				<form name="inputForm" ng-submit="processForm()" method="post">
					<!-- novalidate prevents HTML5 validation since we will be validating ourselves -->

					<!-- DATE -->
					<div class="form-group">
						<label>Date</label>
						<input type="date"
						name="inDate"
						ng-change="getItemsLeft()"
						ng-model="formData.inDate"/>

					</div>

					<!-- SALES PERSON -->
					<div class="form-group">
						<label>Sales person</label>
						<select name="salesPerson" 
						ng-model="formData.salesPerson"
						ng-options="item.id as item.name for item in salesPersons">
						<option value="">Select Person</option>

						</select>

					</div>			

					<!-- CITY -->
					<div class="form-group">
						<label>City</label>
						<select name="city" 
						ng-model="formData.city"
						ng-options="item.id as item.name for item in cities">
						<option value="">Select City</option>

						</select>
					</div>	

					<!-- #LOCKS-->
					<div class="form-group">
						<label>#Locks sold</label>
						<input type="text"
						name="locksSold"
						ng-model="formData.locksSold"> {{itemsLeft}}
					</div>

					<!-- #STOCKS-->
					<div class="form-group">
						<label>#Stocks sold</label>
						<input type="text"
						name="stocksSold"
						ng-model="formData.stocksSold">
					</div>

					<!-- #BARRELS-->
					<div class="form-group">
						<label>#Barrels sold</label>
						<input type="text"
						name="barrelsSold"
						ng-model="formData.barrelsSold">
					</div>

					<!-- SUBMIT BUTTON -->
					<button type="submit" class="btn btn-primary">Submit</button>

				</form><br><br>


				
				<!-- Table containing monthly summary report -->
				<table class="table table-striped table-bordered table-hover table-condensed">
          			<tr>
            			<!-- Create dropdown headers to choose and sort in the table -->
              	    	<th>
            		    <label>Select Year</label><br>
              			<select name="table.year" 
								ng-model="table.year">
						<option value ="">All</option>
						<option	ng-repeat="data in sales|unique:'year_report'"	
								value ="{{data.year_report}}">
							{{data.year_report}}
						</option>
						</th>
            
             	   		<th>
                		<label>Select Month</label><br>
                		<select name="table.month" 
								ng-model="table.month">
						<option value ="">All</option>
						<option	ng-repeat="data in sales|unique:'month_report'"	
								value ="{{data.month_report}}">
							{{data.month_report}}
						</option>
			    		</th>

               			<th>Sales</th>
                		<th>Commission</th>
            		</tr>
            		<!-- Fill the table with data from database and add filters-->
            		<tr data-ng-repeat="data in sales
            		 | filter:{id: table.id} 
           			 | filter:{year_report: table.year}
           			 | filter:{month_report: table.month}">
                		<td>{{data.year_report}}</td>
                		<td>{{data.month_report}}</td>
                		<td>{{data.total_sales}}</td>
                		<td>{{data.commission}}</td>
              		</tr>
        		</table><br>

       		<!-- Testkod  -->
         	
    		</div>
		</div> <!-- col-sm-8 -->
	</div> <!-- /container -->
</body>
</html>
