<?php
 ob_start();
 session_start();
 require_once 'Database.php';
 if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
 }
 
 if( isset($_SESSION['userType'])!="Admin" ){
  header("Location: main.php");
 }
 
 if ( isset($_POST['btn-signup']) ) {
	$classID = trim($_POST['classID']);
	$classID = strip_tags($classID);
	$classID = htmlspecialchars($classID);
	
	$userID = trim($_POST['userID']);
	$userID = strip_tags($userID);
	$userID = htmlspecialchars($userID);
	
	if(strlen($classID) != 0){
		$query = "DELETE FROM classes WHERE classes.ID = '$classID'";
		$res1 = mysql_query($query);
		unset($classID);
		echo"<script> alert('Successfully deleted the Class'); </script>";
	}
	if(strlen($userID) != 0){
		$query = "DELETE FROM users WHERE users.userID = '$userID'";
		$res2 = mysql_query($query);	
		unset($userID);
		echo"<script> alert('Successfully deleted the User'); </script>";
	}
 }
 ?>
<!DOCTYPE html>
<html>
<head>
<title> Breeze </title>
<h2> Delete A User / Class</h2>
</head>
<body>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
	
	<table style="width:15%">
	
	<tr>
	<td>Enter a Class ID: <input type="text" name="classID" class="form-control" placeholder="Enter Class ID" maxlength="50" value="<?php echo $classID ?>" />
	<span class="text-danger"><?php echo $IDError; ?></span></td>
	</tr>
	
	<tr>
	<td> Or: </td>
	</tr>
	
	<tr>
	<td>Enter a User ID: <input type="text" name="userID" class="form-control" placeholder="Enter User ID" maxlength="50" value="<?php echo $classID ?>" />
	<span class="text-danger"><?php echo $IDError; ?></span></td>
	</tr>

	</table>	
	<button type="submit" class="btn btn-block btn-primary" name="btn-signup">submit</button>

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