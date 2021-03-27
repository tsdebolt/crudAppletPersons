<?php
session_start();
if (!isset($_SESSION['email'])) {
header("Location: login.php");
}

error_reporting(0);
// get ID of the person to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../databaseA16/database.php';
include_once 'objects/person.php';
  
// get database connection
$pdo = Database::connect();
  
// prepare object
$person = new Person($pdo);
  
// set ID property of person to be read
$person->id = $id;
  
// read the details of person to be read
$person->readOne();

// set page headers
$page_title = "Read One Person";
include_once "layout_header.php";
  
// read person button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> User List";
    echo "</a>";
echo "</div>";
 
 // HTML table for displaying a Person details
echo "<table class='table table-hover table-responsive table-bordered'>";
  
    echo "<tr>";
        echo "<td>Email</td>";
        echo "<td>{$person->email}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Role</td>";
        echo "<td>{$person->role}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>First Name</td>";
        echo "<td>{$person->fname}</td>";
    echo "</tr>";
  
	echo "<tr>";
        echo "<td>Last Name</td>";
        echo "<td>{$person->lname}</td>";
    echo "</tr>";
	
	echo "<tr>";
        echo "<td>Phone Number</td>";
        echo "<td>{$person->phone}</td>";
    echo "</tr>";
	
	echo "<tr>";
        echo "<td>City</td>";
        echo "<td>{$person->city}</td>";
    echo "</tr>";
	
	echo "<tr>";
        echo "<td>State</td>";
        echo "<td>{$person->state}</td>";
    echo "</tr>";
	
	echo "<tr>";
        echo "<td>Zip Code</td>";
        echo "<td>{$person->zip_code}</td>";
    echo "</tr>";
	
	echo "<tr>";
        echo "<td>Address</td>";
        echo "<td>{$person->address}</td>";
    echo "</tr>";
    
    echo "<tr>";
        echo "<td>Address 2</td>";
        echo "<td>{$person->address2}</td>";
    echo "</tr>";
	
echo "</table>";

// set footer
include_once "layout_footer.php";
?>