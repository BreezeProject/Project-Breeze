<?php
 ob_start();
 session_start();
 require_once 'Database.php';
 $admin = 13;
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }else{
   // select the logged in users row to display their name
   $res=mysql_query("SELECT userName FROM users WHERE userId=".$_SESSION['user']);
   $userRow=mysql_fetch_array($res);
   $name = $userRow['userName'];
}
?>
<!DOCTYPE html>
<html>
<head>

<title>Welcome to The Website! </title>
<h2>Login was Successful! Thank you <?php echo $name; ?>! Enjoy!</h2>
</head>
<body>
<ul>
  <li><a href="message.php">Message Another User</a></li>
  <li><a href="index2.html">About Me</a></li>
  <li><a href="pictures.html">Pictures</a></li>
  <li><a href='edit.php'>Change User Info</a></li>
  <li><a href='logout.php'>Log Out Here</a></li>
  <li><a href='print.php'>Print Database Table Here</a></li>
  <li><a href='read.php'>Read messages</a></li>
  <?php
    if($_SESSION['user']== $admin){

  ?>
  <li><a href = 'admin.php'>Super Secret Admin Page</a></li>
  <?php
  }
  ?>
  </ul>



</html>
<?php ob_end_flush(); ?>