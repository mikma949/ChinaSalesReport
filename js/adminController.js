adminController = function($scope, $http) {
$scope.admin = {};



	
	$scope.getData = function(){
		//Get salesPersons to show in dropdown
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=getSalesPersons',  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.admin.salesPersons = data;
		});

		//Get roles to show in dropdown
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=getRoles',  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.admin.roles = data;
		}); 
		
	};

	$scope.updateRole = function(){
		//Update role of chosen person
		
	
		$http({
		method  : 'POST',
		url     : 'php/mySQLqueryhandler.php',
 	   	data    : 'action=updateRole&'+$.param($scope.adminForm),
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
				//Reset the form
				alert("Role has now been updated");
				//console.log(data);
				if (!data.success) {
            		// if not successful, bind errors to error variables
            		//$scope.errorYear = data.errors.year;
            		//$scope.errorSalesPerson = data.errors.salesPerson;
            	} else {
            		// if successful, bind success message to message
            		//$scope.message = data.message;
            		alert("Error in sending to database")
            	}

            }); 
	}
$scope.getData();
}