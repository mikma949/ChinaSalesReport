showReportController = function($scope, $http) {
		// create a blank object to hold our form information
	// $scope will allow this to pass between controller and view
	$scope.months =[{nameOfMonth:"All",number:""},{nameOfMonth:"January",number:"1"},
					{nameOfMonth:"Febuary",number:"2"},{nameOfMonth:"March",number:"3"},
					{nameOfMonth:"April",number:"4"},{nameOfMonth:"May",number:"5"},
					{nameOfMonth:"June",number:"6"},{nameOfMonth:"July",number:"7"},
					{nameOfMonth:"August",number:"8"},{nameOfMonth:"September",number:"9"},
					{nameOfMonth:"October",number:"10"},{nameOfMonth:"November",number:"11"},
					{nameOfMonth:"December",number:"12"},];
	$scope.report ={};	
	

	$scope.getData = function(){
		//Get salesPersons to show in dropdown
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=getSalesPersons',  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.report.salesPersons = data;
		});

		//Get cities to show in dropdown
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=getCities',  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.report.cities = data;
		});
				
		//Get years that a sale has occured
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=getYear',  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.report.year = data;
		});

	};
	$scope.getMonths = function(){
		//Get months that a sale has occured
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=getMonth&'+$.param($scope.reportForm),  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.report.month = data;
		}); 

	}
	$scope.getSales = function(){
		//Get the total of the month
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=getSales&'+$.param($scope.reportForm),  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.report.sales = data;

		});
		//Get the sales per person of the month
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=getPersonalSales&'+$.param($scope.reportForm),  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.report.personalSales = data;
		});

		//Get the sales per city of the month
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=getCitySales&'+$.param($scope.reportForm),  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.report.citySales = data;

		});
		//Get the number of items sold per person of the month
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=getItemsSold&'+$.param($scope.reportForm),  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.report.itemsSold = data;
			$scope.controllCommission();
			$scope.setTotalCommision();
		});
	}

	//Controlls if a full rifle is sold. If not sets the commission to 0. 
	$scope.controllCommission = function(){
		$soldFullRifle = {};
		for (var i = 0; i < $scope.report.personalSales.length; i++) {
			$soldFullRifle[i] = parseInt($scope.report.itemsSold[3*i].itemsSold)*
								parseInt($scope.report.itemsSold[3*i +1].itemsSold)*
								parseInt($scope.report.itemsSold[3*i +2].itemsSold);
			if(parseInt($soldFullRifle[i])==0){
				$scope.report.personalSales[i].commission =0;
			}
		};
	}

	// Adds upp the commissions of the current month and year.
	$scope.setTotalCommision = function(){
		$scope.report.totalCommission =0;
		for (var i = 0; i < $scope.report.personalSales.length; i++) {
			$scope.report.totalCommission += parseInt($scope.report.personalSales[i].commission);
		};
	}

	// Getting the values from the database át startup
	$scope.getData();
	
}
