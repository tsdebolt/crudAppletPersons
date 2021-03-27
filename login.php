<?php
    error_reporting(0);
    session_start(); 
	
		$errMsg=''; // initialize message to display on HTML form
		if (isset($_POST['login']) 
			&& !empty($_POST['email']) 
			&& !empty($_POST['password'])) {
				
			# prevent HTML/CSS/JS injection
			$email = $_POST['email'];
			$password = $_POST['password'];
			$email = htmlspecialchars($email);
			$password = htmlspecialchars($password);

		
			# check "back door" login
			//if ($_POST['username'] == 'admin@admin.com' 
			//	&& $_POST['password'] == 'admin') {
			  
			//	$_SESSION['username']='admin@admin.com';
			//	header('Location: display_list.php'); // redirect
				
			//} else {
				
				# check database for legit username 
				require '../databaseA16/database.php';
				$pdo = Database::connect();
				$sql = "SELECT * FROM persons " 
				    . " WHERE email=? " 
					. " LIMIT 1"
					;
				$query=$pdo->prepare($sql);
				$query->execute(Array($email));
				$result = $query->fetch(PDO::FETCH_ASSOC);
				
				# if user typed legit username, verify SALTED password
				if ($result) {
					
					$password_hash_db = $result['password_hash'];
					$password_salt_db = $result['password_salt'];
					$password_hash = MD5($password . $password_salt_db);
					
					//echo("Test:" . $password_hash);
					// if password id correct, redirect
					if(!strcmp($password_hash, $password_hash_db)) {
						$_SESSION['email'] = $result['email'];
						header('Location: index.php'); // redirect
					}
					// otherwise redisplay login screen
					else {
						$errMsg='Login failure: wrong password';
					}

				}
				
			else 
				$errMsg='Login failure: wrong username or password';
			}
		//}
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<title>Crud Applet with Login</title>
		<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <title><?php echo $page_title; ?></title>
  
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
   
    <!-- our custom CSS -->
    <link rel="stylesheet" href="libs/css/custom.css" />
   
	</head>

	<body>
		
		
		<div class="container">
			<h1>Crud Applet with Login</h1>
		
			<form action="" method="post">
				<table class='table table-hover table-responsive table-bordered'>
			<tr>
            <td>Email</td>
            <td><input type="text" class="form-control" 
				name="email" placeholder="admin@admin.com" 
				required autofocus /></td>
            </tr>
        
            <tr>
            <td>Password</td>
            <td><input type="password" class="form-control"
				name="password" placeholder="admin" required /></td>
            </tr>
				
			<tr>
            
            <td><button class="btn btn-lg btn-primary btn-block" 
				type="submit" name="login">Login</button></td>
			<td><p style="color: red;"><?php echo $errMsg; ?></p></td>
            </tr>	

			</form>

		</div> 

	</body>
	
</html>