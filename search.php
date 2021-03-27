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
  
// get search term
$search_term=isset($_GET['s']) ? $_GET['s'] : '';
  
$page_title = "You searched for \"{$search_term}\"";
include_once "layout_header.php";
  
// query products
$stmt = $person->search($search_term, $from_record_num, $records_per_page);
  
// specify the page where paging is used
$page_url="search.php?s={$search_term}&";
  
// count total rows - used for pagination
$total_rows=$person->countAll_BySearch($search_term);
  
// read_template.php controls how the person list will be rendered
include_once "read_template.php";
  
// layout_footer.php holds our javascript and closing html tags
include_once "layout_footer.php";
?>