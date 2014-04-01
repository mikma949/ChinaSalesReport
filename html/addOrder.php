<?php include($_SERVER['DOCUMENT_ROOT'].
'/ChinaSalesReport/php/base.php'); 

// Check if you are logged in
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{

// Check that user have role 2, 3 or 4
if($_SESSION['Role'] > 1)
{
?>

<!-- FORM -->
<!-- pass in the variable if our form is valid or invalid -->
<div>
	<form name="inputForm" 
	 	ng-controller="addOrderController"
		ng-submit="processForm()"
		method="post" 
		novalidate>
		<!-- novalidate prevents HTML5 validation since we will be validating ourselves -->


		<!-- DATE -->
		<div class="form-group">
			<label>Date</label><br>
			<input type="text"
			name="inDate"
			ng-model="formData.inDate" 
			required
			ui-mask="{{'9999-99-99'}}"
			placeholder="yyyy-mm-dd"
			ng-change="getItemsLeft()"/><br>
			<p class="help-block">{{errorWrongDate}}</p>
		</div>

		<!-- SALES PERSON -->
		<div class="form-group">
			<label>Sales person</label><br>
			<select	name="salesPerson" 
			ng-model="formData.salesPerson"
			ng-options="item.id as item.name for item in salesPersons"
			required>
			<option value="">Select Person</option>
			</select>
		</div>			

		<!-- SALES City -->
		<div class="form-group">
			<label>City</label><br>
			<select name="city" 
			ng-model="formData.city"
			ng-options="item.id as item.name for item in cities"
			required>
			<option value="">Select City</option>
			</select>
		</div>	

		<!-- #LOCKS-->
		<div class="form-group">
			<label>Locks sold</label><br>
			<input type="text"
			name="locksSold"
			ng-model="formData.locksSold"
			ng-pattern="/^[0-9]*$/"
				required><br>

				<!-- Error messages -->
    		<p ng-show="inputForm.locksSold.$error.pattern" 
    			class="help-block">Only numbers</p>
    		<p class="help-block">{{errorTooManyLocks}}</p>
		</div>

		<!-- #STOCKS-->
		<div class="form-group">
			<label>Stocks sold</label><br>
			<input type="text"
			name="stocksSold"
			ng-model="formData.stocksSold"
			ng-pattern="/^[0-9]*$/" 
				required> <br>

		 		<!-- Error messages -->
		 		<p ng-show="inputForm.stocksSold.$error.pattern" 
				class="help-block">Only numbers</p>
		    <p ng-show="inputForm.stocksSold.$error.maxlength" 
			    class="help-block">Input too long</p>
    		<p class="help-block">{{errorTooManyStocks}}</p>
		</div>

		<!-- #BARRELS-->
		<div class="form-group">
			<label>Barrels sold</label><br>
			<input type="text"
			name="barrelsSold"
			ng-model="formData.barrelsSold"
	   		ng-pattern="/^[0-9]*$/" 
				required> <br>

         		<!-- Error messages -->
         		<p ng-show="inputForm.barrelsSold.$error.pattern" 
			    class="help-block">Only numbers</p>
		    <p ng-show="inputForm.barrelsSold.$error.maxlength" 
				class="help-block">Input too long</p>
			<p class="help-block">{{errorTooManyBarrels}}</p>        
		</div>
		<br>

		<!-- SUBMIT BUTTON -->
		<div class="form-group">
			<button type="submit" class="btn btn-primary"
				ng-disabled="!(	!!formData.barrelsSold && 
					!!formData.stocksSold && 
					!!formData.locksSold  && 
					!!formData.inDate && 
					!!formData.salesPerson && 
					!!formData.city)">Submit</button>

		</div>
	</form>
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
} else {
	?>
	<p>You have to be logged in to view this page. Log in <a href="index.php">here.</a></p>
	<?php
}
?>