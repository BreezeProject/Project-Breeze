<?php
 ob_start();
 session_start();
 include_once 'Database.php';

 if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
 }
 
 $error = 0;

  if ( isset($_POST["btn-change"]) ) {
  
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

  
    //Email Error Checking
    if(strlen($email) != 0){
      // check if the email exists already
      $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
      $result = mysql_query($query);
      $count = mysql_num_rows($result);

      //makes sure its a valid email
      if(!filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = 1;
        $emailError = "Please enter valid email address.";
      }

      if($count!=0){
        $error = 1;
        $emailError = "Provided Email is already in use.";
      }
    
    }
  
    // if no error change the records in the database
    if($error==0) {
	  $user = $_SESSION['userID'];
      //checks if there is a password to change
      if(!empty($pass)){
        $query1 = mysql_query("UPDATE users SET userPass = '$pass' WHERE userID='$user'");

      }
      //checks to see if there is a name to change
      if(!empty($name)){
          //Name Error Checking
        $query2 = mysql_query("UPDATE users SET userName = '$name' WHERE userID='$user'");
       
        }
      
      //checks to see if there is an email to change
      if(!empty($email)){
        $query3 = mysql_query("UPDATE users SET userEmail = '$email' WHERE userID='$user'");

      //if there is no input values greater than length 0 error
      }
      if(empty($pass) && empty($name) && empty($email)){
        $errTyp = "danger";
        $errMSG = "No input values given so no changes were made";
      }
    }

    if ($query1 || $query2 || $query3) {
        $errTyp = "success";
        $sucMSG = "Successfully Saved changes";
        unset($name);
        unset($email);
        unset($pass);
    }else {
        $errTyp = "danger";
        $errMSG = "Something went wrong, try again later...";
      } 
}
?>

<!DOCTYPE html>
<html>
<head>
<title> Edit account info</title>
<link href="css.css" type="text/css" rel="stylesheet"/>
</head>
<body>

  <h2>Change your information:</h2>
  <h4>Leave Blank For No Changes</h4>

  <form method="post" action="" autocomplete="off">
    




            
<?php
   if ( !isset($errMSG) ) {
    
?>
      <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>"><?php echo $sucMSG; ?></div>

<?php 
} 

?>
      <div class = "table">

            <div class = "row">
              <div class "col">Change Name:<input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" /></div>
              
              <span class="text-danger"><?php echo $nameError; ?></span>
            </div>

            
            <div class = "row">
              <div class ="col">Change Email:<input type="email" name="email" class="form-control" placeholder="Enter Email" maxlength="40" value="<?php echo $email ?>" /></div>
              
              <span class="text-danger"><?php echo $emailError; ?></span></div>
            
            
            <div class = "row">
              <div class ="col">Change Password:<input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" /></div>
                
              <span class="text-danger"><?php echo $passError; ?></span>
            </div>
 
            
            
            <div class = "row">
              <div class ="col"><button type="submit" class="btn btn-block btn-primary" name="btn-change">Save changes</button></</div>
            </div>
            
             
            <li><a href="main.php">Home</a></li>
    
    </form>

</body>
</html>
<?php ob_end_flush(); ?>