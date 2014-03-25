/**
* salesReport Module
*
* Description
*/

var app = angular.module('salesReport', ['ui.utils','ui.bootstrap']);

// create angular controller and pass in $scope and $http
formController = function($scope, $http) {
	// create a blank object to hold our form information
	// $scope will allow this to pass between controller and view
	$scope.formData = {};
	$scope.salesPersons = {};
	$scope.cities = {};
	$scope.itemsLeft ={};
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

		if($scope.isFormValid($scope.formData)){
			alert("form is valid");
			return;
		} else {
			alert("form is NOT valid");
			return;
		};


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
				$scope.getItemsLeft();

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

	$scope.isFormValid = function(formData){
		var totLocksSold = 20;		//get data from DB
		var totBarrelsSold = 20;	//get data from DB
		var totStocksSold = 20;		//get data from DB
		$scope.errorToManyLocks = "";
		$scope.errorToManyStocks = "";
		$scope.errorToManyBarrels = "";
		$scope.errorWrongDate = "";

		
		if(formData.locksSold <= totLocksSold &&
			formData.stocksSold <= totStocksSold &&
			formData.barrelsSold <= totBarrelsSold &&
			$scope.isDateValid(formData.inDate)){
			return true;
		} else {
			if(formData.locksSold > totLocksSold){
				$scope.errorToManyLocks = 
				"You can't sell these many locks";
			}
			if(formData.stocksSold > totStocksSold){
				$scope.errorToManyStocks = 
				"You can't sell these many stocks";
			}
			if(formData.barrelsSold > totBarrelsSold){
				$scope.errorToManyBarrels = 
				"You can't sell these many barrels";	
			}
			if (!$scope.isDateValid(formData.inDate)) {
				$scope.errorWrongDate =
				"Invalid date";
			};
			return false;
		};


	};

	//check if date is valid
	$scope.isDateValid = function(date){
		
		
		var year = date.slice(0,4);
		var month = date.slice(4,6);
		var day = date.slice(6,8);

		if (year > 1999 && year < 2151) {
			if (month > 0 && month < 13) {

				var daysInMonth = $scope.daysInMonth(month, year);

				if (day > 0 && day <= daysInMonth) {
					return true;
				} else {
					return false;	
				};

			} else {
				return false;
			};
		} else {
			return false;
		};
	};

	//returns number of days in given mounth
	//must check that the month is > 0 and < 13 before
	$scope.daysInMonth = function(inmonth, inyear) {

        var isleap = $scope.isLeapYear(inyear);
        switch (Number(inmonth)) {
        case 2:

            if (isleap){
                return 29;
            } else {
            	return 28;
            };
            break;
        case 4:
        case 6:
        case 9:
        case 11:
        	return 30;
            break;
        default:
        	return 31;
        }
    }

    //check if the year is a leap year
    $scope.isLeapYear = function(inyear) { 
        var leap = false;
        if (inyear % 4 == 0) { 
            leap = true;
            if (inyear > 1582) {
                if ( inyear % 100 == 0 && inyear % 400 != 0) {
                    leap = false;
                };
            };
        };
        return leap;
    }

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

$scope.getItemsLeft = function(){
	//Get amount of items left to sell to show at insert
		$http({
		method  : 'POST',
		url     : 'mySQLqueryhandler.php',
 	   	data    : 'action=getItemsLeft&'+$.param($scope.formData),  // pass in data as strings
  		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		})
		.success(function(data) {
			$scope.itemsLeft = data;
		});
}

	// Getting the values from the database át startup
	$scope.getData();
	
};
