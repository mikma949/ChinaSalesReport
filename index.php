<?php include "php/base.php"; ?>

<!DOCTYPE html PUBLIC>
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Login</title>

<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/app.css">

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

<link rel="stylesheet" type="text/css" href="css/style.css">

<!-- JS ===================== -->
    <!-- load angular -->
    <!--script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.3/angular.min.js"></script-->
    <script type="text/javascript" src="./lib/angular/angular.min.js"></script>

</head>  
<body ng-app="salesReport">  
<div id="loginMainDiv">

<?php
// If logged in, show main page
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    header("Location: index2.php");
    exit;
}
// If not logged in, show loggin page
elseif(!empty($_POST['username']) && !empty($_POST['password']))
{
	$username = mysql_real_escape_string($_POST['username']);
    $password = md5(mysql_real_escape_string($_POST['password']));
    
	$checklogin = mysql_query("SELECT * FROM sales_person WHERE name = '".$username."' AND password = '".$password."'");
    
    if(mysql_num_rows($checklogin) == 1)
    {
        $row = mysql_fetch_array($checklogin);
        $role = $row['role'];
    	
        $_SESSION['Username'] = $username;
        $_SESSION['LoggedIn'] = 1;
        $_SESSION['Role'] = $role;
        
    	echo "<h1>Success</h1>";
        echo "<p>We are now redirecting you to the member area.</p>";
        echo "<meta http-equiv='refresh' content='=2;index.php' />";
        header("Location: index2.php");
        exit;
    }
    else
    {
    	echo "<h1>Error</h1>";
        echo "<p>Sorry, your account could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
    }
}
else
{
	?>
    
   <h1>Member Login</h1>
    
   <p>Thanks for visiting! Please either login below, or <a href="register.php">click here to register</a>.</p>
    
	<form method="post" action="index.php" name="loginform" id="loginform">
	<fieldset>
		<label class ="loginLabel" for="username">Username:</label><input type="text" name="username" id="username" /><br />
		<label class ="loginLabel" for="password">Password:</label><input type="password" name="password" id="password" /><br />
		<input type="submit" name="login" id="login" value="Login" />
	</fieldset>
	</form>
    
   <?php
}
?>

</div>
</body>
</html>