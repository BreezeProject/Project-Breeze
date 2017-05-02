<?php
 ob_start();
 session_start();
 include_once 'Database.php';

 if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
 }
 
 $error = 0;

  if ( isset($_POST["btn-change"]) ) {
  
    // clean user inputs to prevent sql injections
    $name = trim($_POST['name']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

  
    //Email Error Checking
    if(strlen($email) != 0){
      // check if the email exists already
      $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
      $result = mysql_query($query);
      $count = mysql_num_rows($result);

      //makes sure its a valid email
      if(!filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = 1;
        $emailError = "Please enter valid email address.";
      }

      if($count!=0){
        $error = 1;
        $emailError = "Provided Email is already in use.";
      }
    
    }
  
    // if no error change the records in the database
    if($error==0) {
	  $user = $_SESSION['userID'];
      //checks if there is a password to change
      if(!empty($pass)){
        $query1 = mysql_query("UPDATE users SET userPass = '$pass' WHERE userID='$user'");

      }
      //checks to see if there is a name to change
      if(!empty($name)){
          //Name Error Checking
        $query2 = mysql_query("UPDATE users SET userName = '$name' WHERE userID='$user'");
       
        }
      
      //checks to see if there is an email to change
      if(!empty($email)){
        $query3 = mysql_query("UPDATE users SET userEmail = '$email' WHERE userID='$user'");

      //if there is no input values greater than length 0 error
      }
      if(empty($pass) && empty($name) && empty($email)){
        $errTyp = "danger";
        $errMSG = "No input values given so no changes were made";
      }
    }

    if ($query1 || $query2 || $query3) {
        $errTyp = "success";
        $sucMSG = "Successfully Saved changes";
        unset($name);
        unset($email);
        unset($pass);
    }else {
        $errTyp = "danger";
        $errMSG = "Something went wrong, try again later...";
      } 
}
?>

<!DOCTYPE html>
<html>
<head>
<title> Breeze </title>
<link rel="stylesheet" type="text/css" href="mainstyle.css">
</head>
<body>

  <h2> Change Account Information </h2>

  <form method="post" action="" autocomplete="off">
    
            
<?php
   if ( !isset($errMSG) ) {
    
?>
      <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>"><?php echo $sucMSG; ?></div>

<?php 
} 

?>
      <table style="width:100%">

            <tr>
			<td> Change Name: </td>
            <td><input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" />
			<span class="text-danger"><?php echo $nameError; ?></span></td>
            </tr>
            
            <tr>
			<td> Change Email: </td>
            <td><input type="email" name="email" class="form-control" placeholder="Enter Email" maxlength="40" value="<?php echo $email ?>" />
			<span class="text-danger"><?php echo $emailError; ?></span></td>
            </tr>
            
			<tr>
			<td> Change Password: </td>
            <td><input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
			<span class="text-danger"><?php echo $passError; ?></span></td>
            </tr>			
            
			</table>
			
			<button type="submit" class="btn btn-block btn-primary" name="btn-change">Save</button>
			
		<br>
		<br>
	
<div class="navigation">
	<h4> Navigation </h4> 
	<ul>
	<li><a href='main.php'>Home</a></li>
	<li><a href='edit.php'>Change Account Info</a></li>
	<?php
	if($_SESSION['userType']== "Admin"){

	?>
	<li><a href="registerStudent.php">Create a New User</a></li>
	<li><a href="delete.php">Delete a User</a></li>
	<li><a href="registerClass.php">Create a New Class</a></li>
	<li><a href="delete.php">Delete a Class</a></li>
	<li><a href="registerForClass.php">Assign a Student to a Class</a></li>
	<li><a href="main.php">Unassign a Student from a Class</a></li>
	<?php
	}
	?>
	<?php
	if($_SESSION['userType']== "Teacher"){

	?>
	<li><a href="classList.php">View Classes</a></li>
	<li><a href="main.php">Open Gradebook</a></li>
	<li><a href="createQuiz.php">Create a Quiz</a></li>
	<li><a href="class.php">View a Class</a></li>
	<?php
	}
	?>
	<?php
	if($_SESSION['userType']== "Student"){

	?>
	<li><a href="classList.php">View Classes</a></li>
	<li><a href='takeQuiz.php'>Take a Quiz</a></li>
	<li><a href='main.php'>Upload an Assignment</a></li>
	<li><a href="class.php">View a Class</a></li>
	<?php
	}
	?>
	<li><a href='logout.php'>Log Out</a></li>
	</ul>
	</div>
</body>
</html>
<?php ob_end_flush(); ?>