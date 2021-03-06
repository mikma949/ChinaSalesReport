<?php include "php/base.php"; ?>

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
	<link rel="stylesheet" href="css/app.css">
	<script src="js/vendor/modernizr-2.6.2.min.js"></script>

	<!-- CSS ===================== -->
	<!-- load bootstrap and style-->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	
	<!-- JS ===================== -->
	<!-- load angular -->
	<!--script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.3/angular.min.js"></script-->
	<script type="text/javascript" src="./lib/angular/angular.min.js"></script>

	<!-- load angular-ui bootstrap -->
	<!--script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.js"></script-->
  	<script src="lib/angularUI/ui-bootstrap-tpls-0.10.0.min.js"></script>

  	<!-- load ui-utils -->
	<script type="text/javascript" src="./lib/ui-utils-0.1.1/ui-utils.js"></script>

	<!-- load angular-route -->
	<!--script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.10/angular-route.js"></script-->
	<script type="text/javascript" src="./lib/angular/angular-route.min.js"></script>

	<!-- Load Jquery -->
	<script src="lib/jquery.min.js"></script>
	<!--script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script-->

	<!-- load controllers and injections -->
	<script src="js/plugins.js"></script>
	<script src="js/app.js" type="text/javascript"></script>
	<script src="js/addOrderController.js" type="text/javascript"></script>
	<script src="js/showReportController.js" type="text/javascript"></script>
	<script src="js/adminController.js" type="text/javascript"></script>
	<script src="js/router.js" type="text/javascript"></script>
	
</head>
<!-- apply angular app and controller to our body -->
<body ng-app="salesReport">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<div name="titleHeader">

					<?php
					// If logged in, show main page
					if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
					{
						 ?>
						 <p id="welcomeText"> You are logged in as 
						 <code class="varFromSessionToFront"><?=$_SESSION['Username']?></code> 
						 and you are role <code class="varFromSessionToFront"><?=$_SESSION['Role']?></code>. 
						 </p>
					     
					     

					    <?php
					}
					?>






				<!-- PAGE HEADER -->
					<header class="page-header"><h1>Missouri Gunsmith Sales Report</h1>
						<a id="logOutLink" href="logout.php">Log out.</a><br>
					
						<ul class="nav navbar-nav navbar-left">
							<li>
								<a href="#addOrder">
									<i  name="navLink"></i> Sale
								</a>
							</li>
							<li>
								<a href="#showReport" name="navLink">
									<i ></i> Report
								</a>
							</li>
							<li>
								<a href="#admin" name="navLink">
									<i ></i> Admin
								</a>
							</li>
						</ul>
					</header>
				</div>
				<!-- här ska routern in-->
				<div>
				<ng-view>	</ng-view>
				</div>
				
			

       		
         	
    		</div>
		</div> <!-- col-sm-8 -->
	</div> <!-- /container -->

</body>
</html>
