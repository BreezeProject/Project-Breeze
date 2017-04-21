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
 // Upload
$fileName = 'testfile.txt'
$fileSize = '1000mb'
$fileType = '.docx'
 $query = "INSERT INTO upload (name, size, type, content ) ".
"VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
$results = mysql_query($query);

if ($results){
	$test4_pt1 = 'Test 4 part 1 Passed';
}
else{
	$test4_pt1 = 'Test 4 part 1 Failed'
}
// Download

$id    = 'Student';
$query = "SELECT name, type, size, content " .
         "FROM upload WHERE id = '$id'";
$results = mysql_query($query);
if($results){
	$test4_pt2 = 'Test 4 Part 2 Passed';
}

else {
	$test4_pt2 = 'Test 4 Part 2 Failed';

}

// 5. Assign a Student to a class
$id = 'Admin';
$classID = 'CS386';
$query = "INSERT INTO classlists(ClassID, StudentID) VALUES('$classID','$id')";
$results = mysql_query($query);

if($results){
	$test5 = 'Test 5 Passed';
}
else {
	$test5 = 'Test 5 Failed';
}

// 6. View all Classes as a Student
$userID = 'Student';
$query = "SELECT classID FROM classlists WHERE StudentID='$userID'";
$results = mysql_query($query);
if($result){
	$test6 = 'Test 6 Passed';
}

else{
	$test6 = 'Test 6 Failed';
}
// Echo Results
echo $testOne; 
echo $testTwo; 
echo $testThree; 
echo $test4_pt1;
echo $test4_pt2;
echo $test5;
echo $test6;
_
?>
