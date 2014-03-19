

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
	<!--script type="text/javascript" 
	src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js"> </script-->     
	<script type="text/javascript" src="./lib/angular/angular.js"></script>

	<!-- Load Ajax -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<!--script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script-->
	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>
	<script src="js/mainController.js"></script>
	
</head>
<!-- apply angular app and controller to our body -->
<body ng-app="salesReport" ng-controller="formController">
	<div class="container">
		<div class="container">
			<div class="col-sm-8 col-sm-offset-2">

				<!-- PAGE HEADER -->
				<div class="page-header"><h1>Sales Report!</h1></div>

					<!-- FORM -->
					<!-- pass in the variable if our form is valid or invalid -->
					<form name="inputForm" ng-submit="processForm()" method="post">
						<!-- novalidate prevents HTML5 validation since we will be validating ourselves -->

						<!-- Year -->
						<div class="form-group">
							<label>Year</label>
							<input type="date"
							name="year"
							ng-model="formData.year" />
							
						</div>

						<!-- SALES PERSON -->
						<div class="form-group">
							<label>Sales person</label>
							<input type="text"
							name="salesPerson"
							ng-model="formData.salesPerson" />
						
						</div>

						<!-- CITY-->
						<div class="form-group">
							<label>City</label>
							<input type="text"
							name="city"
							ng-model="formData.city">
						</div>

						<!-- #LOCKS-->
						<div class="form-group">
							<label>#Locks sold</label>
							<input type="text"
							name="locksSold"
							ng-model="formData.locksSold">
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
						<button type="submit"
						class="btn btn-primary"
						>Submit</button>


					</form>
					<h2 ng-repeat="item in sales">
						Locks Sold {{item.locksSold}}<br>
						Stocks Sold {{item.stocksSold}}<br>
						Barrels Sold {{item.barrelsSold}}<br>

					</h2>
					{{test}}
				</div>
				<!-- col-sm-8 -->
			</div>
			<!-- /container -->



		</body>
		</html>
