<?php
 ob_start();
 session_start();
 require_once 'Database.php';

 // if session is not set this will redirect to login page
 if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
 }else{
   // select the logged in users row to display their name
   $user = $_SESSION['userID'];
   $res=mysql_query("SELECT userName FROM users WHERE userID='$user'");
   $userRow=mysql_fetch_array($res);
   $name = $userRow['userName'];
   $name = explode(' ',trim($name));
   $name = $name[0];
}
?>
<!DOCTYPE html>
<html>
<head>

<title> Breeze </title>
<h2> Welcome back <?php echo $name ?>.</h2>
</head>
<body>
<ul>
  <li><a href='edit.php'>Change Account Info</a></li>
  <?php
    if($_SESSION['userType']== "Admin"){

  ?>
  <li><a href = 'admin.php'>Admin Page</a></li>
  <?php
  }
  ?>
  <?php
    if($_SESSION['userType']== "Teacher"){

  ?>
  <li><a href = 'teacher.php'>Teacher Page</a></li>
  <?php
  }
  ?>
  <?php
    if($_SESSION['userType']== "Student"){

  ?>
  <li><a href = 'student.php'>Student Page</a></li>
  <?php
  }
  ?>
  <li><a href='logout.php'>Log Out</a></li>
  </ul>
  </body>
</html>
<?php ob_end_flush(); ?>

