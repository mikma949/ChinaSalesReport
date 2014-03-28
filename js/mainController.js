// create angular controller and pass in $scope and $http
addOrderController = function($scope, $http) {
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
		$scope.getItemsLeft();
		if($scope.isFormValid($scope.formData)){
			$scope.send();
		} else {
			// Error messages will show what fields were incorrect.
		};

	};

	$scope.send = function(){
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
				$scope.getItemsLeft();
				$scope.getData();
				alert("Added: \n " 
						+$scope.formData.locksSold +" locks, \n"
						+$scope.formData.stocksSold +" stocks \n"
						+$scope.formData.barrelsSold +" barrels \n"
						+"to this months sales");
				//Reset the form
				$scope.formData.locksSold=null;
				$scope.formData.stocksSold=null;
				$scope.formData.barrelsSold=null;
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

	$scope.isFormValid = function(formData){
		$scope.getItemsLeft();

		$scope.errorTooManyLocks = "";
		$scope.errorTooManyStocks = "";
		$scope.errorTooManyBarrels = "";
		$scope.errorWrongDate = "";

		var totLocksLeft = Number($scope.itemsLeft.locks);		//get data from DB
		var totStocksLeft = Number($scope.itemsLeft.stocks);	//get data from DB
		var totBarrelsLeft = Number($scope.itemsLeft.barrels);	//get data from DB

		var locksToSell = Number(formData.locksSold);
		var stocksToSell = Number(formData.stocksSold);
		var barrelsToSell = Number(formData.barrelsSold);

			
		if(locksToSell <= totLocksLeft &&
			stocksToSell <= totStocksLeft &&
			barrelsToSell <= totBarrelsLeft &&
			$scope.isDateValid(formData.inDate)){
			return true;
		} else {
			if(locksToSell > totLocksLeft){
				$scope.errorTooManyLocks = 
				"You can't sell this many locks";
			}
			if(stocksToSell > totStocksLeft){
				$scope.errorTooManyStocks = 
				"You can't sell this many stocks";
			}
			if(barrelsToSell > totBarrelsLeft){
				$scope.errorTooManyBarrels = 
				"You can't sell this many barrels";	
			}
			if (!$scope.isDateValid(formData.inDate)) {
				$scope.errorWrongDate =
				"Invalid date";
			};
			return false;
		};


	};

	$scope.getTodaysDate = function(){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
    		dd='0'+dd
		} 

		if(mm<10) {
 		   mm='0'+mm
		} 

		today = yyyy+''+mm+''+dd;
		return today;
	}

	//check if date is valid
	$scope.isDateValid = function(indate){
		date = String(indate);
		if(date.length < 8){
			return true;
		}else{
		
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
	}
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
	$scope.getItemsLeft();
	
};

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
	
}
