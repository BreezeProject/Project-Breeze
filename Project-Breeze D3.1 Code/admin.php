<?php
session_start();
include('Database.php');
 if( isset($_SESSION['userType'])!="Admin" ){
  header("Location: main.php");
 }
 
  if( !isset($_SESSION['userID']) ) {
  header("Location: index.php");
  exit;
  
 }
?>
<html>
<head>
<p> Administative Actions</p>

</head>
<body>
<ul>
	<li><a href="registerStudent.php">Create a new user</a></li>
	<li><a href="registerClass.php">Create a new class</a></li>
	<li><a href="register.php">Remove a class</a></li>
	<li><a href="register.php">Assign a student to a class</a></li>
	<li><a href="register.php">Unassign a student from a class</a></li>
	<li><a href="main.php">Home</a></li>
 </ul>
</html>

