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
<title> New Class Creation</title>
</head>
<body>



  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    

  <h2 class="">Create a Class:</h2>


            
<?php
   if ( isset($errMSG) ) {
    
    ?>
      <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
<?php echo $errMSG; ?>

       </div>
<?php
   }
   ?>
            <input type="text" name="ClassName" class="form-control" placeholder="Enter Class Name" maxlength="50" />

                <span class="text-danger"><?php echo $NameError; ?></span> <br>
			
             <input type="text" name="TID" class="form-control" placeholder="Enter Teacher ID" maxlength="50" />

                <span class="text-danger"><?php echo $TeacherIDError; ?></span> <br>

            
             <input type="text" name="CLocation" class="form-control" placeholder="Enter Class Location" maxlength="40" />
              
                <span class="text-danger"><?php echo $LocationError; ?></span> <br>
            
            
             <input type="number" name="MaxStudents" class="form-control" placeholder="Enter Maximum Number of Students" maxlength="15" />
                
                <span class="text-danger"><?php echo $NumStudentsError; ?></span> <br>
				
			<input type="time" name="StartTime" class="form-control" placeholder="Enter Class Start Time" maxlength="40" />
			 
				<span class="text-danger"><?php echo $TimeError; ?></span> <br>
			
			<input type="time" name="EndTime" class="form-control" placeholder="Enter Class End Time" maxlength="40" />
			
				<span class="text-danger"><?php echo $TimeError; ?></span> <br>
			
			<div>			
			<input type="Checkbox" name="DayMonday" value="M"/> Monday<br>
			<input type="Checkbox" name="DayTuesday" value="T"/> Tuesday<br>
			<input type="Checkbox" name="DayWednesday" value="W"/> Wednesday<br>
			<input type="Checkbox" name="DayThursday" value="Th"/> Thursday<br>
			<input type="Checkbox" name="DayFriday" value="F"/> Friday<br>
			
			<span class="text-danger"><?php echo $DayError; ?></span>
			
			</div>	
			
			<input type="text" name="ClassDesc" class="form-control" placeholder="Enter Class Description" maxlength="255" />
			
             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Create</button>
    </form>
	
	<a href="main.php">Home</a>
	<a href="admin.php">Administrative Actions</a>
</body>
</html>
<?php ob_end_flush(); ?>