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
	

	

	$scope.getData = function(){
		//Get salesPersons to show in dropdown
				
		//Get sales data
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=getSales',  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.sales = data;
		});
	};

	

	// Getting the values from the database át startup
	$scope.getData();
	
}
