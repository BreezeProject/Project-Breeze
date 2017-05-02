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
  
  $classID = trim($_POST['classID']);
  $classID = strip_tags($classID);
  $classID = htmlspecialchars($classID);
  
  // id Error Checking
  if (empty($id)){
   $error = 1;
   $IDError = "Please enter an ID.";
  }else {
   // check if the student exists
   $query = "SELECT userID FROM users WHERE userID='$id'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=1){
    $error = 1;
    $IDError = "Given ID doesnt exist.";
   }
  }
  
  // id Error Checking
  if (empty($classID)){
   $error = 1;
   $classError = "Please enter a Class ID.";
  }else {
   // check if the class exists
   $query = "SELECT ID FROM classes WHERE ID='$classID'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=1){
    $error = 1;
    $classError = "Provided Class ID is dosent exist.";
   }
  }
  
  // if no error connect the student and the class in the database
  if($error==0) {
    
    //puts the information into the database
    $query = "INSERT INTO classlists(ClassID, StudentID) VALUES('$classID','$id')";
    $results = mysql_query($query);


    //error checking
    if ($results) {
      $errTyp = "success";
      $errMSG = "Successfully registered";
      unset($id);
	  unset($classID);
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
    

  <h2 class=""> Assign a User to a Class </h2>


            
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
	<td><input type="text" name="id" class="form-control" placeholder="Enter Student ID" maxlength="15" value="<?php echo $id ?>" />
	<span class="text-danger"><?php echo $IDError; ?></span> </td>
	</tr>
	
	<tr>
	<td> Class ID:</td>
	<td><input type="text" name="classID" class="form-control" placeholder="Enter Class ID" maxlength="15" value="<?php echo $id ?>" />
	<span class="text-danger"><?php echo $classError; ?></span> </td>
	</tr>
		
	</table> 
        
	<button type="submit" class="btn btn-block btn-primary" name="btn-signup">Assign</button>	
		
    </form>
	
	

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
	<?php
	}
	?>
	<?php
	if($_SESSION['userType']== "Student"){

	?>
	<li><a href="classList.php">View Classes</a></li>
	<li><a href='takeQuiz.php'>Take a Quiz</a></li>
	<li><a href='main.php'>Upload an Assignment</a></li>
	<?php
	}
	?>
	<li><a href='logout.php'>Log Out</a></li>
	</ul>
</body>
</html>
<?php ob_end_flush(); ?>