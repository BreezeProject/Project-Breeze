<?php
session_start();
include("Database.php");

$maxPoints = $studentGrade = $classId = $studentId;
$check = 0;
$name = $nameError = $studentError = $error = "";
$gradeError = $classError = $maxError = "";

function getInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['submit']) ) 
{
  $name = getInput($_POST["name"]);
  $maxPoints = getInput($_POST["maxPoints"]);
  $studentGrade = getInput($_POST["studentGrade"]);
  $classId = getInput($_POST["classId"]);
  $studentId = getInput($_POST["studentId"]);

  if(empty($name))
  {
     $check = 1;
     $nameError = "Error: Assignment must have a Name";
  }

  if(empty($maxPoints))
  {
     $check = 1;
     $maxError = "Error: Must have a max number of points for the assignment";
  }
  
  if(empty($studentGrade))
  {
     $check = 1;
     $gradeError = "Error: Grade must be entered";
  }

  if(empty($classId))
  {
     $check = 1;
     $classError = "Error: Must provide class ID";
  }

  if(empty($name))
  {
     $check = 1;
     $studentError = "Error: Must provide student ID";
  }

  if($check==0)
  {
     $query = "INSERT INTO gradebook (name, maxPoints, studentGrade, classId, studentId) ".
     "VALUES ('$name', '$maxPoints', '$studentGrade', '$classId', '$studentId')";
     $result = mysql_query($query);

     if($result)
     {
     echo "<h3> Successfully Submitted Grade!</h3>";
     echo "<h3><a href = 'Grade.php'> Submit Another Grade</a></h3>";
     }
     else
     {
	$error = "ERROR: Something went wrong, Grade not added";
     }
  }
  else
  {
     $error = "ERROR: Please fill in the provided fields";

  }
}

?>



<html>
<head>
	<title>Grading</title>
	<h3> Grade an Assignment: </h3>
	<link href="css.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<form method = "post" action="">
<!-- Creates a CSS table for the inputs -->
<div class = "table">
	<span class = "error"> <?php echo $error;?></span>

	<div class = "row" >
		<div class = "col">Assignment Name:</div>
		<div class = "col"><input type="text" name = "name" size= "50" value = "<?php echo $name;?>"></div>
		<span class = "error"> <?php echo $nameError;?></span>
	</div>

	<div class = "row">
		<div class = "col">Student ID:</div>
		<div class = "col"><input type="text" name = "studentId" size="50" value = "<?php echo $studentId;?>"></div>
		<span class = "error"> <?php echo $studentError;?></span>
	</div>

	<div class = "row">
		<div class = "col">Class ID:</div>
		<div class = "col"><input type="text" name = "classId" size="50" value = "<?php echo $classId;?>"></div>
		<span class = "error"> <?php echo $classError;?></span>
	</div>

	<div class = "row">
		<div class = "col">Max Points:</div>
		<div class = "col"><input type="text" name = "maxPoints" size="50" value = "<?php echo $maxPoints;?>"></div>
		<span class = "error"> <?php echo $maxError;?></span>
	</div>

	<div class = "row">
		<div class = "col">Students Score:</div>
		<div class = "col"><input type="text" name = "studentGrade" size="50" value = "<?php echo $studentGrade;?>"></div>
		<span class = "error"> <?php echo $gradeError;?></span>
	</div>
	
	<div class = "row">
		<div class = "col"><input type="submit" name = "submit" value ="Submit"></div>
	</div>
</div>
</form>
</body>
</html>