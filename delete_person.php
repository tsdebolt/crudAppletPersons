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

$page_title = "Delete Person";
include_once "layout_header.php";
echo "<div class='right-button-margin'> <a href='index.php' 
class='btn btn-default pull-right'>Return</a></div>";

if ($person->id == $temp->id || strcmp($temp->role, "User") == 0){
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "You do not have permission to delete this user.";
        echo "</div>";
}
?>

<?php
    if($_POST){
    
    //$person->fname = $_POST['fname'];
    //$person->lname = $_POST['lname'];

        // delete the product
        if($person->delete()){
             echo "<div class='alert alert-success alert-dismissable'>";
             echo "Person was Deleted.";
             echo "</div>";
        }
      
        // if unable to delete the product
        else{
             echo "<div class='alert alert-danger alert-dismissable'>";
             echo "Unable to delete person.";
             echo "</div>";
        }
    }
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        
        <tr>
            <td>First Name</td>
            <td><input type='text' name='fname' value='<?php echo $person->fname; ?>' class='form-control' readonly/></td>
        </tr>
        
        <tr>
            <td>Last Name</td>
            <td><input type='text' name='lname' value='<?php echo $person->lname; ?>' class='form-control' readonly/></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <?php
                if ($person->id <> $temp->id && strcmp($temp->role, "User") <> 0){
                    echo'<button type="submit" class="btn btn-primary">Delete</button>';
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
