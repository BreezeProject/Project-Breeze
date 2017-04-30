<?php
 ob_start();
 session_start();
 require('Database.php');
 
if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
}
 
    $error = 0;
 if ( isset($_POST['btn-signup']) ) {
	$quizID = trim($_POST['quizID']);
	$quizID = strip_tags($quizID);
	$quizID = htmlspecialchars($quizID);
	$_SESSION['quizID'] = $quizID;
		
  if($error == 0) {
	   $query = "SELECT Questions, Answers FROM quizes WHERE quizes.ID = '$quizID'";
	   $info_res = mysql_query($query);
	   $info = mysql_fetch_array($info_res);
	   $Questions = $info['Questions'];
	   $Answers = $info['Answers'];
	   
	   $Questions = explode(';',trim($Questions));
	   $Answers = explode(';',trim($Answers));
  }
 }
  
  if(isset($_POST['btn-signup1'])){
	 unset ($_SESSION['quizID']);
	echo "<script> window.location.href='class.php'; alert('Quiz Submitted'); </script>";

  }
 
?>
<!DOCTYPE html>
<html>
<head>
<title> Breeze </title>
</head>
<body>
  <form name= "top" method="post" action="" autocomplete="off">
    
   <h2> Quiz Selection </h2>
   
	<input type="text" name="quizID" class="form-control" placeholder="Enter Quiz ID" maxlength="50" value="<?php echo $quizID ?>" />
   <span class="text-danger"><?php echo $IDError; ?></span>
		
	<button form_id= "top" type="submit" class="btn btn-block btn-primary" name="btn-signup">Select</button>
	
	</form>

		<form method="post" action="" autocomplete="off">
		
		<?php
		if(isset($_SESSION['quizID'])){
		
		?>
		<h3> Quiz </h3>
		<?php
		foreach($Questions as $q) {
		   echo $q; 
		   ?>
		   <br>
		   
		   <input type="number" name="studentAnswer" class="form-control" placeholder="Enter your Answer" maxlength="15"/>
			<span class="text-danger"><?php echo $IDError; ?></span>
		   <br>
		   <br>
		   <?php
		}	
		?>
		<button type="submit" class="btn btn-block btn-primary" name="btn-signup1">Submit</button>
		<?php
	  }
	  ?>
	
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