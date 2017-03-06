<?php
 ob_start();
 session_start();
 require('Database.php');
 
//makes it so you wont ever see login page if you are logged in.
if ( isset($_SESSION['user'])!="" ) {
header("Location: main.php");
exit;
 }
 
 $error = false;
 
 if( isset($_POST['login']) ) { 
  
  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs
  if(empty($email)){
   $error = true;
   $emailError = "Please enter your email address.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  }
  
  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }

  // if there's no error, continue to login
  if (!$error) {
    $res =mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
    $row=mysql_fetch_array($res);
    if(strcmp($row['userPass'],$pass)==0) {
      $_SESSION['user'] = $row['userId'];
      mysql_query("UPDATE 'useractivity' SET 'userlogin' = now() WHERE 'userId'=" .$_SESSION['user']);
      header("Location: main.php");

    } else {
      $errMSG = "Incorrect Credentials, Try again...";
      }

    //finds the id field with matching emails
    $idq = mysql_query("SELECT userId FROM users WHERE userEmail= '$email'");

    //gets the id row
    $idr = mysql_fetch_array($idq);
    $id = $idr['userId'];
    //matches id with user activity id so that the users activity is tracked
    $query1= "INSERT INTO useractivity(userid) VALUES ('$id')";
    mysql_query($query1);



    
  }
  
 }
?>
<!DOCTYPE html>
<html>
<head>
<title> Login To Josh's Website:</title>
</head>

  <form method="post" action="" autocomplete="off">
    
   <h2> Please Enter Your Email And Password</h2>

    <?php
      if(isset($errMSG)){
            ?>
        <?php echo $errMSG; ?>


        <?php

    }
      ?>

      <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />

                <span class="text-danger"><?php echo $emailError; ?></span>
            
      <input type="pass" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
      <?php echo $passError; ?></span>
            
            
            
           
      <input class="btn btn-lg btn-success btn-block" type="submit" value="Log-In" name="login" >
     
      <ul>    
      <li><a href="register.php">No account? Sign Up Here</a></li>
      <li><a href="email2.php">Email Me Directly</a></li>
      </ul>

   
    </form>

</body>
</html>
<?php ob_end_flush(); ?>