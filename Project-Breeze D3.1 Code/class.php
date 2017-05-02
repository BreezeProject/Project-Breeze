<?php
session_start();
include('Database.php');
  if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
  }
  
  $error = 0;
 if ( isset($_POST['btn-signup']) ) {
	$classID = trim($_POST['classID']);
	  $classID = strip_tags($classID);
	  $classID = htmlspecialchars($classID);
		$_SESSION['classID'] = $classID;
		
  if($error == 0) {
	   $query = "SELECT Name FROM classes WHERE classes.ID = '$classID'";
	   $info_res = mysql_query($query);
	   $info = mysql_fetch_array($info_res);
	   $cName = $info['Name'];
	   
	   
  }
 }
 
?>
<!DOCTYPE html>
<html>
<head>

<title> Breeze </title>
<h2> Class View </h2>
</head>
<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
		<input type="text" name="classID" class="form-control" placeholder="Enter Class ID" maxlength="50" value="<?php echo $classID ?>" />
		<span class="text-danger"><?php echo $IDError; ?></span>
		
		<button type="submit" class="btn btn-block btn-primary" name="btn-signup">submit</button>
		
		<?php
		if(isset($_SESSION['classID'])){
		
		?>
		<h3> Quizes </h3>
		<?php
		$query = "SELECT ID FROM quizes WHERE classID='$classID'";
		$results = mysql_query($query);
		while($rows = mysql_fetch_array($results)) {
		   echo "Quiz ID: " , $rows['ID']; 
		   ?>
		   <br>
		   <?php
		}

		?>
		<h3> Assignments </h3>
		<?php
	  }
	  ?>
		
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
