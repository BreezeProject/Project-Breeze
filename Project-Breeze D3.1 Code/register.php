<?php
 ob_start();
 session_start();
 if( isset($_SESSION['user'])!="" ){
  header("Location: main.php");
 }
 include_once 'Database.php';

 $error = 0;

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  //Name Error Checking
  if (empty($name)) {
   $error = 1;
   $nameError = "Please enter your full name.";
  } else if (strlen($name) < 2) {
   $error = 1;
   $nameError = "Name must have at least 2 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
   $error = 1;
   $nameError = "Name must only use the alphabet or spaces.";
  }
  
  //Email Error Checking
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = 1;
   $emailError = "Please enter valid email address.";
  } else {
   // check if the email exists already
   $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = 1;
    $emailError = "Provided Email is already in use.";
   }
  }
  // Password Error Checking
  if (empty($pass)){
   $error = 1;
   $passError = "Please enter password.";
  } else if(strlen($pass) < 7) {
   $error = 1;
   $passError = "Password must have atleast 7 characters.";
  }

  
  // if no error sign the user up into the database
  if($error==0) {
    
    //puts the information into the database
    $query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$pass')";
    $results = mysql_query($query);


    //error checking
    if ($results) {
      $errTyp = "success";
      $errMSG = "Successfully registered, you may login now";
      unset($name);
      unset($email);
      unset($pass);
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
<title> Register for Josh's Website!</title>
</head>
<body>



  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    

  <h2 class="">Sign Up for an Account:</h2>


            
<?php
   if ( isset($errMSG) ) {
    
    ?>
      <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
<?php echo $errMSG; ?>

       </div>
<?php
   }
   ?>
            
             <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" />

                <span class="text-danger"><?php echo $nameError; ?></span>

            
             <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
              
                <span class="text-danger"><?php echo $emailError; ?></span>
            
            
             <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                
                <span class="text-danger"><?php echo $passError; ?></span>
 
            
            
             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            

             <a href="index.php">Sign in Here</a>
             <a href = "email2.php">Send an Email Instead</a>

        
    </form>

</body>
</html>
<?php ob_end_flush(); ?>