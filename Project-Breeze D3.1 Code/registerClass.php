<?php
 ob_start();
 session_start();
 if( isset($_SESSION['userType'])!="Admin" ){
  header("Location: main.php");
 }
 
  if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
 }
 
 include_once 'Database.php';

 $error = 0;

 if ( isset($_POST['btn-signup']) ) {
	 
	// clean user inputs to prevent sql injections
	  $ClassName = trim($_POST['ClassName']);
	  $ClassName = strip_tags($ClassName);
	  $ClassName = htmlspecialchars($ClassName);
	  
	  $TID = trim($_POST['TID']);
	  $TID = strip_tags($TID);
	  $TID = htmlspecialchars($TID);
	  
	  $CLocation = trim($_POST['CLocation']);
	  $CLocation = strip_tags($CLocation);
	  $CLocation = htmlspecialchars($CLocation);
	  
	  $MaxStudents = trim($_POST['MaxStudents']);
	  $MaxStudents = strip_tags($MaxStudents);
	  $MaxStudents = htmlspecialchars($MaxStudents);
	  
	  $StartTime = trim($_POST['StartTime']);
	  $StartTime = strip_tags($StartTime);
	  $StartTime = htmlspecialchars($StartTime);
	  
	  $EndTime = trim($_POST['EndTime']);
	  $EndTime = strip_tags($EndTime);
	  $EndTime = htmlspecialchars($EndTime);
	  
	  $DayMonday = trim($_POST['DayMonday']);
	  $DayMonday = strip_tags($DayMonday);
	  $DayMonday = htmlspecialchars($DayMonday);
	  
	  $DayTuesday = trim($_POST['DayTuesday']);
	  $DayTuesday = strip_tags($DayTuesday);
	  $DayTuesday = htmlspecialchars($DayTuesday);
	  
	  $DayWednesday = trim($_POST['DayWednesday']);
	  $DayWednesday = strip_tags($DayWednesday);
	  $DayWednesday = htmlspecialchars($DayWednesday);
	  
	  $DayThursday = trim($_POST['DayThursday']);
	  $DayThursday = strip_tags($DayThursday);
	  $DayThursday = htmlspecialchars($DayThursday);
	  
	  $DayFriday = trim($_POST['DayFriday']);
	  $DayFriday = strip_tags($DayFriday);
	  $DayFriday = htmlspecialchars($DayFriday);
	  
	  $ClassDesc = trim($_POST['ClassDesc']);
	  $ClassDesc = strip_tags($ClassDesc);
	  $ClassDesc = htmlspecialchars($ClassDesc);
  
  //Name Error Checking
  if (empty($ClassName)) {
   $error = 1;
   $NameError = "Please enter a name.";
  } else if (strlen($ClassName) < 2) {
   $error = 1;
   $NameError = "Names must have at least 2 characters.";
  } 
  
  //Teacher Error Checking
  if (empty($TID)) {
   $error = 1;
   $TeacherIDError = "Please enter a Teacher's ID.";
  } 
  
  //Location Error Checking
  if (empty($CLocation)) {
   $error = 1;
   $LocationError = "Please enter a Location.";
  } 
  
  //NumStudents Error Checking
  if (empty($MaxStudents)) {
   $error = 1;
   $NumStudentsError = "Please enter a maximum number of students for this class.";
  }
  
  //Time Error Checking
  if (empty($StartTime) || empty($EndTime)) {
   $error = 1;
   $TimeError = "Please enter valid class times.";
  } 
  
  //Day Error Checking
  if (empty($DayMonday) && empty($DayTuesday) && empty($DayWednesday) && empty($DayThursday) && empty($DayFriday)) {
   $error = 1;
    $DayError= "Classes must be held atleast one day";
  } 
  
  // if no error sign the user up into the database
  if($error==0) {
    $MaxNumStudents = intval($_POST['MaxStudents']);
    //puts the information into the database
    $query = "INSERT INTO classes(Name, TeacherID, Location, MaxNumStudents, StartTime, EndTime, DaysOfWeek, Desciption) VALUES('$ClassName','$TID','$CLocation','$MaxStudents','$StartTime','$EndTime','$DayMonday $DayTuesday $DayWednesday $DayThursday $DayFriday','$ClassDesc')";
    $results = mysql_query($query);
	
	$query = "SELECT * FROM classes ORDER BY ID DESC LIMIT 1";
    $results = mysql_query($query);
	$classID = mysql_fetch_array($results);
	$classID = $classID['ID'];
	
	$query = "INSERT INTO classlists(ClassID, StudentID) VALUES('$classID','$TID')";
    $results = mysql_query($query);


    //error checking
    if ($results) {
      $errTyp = "success";
      $errMSG = "Successfully registered";
      unset($ClassName);
      unset($TID);
      unset($CLocation);
	  unset($MaxStudents);
	  unset($StartTime);
	  unset($EndTime);
	  unset($ClassDesc);
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
    

  <h2 class="">Create a Class</h2>


            
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
    <td> Class Name: </td>
	<td><input type="text" name="ClassName" class="form-control" placeholder="Class Name" maxlength="50" />
	<span class="text-danger"><?php echo $NameError; ?></span>  </td>
	</tr>
	
	<tr>
    <td> Teacher ID: </td>
    <td><input type="text" name="TID" class="form-control" placeholder="Teacher's ID" maxlength="50" />
	<span class="text-danger"><?php echo $TeacherIDError; ?></span> </td>
	</tr>
    
	<tr>
    <td> Class Location: </td>	
	<td><input type="text" name="CLocation" class="form-control" placeholder="Class Location" maxlength="40" />
    <span class="text-danger"><?php echo $LocationError; ?></span> </td>
    </tr>       
    
	<tr>
    <td> Maximum Students: </td>		
    <td><input type="number" name="MaxStudents" class="form-control" placeholder="Maximum Students" maxlength="15" />
    <span class="text-danger"><?php echo $NumStudentsError; ?></span></td>
	</tr>
	
	<tr>
    <td> Class Start Time: </td>	
	<td><input type="time" name="StartTime" class="form-control" placeholder="Class Start Time" maxlength="40" />
	<span class="text-danger"><?php echo $TimeError; ?></span> </td>	
	</tr>
	
	<tr>
    <td> Class End Time: </td>
	<td><input type="time" name="EndTime" class="form-control" placeholder="Class End Time" maxlength="40" />
	<span class="text-danger"><?php echo $TimeError; ?></span> </td>
	</tr>
	
	<tr>
    <td> Class Description: </td>
	<td><input type="text" name="ClassDesc" class="form-control" placeholder="Class Description(Optional)" maxlength="255" /></td>
	</tr>
	
	</table>  
			
	<div>			
	<input type="Checkbox" name="DayMonday" value="M"/> Monday<br>
	<input type="Checkbox" name="DayTuesday" value="T"/> Tuesday<br>
	<input type="Checkbox" name="DayWednesday" value="W"/> Wednesday<br>
	<input type="Checkbox" name="DayThursday" value="Th"/> Thursday<br>
	<input type="Checkbox" name="DayFriday" value="F"/> Friday<br>
	
	<span class="text-danger"><?php echo $DayError; ?></span>
	
	</div>	
			
    <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Create</button>
	
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