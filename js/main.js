/**
* salesReport Module
*
* Description
*/
var app = angular.module('salesReport', []);

// create angular controller and pass in $scope and $http
function formController($scope, $http) {
	// create a blank object to hold our form information
	// $scope will allow this to pass between controller and view
	$scope.formData = {};
	$scope.sales = {};
	
	// process the form
	$scope.processForm = function() {
		$http({
		method  : 'POST',
		url     : 'sent.php',
       	data    : 'action=send&'+$.param($scope.formData),  // pass in data as strings
        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
    	})
			.success(function(data) {
				console.log(data);
			
				if (!data.success) {
            		// if not successful, bind errors to error variables
            		$scope.errorYear = data.errors.year;
            		$scope.errorSalesPerson = data.errors.salesPerson;
            	} else {
            		// if successful, bind success message to message
            		$scope.message = data.message;
            	}

            	// Getting the database with the new input
            	$scope.getData();
            });
	};

	$scope.getData = function(){
		$http({
		method  : 'POST',
		url     : 'sent.php',
 	   	data    : 'action=get',  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.sales = data;
		});
	};

	// Getting the values from the database át startup
	$scope.getData();
	
};

