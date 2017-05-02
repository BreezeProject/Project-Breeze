<?php
 ob_start();
 session_start();
 require('Database.php');
 
if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
 }
 
?>
<!DOCTYPE html>
<html>
<head>
<title> Breeze </title>
</head>
<body>
  <form method="post" action="" autocomplete="off">
    
   <h2> My Classes </h2>

   
	<?php
	if( $_SESSION['userType'] == "Teacher" ) {
	$userID = $_SESSION['userID'];
	$query = "SELECT classID FROM classlists WHERE StudentID='$userID'";
    $results = mysql_query($query);
	while($rows = mysql_fetch_array($results)) {
	   $cID = $rows['classID'];
	   $query = "SELECT ID, Name FROM classes WHERE classes.ID = '$cID'";
	   $info_res = mysql_query($query);
	   $info = mysql_fetch_array($info_res);
	   echo "Class ID: " , $info['ID'] , " | " , $info['Name'] , " | ";?> <a href="main.php">Grades</a> <?php echo " | " ;?><a href="main.php">Upload</a><?php echo " | " ;?> <a href="createQuiz.php">Create Quiz</a> <br><?php
	}
	}
	
	if( $_SESSION['userType'] == "Student" ) {
	$userID = $_SESSION['userID'];
	$query = "SELECT classID FROM classlists WHERE StudentID='$userID'";
    $results = mysql_query($query);
	while($rows = mysql_fetch_array($results)) {
	   $cID = $rows['classID'];
	   $query = "SELECT ID, Name FROM classes WHERE classes.ID = '$cID'";
	   $info_res = mysql_query($query);
	   $info = mysql_fetch_array($info_res);
	   echo "Class ID: " , $info['ID'] , " | " , $info['Name'] , " | ";?> <a href="main.php">Grades</a><?php echo " | " ;?><a href="main.php">Upload</a> <br><?php
	}
	
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

   
    </form>

</body>
</html>
<?php ob_end_flush(); ?>