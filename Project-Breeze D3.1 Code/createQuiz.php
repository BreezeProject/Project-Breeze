<?php
session_start();
include('Database.php');
 if( isset($_SESSION['userType'])!="Teacher" ){
  header("Location: main.php");
 }
 
  if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
  
 }
 include_once 'Database.php';

 $error = 0;
 if ( isset($_POST['btn-signup']) ) {
	 
	$classID = trim($_POST['classID']);
	$classID = strip_tags($classID);
	$classID = htmlspecialchars($classID);
	
	$teacherID = trim($_SESSION['userID']);
	$teacherID = strip_tags($teacherID);
	$teacherID = htmlspecialchars($teacherID);
	
	$Q1 = trim($_POST['Q1']);
	$Q1 = strip_tags($Q1);
	$Q1 = htmlspecialchars($Q1);
	$Q2 = trim($_POST['Q2']);
	$Q2 = strip_tags($Q2);
	$Q2 = htmlspecialchars($Q2);
	$Q3 = trim($_POST['Q3']);
	$Q3 = strip_tags($Q3);
	$Q3 = htmlspecialchars($Q3);
	$Q4 = trim($_POST['Q4']);
	$Q4 = strip_tags($Q4);
	$Q4 = htmlspecialchars($Q4);
	$Q5 = trim($_POST['Q5']);
	$Q5 = strip_tags($Q5);
	$Q5 = htmlspecialchars($Q5);
	
	$Q1Correct = trim($_POST['Q1Correct']);
	$Q1Correct = strip_tags($Q1Correct);
	$Q1Correct = htmlspecialchars($Q1Correct);
	$Q2Correct = trim($_POST['Q2Correct']);
	$Q2Correct = strip_tags($Q2Correct);
	$Q2Correct = htmlspecialchars($Q2Correct);
	$Q3Correct = trim($_POST['Q3Correct']);
	$Q3Correct = strip_tags($Q3Correct);
	$Q3Correct = htmlspecialchars($Q3Correct);
	$Q4Correct = trim($_POST['Q4Correct']);
	$Q4Correct = strip_tags($Q4Correct);
	$Q4Correct = htmlspecialchars($Q4Correct);
	$Q5Correct = trim($_POST['Q5Correct']);
	$Q5Correct = strip_tags($Q5Correct);
	$Q5Correct = htmlspecialchars($Q5Correct);
	 
 if($error==0) {
    
    //puts the information into the database
    $query = "INSERT INTO quizes(classID, teacherID, Questions, Answers) VALUES('$classID','teacherID', '$Q1;$Q2;$Q3;$Q4;$Q5', '$Q1Correct;$Q2Correct;$Q3Correct;$Q4Correct;$Q5Correct')";
    $results = mysql_query($query);


    //error checking
    if ($results) {
      $errTyp = "success";
      $errMSG = "Successfully registered";
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
<html>
<head>
<link rel="stylesheet" type="text/css" href="mainstyle.css">
<title> Breeze </title>
</head>
<body>



  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    <?php
   if ( isset($errMSG) ) {
    
    ?>
      <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
<?php echo $errMSG; ?>

       </div>
<?php
   }
   ?>

  <h2 class="">Create a Quiz</h2>
 <table style="width:100%">
 
  <tr>
  <td> Class ID: </td>
  <td> <input type="text" name="classID" class="form-control" placeholder="Class ID" maxlength="50" />
  <span class="text-danger"><?php echo $ClassError; ?></span> </td>
  </tr>
  
  <tr>
  <td>Question 1:</td>
  <td><input type="text" name="Q1" class="form-control" placeholder="Enter Question 1" maxlength="250" />
  <span class="text-danger"><?php echo $QuestionError; ?></span> </td>
  </tr>
  
  <tr>
  <td>Correct Answer's Number: </td>
  <td><input type="number" name="Q1Correct" class="form-control" placeholder="Enter Correct Answer Number" maxlength="1" />           
  <span class="text-danger"><?php echo $AnswerError; ?></span>  </td>
  </tr>
  
  <tr>
  <td>Question 2:</td>
  <td><input type="text" name="Q2" class="form-control" placeholder="Enter Question 2" maxlength="250" />
  <span class="text-danger"><?php echo $QuestionError; ?></span>  </td>
  </tr>
  
  <tr>
  <td>Correct Answer's Number: </td>
  <td><input type="number" name="Q1Correct" class="form-control" placeholder="Enter Correct Answer Number" maxlength="1" />           
  <span class="text-danger"><?php echo $AnswerError; ?></span>  </td>
  </tr>
  
  <tr>
  <td>Question 3:</td>
  <td><input type="text" name="Q3" class="form-control" placeholder="Enter Question 3" maxlength="250" />
  <span class="text-danger"><?php echo $QuestionError; ?></span> </td> 
  </tr>
  
  <tr>
  <td>Correct Answer's Number: </td>
  <td><input type="number" name="Q1Correct" class="form-control" placeholder="Enter Correct Answer Number" maxlength="1" />           
  <span class="text-danger"><?php echo $AnswerError; ?></span>  </td>
  </tr>
  
  <tr>
  <td>Question 4:</td>
  <td><input type="text" name="Q4" class="form-control" placeholder="Enter Question 4" maxlength="250" />
  <span class="text-danger"><?php echo $QuestionError; ?></span> </td>
  </tr>
  
  <tr>
  <td>Correct Answer's Number: </td>
  <td><input type="number" name="Q1Correct" class="form-control" placeholder="Enter Correct Answer Number" maxlength="1" />           
  <span class="text-danger"><?php echo $AnswerError; ?></span>  </td>
  </tr>
  
  <tr>
  <td>Question 5:</td>
  <td><input type="text" name="Q5" class="form-control" placeholder="Enter Question 5" maxlength="250" />
  <span class="text-danger"><?php echo $QuestionError; ?></span>  </td>
  </tr>
  
  <tr>
  <td>Correct Answer's Number: </td>
  <td><input type="number" name="Q1Correct" class="form-control" placeholder="Enter Correct Answer Number" maxlength="1" />           
  <span class="text-danger"><?php echo $AnswerError; ?></span>  </td>
  </tr>
  
  </table>
  <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Create</button>
  <br>
		<br>
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
