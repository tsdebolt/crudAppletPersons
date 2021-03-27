<?php
session_start();
if (!isset($_SESSION['email'])) {
header("Location: login.php");
}

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

error_reporting(0);
// core.php holds pagination variables
include_once 'config/core.php';
  
// include database and object files
include_once '../databaseA16/database.php';
include_once 'objects/person.php';
  
// get database connection
$pdo = Database::connect();
  
// prepare object
$person = new Person($pdo);
 
//Session user
$temp = new Person($pdo);
$temp->getID();
$temp->readOne();

// set ID property of person to be edited
$person->id = $id;

// read the details of person to be edited
$person->readOne();

$page_title = "Update Person";
include_once "layout_header.php";
echo "<div class='right-button-margin'> <a href='index.php' 
class='btn btn-default pull-right'>User List</a></div>";

if ($person->id <> $temp->id && strcmp($temp->role, "User") == 0){
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "You do not have permission to update this user.";
        echo "</div>";
}
?>

<?php 
// if the form was submitted
if($_POST){
  
    // set person property values
    $person->role = $_POST['role'];
    $person->fname = $_POST['fname'];
    $person->lname = $_POST['lname'];
    $person->phone = $_POST['phone'];
    $person->address = $_POST['address'];
    $person->address2 = $_POST['address2'];
    $person->city = $_POST['city'];
    $person->state = $_POST['state'];
    $person->zip_code = $_POST['zip_code'];
    
    // update the person
    if($person->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Person was updated.";
        echo "</div>";
    }
  
    // if unable to update the person, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update person.";
        echo "</div>";
    }
}
?>
  
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        
        <tr>
            <td>Role</td>
            <td><input type='text' name='role' value='<?php echo $person->role; ?>' class='form-control' readonly /></td>
        </tr>
        
        <tr>
            <td>First Name</td>
            <td><input type='text' name='fname' value='<?php echo $person->fname; ?>' class='form-control' /></td>
        </tr>
        
        <tr>
            <td>Last Name</td>
            <td><input type='text' name='lname' value='<?php echo $person->lname; ?>' class='form-control' /></td>
        </tr>
        
        <tr>
            <td>Phone Number</td>
            <td><input type='text' name='phone' value='<?php echo $person->phone; ?>' class='form-control' /></td>
        </tr>
        
        <tr>
            <td>Address</td>
            <td><input type='text' name='address' value='<?php echo $person->address; ?>' class='form-control' /></td>
        </tr>
        
        <tr>
            <td>Address 2</td>
            <td><input type='text' name='address2' value='<?php echo $person->address2; ?>' class='form-control' /></td>
        </tr>
        
        <tr>
            <td>City</td>
            <td><input type='text' name='city' value='<?php echo $person->city; ?>' class='form-control' /></td>
        </tr>
        
        <tr>
            <td>State</td>
            <td><input type='text' name='state' value='<?php echo $person->state; ?>' class='form-control' /></td>
        </tr>
        
        <tr>
            <td>Zip Code</td>
            <td><input type='text' name='zip_code' value='<?php echo $person->zip_code; ?>' class='form-control' /></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <?php
                if ($person->id == $temp->id || strcmp($temp->role, "Admin") == 0){
                    echo'<button type="submit" class="btn btn-primary">Update</button>';
                }
                ?>
            </td>
        </tr>
  
    </table>
</form>
  
<?php  
// set page footer
include_once "layout_footer.php";
?>