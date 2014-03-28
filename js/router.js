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

      // route for the about page
      .when('/addOrder', {
        templateUrl : 'html/addOrder.html',
        controller  : 'addOrderController'
      })

      // route for the contact page
      .when('/showReport', {
        templateUrl : 'html/showReport.html',
        controller  : 'showReportController'
      });
  });