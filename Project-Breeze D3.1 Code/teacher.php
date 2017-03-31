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
?>
<html>
<head>
<p> Teacher Actions</p>

</head>
<body>
<ul>
	<li><a href="classList.php">My Classes</a></li>
	<li><a href="grade.php">Grade</a></li>
	<li><a href="main.php">Home</a></li>
 </ul>
</html>

