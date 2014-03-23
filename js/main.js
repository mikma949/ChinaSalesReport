/**
* salesReport Module
*
* Description
*/
var app = angular.module('salesReport', ['ui.utils']);

// create angular controller and pass in $scope and $http
formController = function($scope, $http) {
	// create a blank object to hold our form information
	// $scope will allow this to pass between controller and view
	$scope.formData = {};
	$scope.salesPersons = {};
	$scope.cities = {};
	$scope.years= {};
	$scope.months={};
	$scope.months =[{nameOfMonth:"All",number:""},{nameOfMonth:"January",number:"1"},
					{nameOfMonth:"Febuary",number:"2"},{nameOfMonth:"March",number:"3"},
					{nameOfMonth:"April",number:"4"},{nameOfMonth:"May",number:"5"},
					{nameOfMonth:"June",number:"6"},{nameOfMonth:"July",number:"7"},
					{nameOfMonth:"August",number:"8"},{nameOfMonth:"September",number:"9"},
					{nameOfMonth:"October",number:"10"},{nameOfMonth:"November",number:"11"},
					{nameOfMonth:"December",number:"12"},];


	// process the form
	$scope.processForm = function() {
		$scope.formData.locks = 1;
		$scope.formData.stocks = 2;
		$scope.formData.barrels = 3;

		$http({
		method  : 'POST',
		url     : 'mySQLqueryhandler.php',
       	data    : 'action=send&'+$.param($scope.formData),  // pass in data as strings
        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
    	})
			.success(function(data) {
				
				//console.log(data);
				
				if (!data.success) {
            		// if not successful, bind errors to error variables
            		//$scope.errorYear = data.errors.year;
            		//$scope.errorSalesPerson = data.errors.salesPerson;
            	} else {
            		// if successful, bind success message to message
            		//$scope.message = data.message;
            	}

            	// Getting the database with the new input
            	$scope.getData();
            }); 
	};

	$scope.getData = function(){
		//Get salesPersons to show in dropdown
		$http({
		method  : 'POST',
		url     : 'mySQLqueryhandler.php',
 	   	data    : 'action=getSalesPersons',  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.salesPersons = data;
		});

		//Get cities to show in dropdown
		$http({
		method  : 'POST',
		url     : 'mySQLqueryhandler.php',
 	   	data    : 'action=getCities',  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.cities = data;
		});

		//Get sales data
		$http({
		method  : 'POST',
		url     : 'mySQLqueryhandler.php',
 	   	data    : 'action=getSales',  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.sales = data;
		});
	};

	// Getting the values from the database át startup
	$scope.getData();
	
};
