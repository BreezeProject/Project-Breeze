<?php
session_start();
include('Database.php');
//THIS PHP FILE IS FOR SENDING MESSAGES TO OTHER USERS

//creates variables for the input
$email = $subject = $message =$toEmail =$fromEmail = "";
$toId  = $fromId = 0;
$toEmail =  $fromEmail ="";
$read = 0;
$check = 0;
$run = 1;

//creates error variables so that they can be printed if errors occur
$emailError = $subError  = $messError = $error= "";


if(isset($_SESSION['user']))
{

if ( isset($_POST['submit']) ) {
	$run =0;
	 // clean user inputs to prevent sql injections
	$subject= trim($_POST['subject']);
	$subject = strip_tags($subject);
	$subject= htmlspecialchars($subject);

	$email = trim($_POST['email']);
	$email = strip_tags($email);
	$email = htmlspecialchars($email);
	  
	$message = trim($_POST['message']);
	$message = strip_tags($message);
	$message = htmlspecialchars($message);

	if(!empty($email)){
		// check if the email exists already
	    $query = mysql_query("SELECT userEmail FROM users WHERE userEmail = '$email'");
	    if($query && mysql_num_rows($query)> 0){
	   		$toEmail = $email;
   		}else{
   			$check = 1;
	    	$emailError = "Provided Email is not in Database";
   		}

	}else{
		$check = 1;
		$emailError = "Email cannot be blank";
	}
	//subject check
	if(empty($subject)){
		$check = 1;
		$subError = "Subject cannot be blank";
	}
	if(empty($message)){
		$check = 1;
		$messError = "Message cannot be blank";
	}
	//error check
	if($check==0){
		//accesses tables to get the variables necessary to fill message table
		$fromId = (int) $_SESSION['user'];
		$query1 = "SELECT * FROM users WHERE userId='$fromId'";
	    $result1 = mysql_query($query1);
	    if($result1){
	    	$row = mysql_fetch_array($result1);
	    	$fromEmail = $row['userEmail'];

	    }else{
	    	$error = "Id does not match system id,  How?";
	    	$check = 1;
	    }

	    //selects user from the given email and gets his ID
	    $query2 = "SELECT * FROM users WHERE userEmail='$email'";
	    $result2 = mysql_query($query2);
	    if($result2){
	    	$row1 = mysql_fetch_array($result2);
	    	$toId = (int) $row1['userId'];
	 	}else{
	 		$error = "Email dissapeared from the database or DNE somehow";
	 		$check = 1;
	 	}

	 	//inputs the data into new row of the messages table 
	 	$query3 = "INSERT INTO `messages` (`fromid`, `fromEmail`, `toid`, `toEmail`, `subject`, `message`, `read`, `date`)
	 	VALUES('$fromId','$fromEmail','$toId','$toEmail','$subject','$message','$read', CURRENT_TIMESTAMP)";
    	$results3 = mysql_query($query3);
 

	    //error checking
	    if ($results3) {
	    	$error = "Success";
	    	echo "<h3>Success Message Sent</h3>";
	    	echo "<a href = 'main.php'>Go Back Home!!</a>";
		}else{
			$error = "fudge";
		}

}

}
//if accessed via non-logged in go to login
}else{
	header("Location: index.php");
}


?>
<html>
<head>
	<title>Messaging</title>
	<h3> Send A Message To Another User </h3>
	<h5> Use jls865@nau.edu to message the admin, or input the other users email</h5>
	<link href="css.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<form method = "post" action="">
<!-- Creates a CSS table for the inputs -->
<div class = "table">
	<span class = "error">* <?php echo $error;?></span>

	<div class = "row" >
		<div class = "col">User Email:</div>
		<div class = "col"><input type="text" name = "email" size= "105" value = "<?php echo $email;?>"></div>
		<span class = "error">* <?php echo $emailError;?></span>
	</div>

	<div class = "row">
		<div class = "col">Subject:</div>
		<div class = "col"><input type="text" name = "subject" size="105" value = "<?php echo $subject;?>"></div>
		<span class = "error">* <?php echo $subError;?></span>

	<div class = "row">
		<div class = "col">Message:</div>
		<div class = "col"><textarea name ="message" cols="80" rows= "20"><?php echo $message;?></textarea></div>
		<span class = "error">* <?php echo $messError;?></span>
	</div>

	<div class = "row">
		<div class = "col"><input type="submit" name = "submit" value ="Submit"></div>
	</div>
</div>
</form>



</body>
