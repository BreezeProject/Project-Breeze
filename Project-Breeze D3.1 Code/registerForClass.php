<?php
 ob_start();
 session_start();
 if( isset($_SESSION['user'])!="" ){
  header("Location: main.php");
 }
  if( isset($_SESSION['userType'])!="Admin" ){
  header("Location: main.php");
 }
 include_once 'Database.php';

 $error = 0;

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $id = trim($_POST['id']);
  $id = strip_tags($id);
  $id = htmlspecialchars($id);
  
  $classId = trim($_POST['pass']);
  $classId = strip_tags($pass);
  $classId = htmlspecialchars($pass);
  
  // id Error Checking
  if (empty($id)){
   $error = 1;
   $IDError = "Please enter an ID.";
  }else {
   // check if the student exists
   $query = "SELECT userID FROM users WHERE userID='$id'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=1){
    $error = 1;
    $IDError = "Given ID doesnt exist.";
   }
  }
  
  // id Error Checking
  if (empty($classId)){
   $error = 1;
   $classError = "Please enter an ID.";
  }else {
   // check if the class exists
   $query = "SELECT ID FROM classes WHERE ID='$classID'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=1){
    $error = 1;
    $emailError = "Provided Class ID is dosent exist.";
   }
  }
  
  // if no error connect the student and the class in the database
  if($error==0) {
    
    //puts the information into the database
    $query = "INSERT INTO classlist(ClassID, StudentID) VALUES('$classID','$id')";
    $results = mysql_query($query);


    //error checking
    if ($results) {
      $errTyp = "success";
      $errMSG = "Successfully registered, you may login now";
      unset($id);
	  unset($classID);
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
<title> Assign a user </title>
</head>
<body>



  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    

  <h2 class="">Assign a user:</h2>


            
<?php
   if ( isset($errMSG) ) {
    
    ?>
      <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
<?php echo $errMSG; ?>

       </div>
<?php
   }
   ?>
			<input type="text" name="id" class="form-control" placeholder="Enter Student ID" maxlength="50" value="<?php echo $id ?>" />

                <span class="text-danger"><?php echo $IDError; ?></span>
            
            
            
             <input type="password" name="classId" class="form-control" placeholder="Enter Class ID" maxlength="15" />
                
                <span class="text-danger"><?php echo $classError; ?></span>
 
			
            <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Assign</button>
            
			<br>
			
			<a href = "admin.php">Administrative Actions</a>
            <a href = "main.php">Home</a>

        
    </form>

</body>
</html>
<?php ob_end_flush(); ?>