<?php
 ob_start();
 session_start();
 require('Database.php');
 
//makes it so you wont ever see login page if you are logged in.
if ( isset($_SESSION['userID'])!="" ) {
header("Location: main.php");
exit;
 }
 
 $error = false;
 
 if( isset($_POST['login']) ) { 
  
  // prevent sql injections/ clear user invalid inputs
  $id = trim($_POST['id']);
  $id = strip_tags($id);
  $id = htmlspecialchars($id);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs
  
  if(empty($id)){
   $error = true;
   $idError = "Please enter your User ID.";
  }
  
  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }

  // if there's no error, continue to login
  if (!$error) {
    $res =mysql_query("SELECT userID, userName, userPassword, userEmail, userType FROM users WHERE userID='$id'");
    $row=mysql_fetch_array($res);
    if(strcmp($row['userPassword'],$pass)==0) {
      $_SESSION['userID'] = $row['userID'];
	  $_SESSION['userType'] = $row['userType'];
      header("Location: main.php");

    } else {
      $errMSG = "Incorrect Credentials, Please try again.";
      }
  }
 }
?>
<!DOCTYPE html>
<html>
<head>
<title> Breeze </title>
</head>

  <form method="post" action="" autocomplete="off">
    
   <h2> Please Login </h2>

    <?php
      if(isset($errMSG)){
            ?>
        <?php echo $errMSG; ?>

        <?php

    }
      ?>

      <input type="text" name="id" class="form-control" placeholder="User ID:" value="<?php echo $id; ?>" maxlength="40" />

                <span class="text-danger"><?php echo $idError; ?></span>
            
      <input type="password" name="pass" class="form-control" placeholder="Password:" maxlength="15" />
      <span class="text-danger"><?php echo $passError; ?></span>
           
      <input class="btn btn-lg btn-success btn-block" type="submit" value="Log In" name="login" >
     
      <ul>    
      <li><a href="email2.php">Contact an Admin</a></li>
      </ul>

   
    </form>

</body>
</html>
<?php ob_end_flush(); ?>