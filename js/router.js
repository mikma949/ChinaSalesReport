//Define Routing for app
//Uri /AddNewOrder -> template addOrder.html and Controller AddOrderController
//Uri /ShowOrders -> template showReport.html and Controller showReportController

app.config(function($routeProvider) {
    $routeProvider

      // route for the home page
     /* .when('/', {
        templateUrl : 'index.html',
        controller  : 'mainController'
      })*/

      // route for the add order page
      .when('/addOrder', {
        templateUrl : 'html/addOrder.php',
        controller  : 'addOrderController'
      })

      // route for the admin page
      .when('/admin', {
        templateUrl : 'html/admin.php',
        controller  : 'adminController'
      })

      // route for the show report page
      .when('/showReport', {
        templateUrl : 'html/showReport.php',
        controller  : 'showReportController'
      });
  });