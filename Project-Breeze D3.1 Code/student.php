<?php
session_start();
include('Database.php');
 if( isset($_SESSION['userType'])!="Student" ){
  header("Location: main.php");
 }
 
  if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
  
 }
?>
<html>
<head>
<p>Student Page</p>

</head>
<body>
<ul>
	<li><a href="classList.php">View My Classes</a></li>
	<li><a href="main.php">Home</a></li>
	
	
 </ul>
</html>

