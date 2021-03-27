<?php
session_start();
if (!isset($_SESSION['email'])) {
header("Location: login.php");
}
error_reporting(0);
// include database and object files
include_once '../databaseA16/database.php';
include_once 'objects/person.php';
  
// get database connection
$pdo = Database::connect();
  
// prepare object
$person = new Person($pdo);

// set page headers
$page_title = "Add Person";
include_once "layout_header.php";
  
// contents will be here
  echo "<div class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-right'>Read Products</a>
    </div>";
?>
<form method='post' action='register_new_user.php'>
    <table class='table table-hover table-responsive table-bordered'>
    
        <tr>
            <td>Email</td>
            <td><input value='<?php echo $_GET ["email"];?>' name='email' type='text' placeholder='admin@admin.com' /></td>
			<td><span.inline style='color: red;'><?php echo $_GET["emailError"];?></span></td>
        </tr>
        
        <tr>
            <td>Password:</td>
            <td><input name='password' type='password' /></td>
			<td><span.inline style='color: red;'><?php echo $_GET["passwordError"];?></span></td>
        </tr>
    
        <tr>
            <td>Reenter Password:</td>
            <td><input name='password2' type='password' /></td>
			<td><span.inline style='color: red;'><?php echo $_GET["password2Error"];?></span></td>
        </tr>
        
        <tr>
            <td>Role:</td>
            <td><select name='role'>
                <option value='User' selected>User</option>
                <option value='Admin'>Admin</option></select></td>
			<td><span.inline style='color: red;'><?php echo $_GET["roleError"];?></span></td>
        </tr>
        
        <tr>
            <td>First Name:</td>
            <td> <input value='<?php echo $_GET ["fname"];?>' name='fname' type='text' placeholder='John' /></td>
			<td><span.inline style='color: red;'><?php echo $_GET["fnameError"];?></span></td>
        </tr>
        
        <tr>
            <td>Last Name:</td>
            <td><input value='<?php echo $_GET ["lname"];?>' name='lname' type='text' placeholder='Doe' /></td>
			<td><span.inline style='color: red;'><?php echo $_GET["lnameError"];?></span></td>
        </tr>
        
        <tr>
            <td>Phone:</td>
            <td><input value='<?php echo $_GET ["phone"];?>' name='phone' type='tel' placeholder='123-456-7890' /></td>
			<td><span.inline style='color: red;'><?php echo $_GET["phoneError"];?></span></td>
        </tr>
        
        <tr>
            <td>Address:</td>
            <td><input value='<?php echo $_GET ["address"];?>' name='address' type='text' placeholder='123 Pine St.' /></td>
	    	<td><span.inline style='color: red;'><?php echo $_GET["addressError"];?></span></td>
        </tr>
        
        <tr>
            <td>Address 2:</td>
            <td><input value='<?php echo $_GET ["address2"];?>' name='address2' type='text' placeholder='456 Oak Rd.' /></td>
            <td></td>
        </tr>
        
        <tr>
            <td>City:</td>
            <td><input value='<?php echo $_GET ["city"];?>' name='city' type='text' placeholder='Saginaw' /></td>
			<td><span.inline style='color: red;'><?php echo $_GET["cityError"];?></span></td>
        </tr>
        
        <tr>
            <td>State:</td>
            <td><input value='<?php echo $_GET ["state"];?>' name='state' type='text' placeholder='MI' /></td>
			<td><span.inline style='color: red;'><?php echo $_GET["stateError"];?></span></td>
        </tr>
        
        <tr>
            <td>Zip Code:</td>
            <td><input value='<?php echo $_GET ["zip_code"];?>' name='zip_code' type='text' placeholder='48607' /></td>
			<td><span.inline style='color: red;'><?php echo $_GET["zipError"];?></span></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Add</button>
            </td>
            <td></td>
        </tr>

    </table>
</form>

<?php
// footer
include_once "layout_footer.php";
?>