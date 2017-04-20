<?php 
// Unit testing for Breeze
// Unit tests are done in order shown below
//
// 1. Login and Logout of Admin
// 2. Create and Delete a User
// 3. Create and Delete a Class
// 4. Upload and Download a file as a Student
// 5. Assign a Student to a class
// 6. View all Classes as a Student

// 1. Login and Logout of Admin
$id = 'Admin';
$pass = 'Password';
// Test Login
$res = mysql_query("SELECT userID, userName, userPassword, userEmail, userType FROM users WHERE userID='$id'");
$row = mysql_fetch_array($res);
if(strcmp($row['userPassword'],$pass) == 0) {
	// Test Logout 
	header("Location: logout.php");
	if(isset($_SESSION['userID']) != "" ) {
		$testOne = "Test One Fail\n";
	} else {
		$testOne = "Test One Pass\n";
	}
} else {
	$testOne = "Test One Fail\n";
}

// 2. Create and Delete a User
$id = 'TestStudent';
$name = 'TestStudent';
$pass = 'Password';
$email = 'Student@Student.com';
$type =  'Student';
$query = "INSERT INTO users(userID,userName,userPassword,userEmail,userType) VALUES('$id','$name','$pass','$email', '$type')";
$results = mysql_query($query);
//error checking
if ($results) {
  $testTwo = "Test Two Pass\n";
 } else {
  $testTwo = "Test Two Fail\n";
 } 

// 3. Create a Class
$ClassName = 'TestClass';
$TID = 'TestTeacher';
$CLocation = 'TestLocation';
$MaxStudents = '100';
$StartTime = '01:00';
$EndTime = '12:00';
$DayMonday = 'M';
$DayTuesday = 'T';
$DayWednesday = 'W';
$DayThursday = 'Th';
$DayFriday = 'F';
$ClassDesc = 'TestDescription';
// Register Class
$query = "INSERT INTO classes(Name, TeacherID, Location, MaxNumStudents, StartTime, EndTime, DaysOfWeek, Desciption) VALUES('$ClassName','$TID','$CLocation','$MaxStudents','$StartTime','$EndTime','$DayMonday $DayTuesday $DayWednesday $DayThursday $DayFriday','$ClassDesc')";
$results = mysql_query($query);
if ($results) {
	// Register ID as Teacher for Class
	$query = "SELECT * FROM classes ORDER BY ID DESC LIMIT 1";
	$results = mysql_query($query);
	$classID = mysql_fetch_array($results);
	$classID = $classID['ID'];

	$query = "INSERT INTO classlists(ClassID, StudentID) VALUES('$classID','$TID')";
	$results = mysql_query($query);
	if ($results) {
		$testThree = "Test Three Pass\n";
	} else {
		$testThree = "Test Three Fail\n";
	} 
 } else {
	$testThree = "Test Three Fail\n";
 } 


// 4. Upload and Download a file as a Student
// 5. Assign a Student to a class
// 6. View all Classes as a Student
// Echo Results
echo $testOne; 
echo $testTwo; 
echo $testThree; 
?>
