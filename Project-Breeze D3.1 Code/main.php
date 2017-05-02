<?php
 ob_start();
 session_start();
 require_once 'Database.php';

 // if session is not set this will redirect to login page
 if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
 }else{
   // select the logged in users row to display their name
   $user = $_SESSION['userID'];
   $res=mysql_query("SELECT userName FROM users WHERE userID='$user'");
   $userRow=mysql_fetch_array($res);
   $name = $userRow['userName'];
   $name = explode(' ',trim($name));
   $name = $name[0];
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="mainstyle.css">
<title> Breeze </title>
<h2> Welcome back <?php echo $name ?>.</h2>
</head>
<body>
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

