<?php
session_start();
if (!isset($_SESSION['email'])) {
header("Location: login.php");
}
error_reporting(0);
# 1. connect to database
require '../databaseA16/database.php';
$pdo = Database::connect();
$pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{16,32}$/';

# 2. assign user info to a variable
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$role = $_POST['role'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];
$address = $_POST['address'];
$address2 = $_POST['address2'];

$emailError = "";
$passwordError = "";
$password2Error = "";
$roleError = "";
$fnameError = "";
$lnameError = "";
$phoneError = "";
$cityError = "";
$stateError = "";
$zipError = "";
$addressError = "";


if (empty ($_POST["email"]))
	$emailError = "Required";
else if (!filter_var(($_POST["email"]), FILTER_VALIDATE_EMAIL)) 
      $emailError = "Invalid email format";

if (empty ($_POST["password"]))
	$passwordError = "Required";
else if(!preg_match($pattern, $_POST["password"]))
	$passwordError = "Password Requires: 16+ characters, 1 upper, 1 lower, 1 number and 1 special character";
else if(strcmp($_POST["password"], $_POST["password2"]) !== 0)
    $passwordError = "Passwords do not match";

if(strcmp($_POST["password"], $_POST["password2"]) !== 0)
    $password2Error = "Passwords do not match";

if (empty ($_POST["role"]))
	$roleError = "Required";

if (empty ($_POST["fname"]))
	$fnameError = "Required";
else if (is_numeric($_POST["fname"]))
	$fnameError = "Invalid name";


if (empty ($_POST["lname"]))
	$lnameError = "Required";
else if (is_numeric($_POST["lname"]))
	$lnameError = "Invalid name";


if (empty($_POST["phone"]))
	$phoneError ="Required";
else if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", ($_POST["phone"]))) 
    $phoneError ="Invalid Phone Number Format";



if (empty ($_POST["city"]))
	$cityError = "Required";
else if (is_numeric($_POST["city"]))
	$cityError = "Invalid City";


if (empty ($_POST["state"]))
	$stateError = "Required";
else if (is_numeric($_POST["state"]))
	$stateError = "Invalid State";


if (empty ($_POST["zip_code"]))
	$zipError = "Required";
else if(!is_numeric($_POST["zip_code"]))
	$zipError = "Invalid zip code entered.";


if (empty ($_POST["address"]))
	$addressError = "Required";


if($emailError || $passwordError || $roleError || $fnameError || $lnameError || $phoneError || $addressError || $cityError || $stateError || $zipError){
	header("Location: register.php?"
		. "email=$email"
		. "&" . "role=$role"
		. "&" . "fname=$fname"
		. "&" . "lname=$lname"
		. "&" . "phone=$phone"
		. "&" . "address=$address"
		. "&" . "address2=$address2"
		. "&" . "city=$city"
		. "&" . "state=$state"
		. "&" . "zip_code=$zip_code"
		. "&" . "emailError=$emailError"
		. "&" . "passwordError=$passwordError"
		. "&" . "password2Error=$password2Error"
		. "&" . "roleError=$roleError"
		. "&" . "fnameError=$fnameError"
		. "&" . "lnameError=$lnameError"
		. "&" . "phoneError=$phoneError"
		. "&" . "addressError=$addressError"
		. "&" . "cityError=$cityError"
		. "&" . "stateError=$stateError"
		. "&" . "zipError=$zipError");
}
else{

$email = htmlspecialchars($email);
$password = htmlspecialchars($password);
$role = htmlspecialchars($role);
$fname = htmlspecialchars($fname);
$lname = htmlspecialchars($lname);
$phone = htmlspecialchars($phone);
$city = htmlspecialchars($city);
$state = htmlspecialchars($state);
$zip_code = htmlspecialchars($zip_code);
$address = htmlspecialchars($address);
$address2 = htmlspecialchars($address2);
$password_salt = MD5(microtime());
$password_hash = MD5($password . $password_salt);

//Check to see if username already exists
$sql = "SELECT id FROM persons WHERE email='email'";
$query=$pdo->prepare($sql);
$query->execute(Array($email));
$result = $query->fetch(PDO::FETCH_ASSOC);
if($result){
	echo "<p>Username $email already exists.</p><br>";
	echo "<a href='register.php'>Back to register</a>";
}
else {
# 3. assign MySQL query code to a variable
$sql = "INSERT INTO persons (role, fname, lname, email, phone, password_hash, 
password_salt, address, address2, city, state, zip_code) VALUES 
(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$query=$pdo->prepare($sql);
$query->execute(Array($role, $fname, $lname, $email, $phone, $password_hash, 
$password_salt, $address, $address2, $city, $state, $zip_code));

# 4. insert the message into the database
$pdo->query($sql); # execute the query
echo "<p>Person has been added</p><br>";
echo "<a href='index.php'>Back to main page</a>";
}
}