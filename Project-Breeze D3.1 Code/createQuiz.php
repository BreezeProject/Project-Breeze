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
    $query = "INSERT INTO quizes(classID, teacherID, Questions, Answers) VALUES('$classID','teacherID', '$Q1 ; $Q2 ; $Q3 ; $Q4 ; $Q5', '$Q1Correct ; $Q2Correct ; $Q3Correct ; $Q4Correct ; $Q5Correct')";
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
<title> New Quiz Creation</title>
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

  <h2 class="">Create a Quiz:</h2>
  
  <input type="text" name="classID" class="form-control" placeholder="Class ID" maxlength="50" />
  <span class="text-danger"><?php echo $ClassError; ?></span> <br>
  
  <input type="text" name="Q1" class="form-control" placeholder="Enter Question" maxlength="250" />
  <span class="text-danger"><?php echo $QuestionError; ?></span> <br>
  <input type="number" name="Q1Correct" class="form-control" placeholder="Enter Correct Answer Number" maxlength="1" />           
  <span class="text-danger"><?php echo $AnswerError; ?></span> <br>
  
  <input type="text" name="Q2" class="form-control" placeholder="Enter Question" maxlength="250" />
  <span class="text-danger"><?php echo $QuestionError; ?></span> <br>
  <input type="number" name="Q2Correct" class="form-control" placeholder="Enter Correct Answer Number" maxlength="1" />           
  <span class="text-danger"><?php echo $AnswerError; ?></span> <br>
  
  <input type="text" name="Q3" class="form-control" placeholder="Enter Question" maxlength="250" />
  <span class="text-danger"><?php echo $QuestionError; ?></span> <br>
  <input type="number" name="Q3Correct" class="form-control" placeholder="Enter Correct Answer Number" maxlength="1" />           
  <span class="text-danger"><?php echo $AnswerError; ?></span> <br>
  
  <input type="text" name="Q4" class="form-control" placeholder="Enter Question" maxlength="250" />
  <span class="text-danger"><?php echo $QuestionError; ?></span> <br>
  <input type="number" name="Q4Correct" class="form-control" placeholder="Enter Correct Answer Number" maxlength="1" />           
  <span class="text-danger"><?php echo $AnswerError; ?></span> <br>
  
  <input type="text" name="Q5" class="form-control" placeholder="Enter Question" maxlength="250" />
  <span class="text-danger"><?php echo $QuestionError; ?></span> <br>
  <input type="number" name="Q5Correct" class="form-control" placeholder="Enter Correct Answer Number" maxlength="1" />           
  <span class="text-danger"><?php echo $AnswerError; ?></span> <br>
  
  <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Create</button>
  
  </body>
  </html>
<?php ob_end_flush(); ?>
