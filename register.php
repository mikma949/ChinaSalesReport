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


</head>  
<body>  
<div id="registerMainDiv">
<?php
if(!empty($_POST['username']) && !empty($_POST['password']))
{
	$username = mysql_real_escape_string($_POST['username']);
    $password = md5(mysql_real_escape_string($_POST['password']));
    
	 $checkusername = mysql_query("SELECT * FROM sales_person WHERE name = '".$username."'");
     
     if(mysql_num_rows($checkusername) == 1)
     {
     	echo "<h1>Error</h1>";
        echo "<p>Sorry, that username is taken. Please go back and try again.</p>";
     }
     else
     {
     	$registerquery = mysql_query("INSERT INTO sales_person (name, password, role) VALUES('".$username."', '".$password."', '1')");
        if($registerquery)
        {
        	echo "<h1>Success</h1>";
        	echo "<p>Your account was successfully created. Please <a href=\"index.php\">click here to login</a>.</p>";
        }
        else
        {
     		echo "<h1>Error</h1>";
        	echo "<p>Sorry, your registration failed. Please go back and try again.</p>";    
        }    	
     }
}
else
{
	?>
    
   <h1>Register</h1>
    
   <p>Please enter your details below to register.</p>
    
	<form method="post" action="register.php" name="registerform" id="registerform">
	<fieldset>
		<label class="registerLable" for="username">Username:</label>
        <input type="text" name="username" id="username" /><br />
		<label class="registerLable" for="password">Password:</label>
        <input type="password" name="password" id="password" /><br />
        <input type="submit" name="register" id="register" value="Register" />
	</fieldset>
	</form>
    
    <?php
}
?>

</div>
</body>
</html>