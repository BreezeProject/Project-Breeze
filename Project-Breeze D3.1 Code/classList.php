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
<title> Class List </title>
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
	   echo "Class ID: " , $info['ID'] , " | " , $info['Name'] , " | ";?> <a href="main.php">Grades</a> <br><?php echo " | " ;?><a href="main.php">Upload</a><?php
	}
	
	}
	?>

	
    <ul> 
	<li><a href="main.php">Home</a></li>
	  <?php
		if($_SESSION['userType']== "Teacher"){

	  ?>
	  <li><a href = 'teacher.php'>Teacher Page</a></li>
	  <?php
	  }
  ?>
  
   <?php
		if($_SESSION['userType']== "Student"){

	  ?>
	  <li><a href = 'class.php'>Class Viewer</a></li>
	  <?php
	  }
  ?>
    </ul>

   
    </form>

</body>
</html>
<?php ob_end_flush(); ?>