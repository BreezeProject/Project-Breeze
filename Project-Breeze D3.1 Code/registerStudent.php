<?php
 ob_start();
 session_start();
 if( isset($_SESSION['user'])!="" ){
  header("Location: main.php");
 }
  if( isset($_SESSION['userType'])!="Admin" ){
  header("Location: main.php");
 }
 include_once 'Database.php';

 $error = 0;

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $id = trim($_POST['id']);
  $id = strip_tags($id);
  $id = htmlspecialchars($id);
  
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  // id Error Checking
  if (empty($id)){
   $error = 1;
   $IDError = "Please enter an ID.";
  }
  
  //Name Error Checking
  if (empty($name)) {
   $error = 1;
   $nameError = "Please enter your full name.";
  } else if (strlen($name) < 2) {
   $error = 1;
   $nameError = "Name must have at least 2 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
   $error = 1;
   $nameError = "Name must only use the alphabet or spaces.";
  }
  
  //Email Error Checking
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = 1;
   $emailError = "Please enter valid email address.";
  } else {
   // check if the email exists already
   $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = 1;
    $emailError = "Provided Email is already in use.";
   }
  }
  // Password Error Checking
  if (empty($pass)){
   $error = 1;
   $passError = "Please enter password.";
  } else if(strlen($pass) < 7) {
   $error = 1;
   $passError = "Password must have atleast 7 characters.";
  }

  // if no error sign the user up into the database
  if($error==0) {
	$type = $_POST['test'];
    //puts the information into the database
	
    $query = "INSERT INTO users(userID,userName,userPassword,userEmail,userType) VALUES('$id','$name','$pass','$email', '$type')";
    $results = mysql_query($query);


    //error checking
    if ($results) {
      $errTyp = "success";
      $errMSG = "Successfully registered, you may login now";
      unset($id);
	  unset($name);
	  unset($type);
      unset($email);
      unset($pass);
     } else {
      $errTyp = "danger";
      $errMSG = "Something went wrong, try again later..."; 
     } 
    
  }else{
    $errTyp = "danger";
    $errMSG = "Failed To Register, Try Again Later";
  }
  

 }
?>
<!DOCTYPE html>
<html>
<head>
<title> Breeze </title>
</head>
<body>



  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    

  <h2 class="">Create a User</h2>


            
<?php
   if ( isset($errMSG) ) {
    
    ?>
      <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
<?php echo $errMSG; ?>

       </div>
<?php
   }
   ?>
   
   <table style="width:15%">
   
    <tr>
	<td> Student ID:</td>
	<td><input type="text" name="id" class="form-control" placeholder="Enter Student ID" maxlength="50" value="<?php echo $id ?>" />
	<span class="text-danger"><?php echo $IDError; ?></span> </td>
	</tr>
	
	<tr>
	<td> Student Name:</td>
	<td><input type="text" name="name" class="form-control" placeholder="Enter Student Name" maxlength="50" value="<?php echo $name ?>" />
	<span class="text-danger"><?php echo $nameError; ?></span> </td>
	</tr>
	
	<tr>
	<td> Student Email:</td>
	<td><input type="text" name="email" class="form-control" placeholder="Enter Student Email" maxlength="50" value="<?php echo $email ?>" />
	<span class="text-danger"><?php echo $emailError; ?></span> </td>
	</tr>

	<tr>
	<td> Student Password</td>
	<td><input type="password" name="pass" class="form-control" placeholder="Enter Student Password" maxlength="15"/>
	<span class="text-danger"><?php echo $passError; ?></span> </td>
	</tr>
           
    </table>        
 
	<div id = "radio">
	<label><input type="radio" name="test" value="Admin"> Admin</label><br>
	<label><input type="radio" name="test" value="Student" checked> Student</label><br>
	<label><input type="radio" name="test" value="Teacher"> Teacher</label><br>
	</div>
			
			
					
    
	<button type="submit" class="btn btn-block btn-primary" name="btn-signup">Submit</button>
 
    </form>
	
	
	
	<h4> Navigation </h4> 
	<ul>
	<li><a href='main.php'>Home</a></li>
	<li><a href='edit.php'>Change Account Info</a></li>
	<?php
	if($_SESSION['userType']== "Admin"){

	?>
	<li><a href="registerStudent.php">Create a New User</a></li>
	<li><a href="main.php">Delete a User</a></li>
	<li><a href="registerClass.php">Create a New Class</a></li>
	<li><a href="main.php">Delete a Class</a></li>
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
</body>
</html>
<?php ob_end_flush(); ?>