<?php include($_SERVER['DOCUMENT_ROOT'].
'/ChinaSalesReport/php/base.php'); 

// Check if you are logged in
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{

// Check that user have role 4
if($_SESSION['Role'] > 3)
{
?>
<form name="adminFormData"
	ng-controller="adminController"
	ng-submit="updateRole()"
	method="post"
	novalidate >

	<div class="form-group">
			<!-- SALES PERSON -->
		<div class="form-group">
			<label>Sales person</label><br>
			<select	name="salesPerson" 
			ng-model="adminForm.salesPerson"
			ng-options="person.id as person.name for person in admin.salesPersons"
			required>
			<option value="">Select Person</option>
			</select>
		</div>
		<div class="form-group">
			<label>Role</label><br>
			<select	name="role" 
			ng-model="adminForm.role"
			ng-options="role.id as role.position for role in admin.roles"
			required>
			<option value="">Select Role</option>
			</select>
		</div>
	</div>

	<div>
		<button type="submit" class="btn btn-primary"
		ng-disabled="!(	!!adminForm.salesPerson && 
					!!adminForm.role)"
				>Update role</button>
	</div>
</form>
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