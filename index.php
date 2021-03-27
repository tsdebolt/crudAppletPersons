<?php
session_start();
if (!isset($_SESSION['email'])) {
header("Location: login.php");
}

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
  
$page_title = "Show People";
include_once "layout_header.php";
  
// query products
$stmt = $person->readAll($from_record_num, $records_per_page);

// specify the page where paging is used
$page_url = "index.php?";
  
// count total rows - used for pagination
$total_rows=$person->countAll();
  
// read_template.php controls how the person list will be rendered
include_once "read_template.php";
  
// layout_footer.php holds our javascript and closing html tags
include_once "layout_footer.php";
?>