<?php
session_start();
if (!isset($_SESSION['email'])) {
header("Location: login.php");
}

error_reporting(0);
// search form
echo "<form role='search' action='search.php'>";
    echo "<div class='input-group col-md-3 pull-left margin-right-1em'>";
        $search_value=isset($search_term) ? "value='{$search_term}'" : "";
        echo "<input type='text' class='form-control' placeholder='Type person's name...' name='s' id='srch-term' required {$search_value} />";
        echo "<div class='input-group-btn'>";
            echo "<button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i></button>";
        echo "</div>";
    echo "</div>";
echo "</form>";
  
// add a person button

echo "<div class='right-button-margin'>";
    echo "<a href='register.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-plus'></span> Register a person";
    echo "</a>";
echo "</div>";

  
// display the person if there are any
if($total_rows>0){
  
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Email</th>";
            echo "<th>Role</th>";
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>Phone Number</th>";
			echo "<th>Address</th>";
			echo "<th>Address 2</th>";
			echo "<th>City</th>";
			echo "<th>State</th>";
			echo "<th>Zip Code</th>";
        echo "</tr>";
  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
            extract($row);
  
            echo "<tr>";
                echo "<td>{$email}</td>";
                echo "<td>{$role}</td>";
                echo "<td>{$fname}</td>";
				echo "<td>{$lname}</td>";
				echo "<td>{$phone}</td>";
				echo "<td>{$address}</td>";
				echo "<td>{$address2}</td>";
				echo "<td>{$city}</td>";
				echo "<td>{$state}</td>";
				echo "<td>{$zip_code}</td>";
  
                echo "<td>";
  
                    // read person button
                    echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Read";
                    echo "</a>";
  
                    // edit person button
                    echo "<a href='update_person.php?id={$id}' class='btn btn-info left-margin'>";
                        echo "<span class='glyphicon glyphicon-edit'></span> Edit";
                    echo "</a>";
  
                    // delete person button
                    echo "<a href='delete_person.php?id={$id}' class='btn btn-danger delete-object'>";
                        echo "<span class='glyphicon glyphicon-remove'></span> Delete";
                    echo "</a>";
  
                echo "</td>";
  
            echo "</tr>";
  
        }
  
    echo "</table>";
  
    // paging buttons
    include_once 'paging.php';
}
  
// tell the user there are no person
else{
    echo "<div class='alert alert-danger'>No person found.</div>";
}

// Home button
echo "<div class='left-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-left'>";
        echo "<span class='glyphicon glyphicon-home'></span> Home";
    echo "</a>";
echo "</div>";

// logout a person button
echo "<div class='right-button-margin'>";
    echo "<a href='logout.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-minus'></span> Logout";
    echo "</a>";
echo "</div>";
?>