<?php include($_SERVER['DOCUMENT_ROOT'].
'/ChinaSalesReport/php/base.php');

// Check if you are logged in
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
// Check that user have role 3 or 4
if($_SESSION['Role'] > 2)
{
?>

<div ng-controller="showReportController">
	<!-- Inputform to set year and month to collect report -->
	<div>
		<select name="reportForm.year" 
				ng-model="reportForm.year"
				ng-change="getMonths()">
			<option value ="">Select year</option>
			<option	ng-repeat="data in report.year |unique:'year'"		
					value ="{{data.year}}">
								{{data.year}}
			</option>
		</select>

		<select name="reportForm.month" 
				ng-model="reportForm.month"
				ng-change="getSales()">
			<option value ="">Select month</option>
			<option	ng-repeat="data in report.month |unique:'month'"
					value ="{{data.month}}">
								{{data.month}}
			</option>
		</select>
	</div>
	<!-- Show the total sales and commission  -->
	<h1>Total sales this month: {{report.sales.total}}</h1><br>
	<h1>Total commission this month: {{report.totalCommission}}</h1><br>

	<!-- Show the monthly sales per person -->
	<table >
	    <tr>
	        <th><h3>Name</h3></th>
			<th><h3>Sales</h3></th>
	        <th><h3>Commission</h3></th>
	        <th><h3>Locks</h3></th>
	        <th><h3>Stocks</h3></th>
	        <th><h3>Barrels</h3></th>
	    </tr>
		<!-- Fill the table with data from database and add filters-->
		<tr data-ng-repeat="person in report.personalSales">
			<td><h4>{{person.name}}</h4></td>
			<td>{{person.sales}}</td>
			<td>{{person.commission}}</td>
			<td>{{report.itemsSold[$index*3].itemsSold}}</td>
			<td>{{report.itemsSold[$index*3+1].itemsSold}}</td>
			<td>{{report.itemsSold[$index*3+2].itemsSold}}</td>
			</tr>
	</table>
	<br>


	<!-- Show the monthly sales per city -->
	<table >
	    <tr>
	        <th><h3>City</h3></th>
			<th><h3>Sales</h3></th>
	    </tr>
		<!-- Fill the table with data from database and add filters-->
		<tr data-ng-repeat="city in report.citySales">
			<td><h4>{{city.name}}</h4></td>
			<td>{{city.sales}}</td>
		</tr>
</table>
</div>

<?php
//If user dont have high enuch role
} else {
	?>
	<p>You do not have permission view this page</p>
	<?php
}
?>


<?php
//If user is not logged in
} else {
	?>
	<p>You have to be logged in to view this page. Log in <a href="index.php">here.</a></p>
	<?php
}
?>