<?php
session_start();
include('Database.php');
//creates variables for the input
$email = $subject = $message =$toEmail =$fromEmail = "";
$toId  = $fromId = 0;
$toEmail =  $fromEmail ="";
$read = 0;
$check = 0;


//creates error variables so that they can be printed if errors occur
$messError = $error= "";


if(isset($_SESSION['user']))
{
	//gets subject from read.php button clicks
	if($_POST['rreply']){
		$_SESSION['subject'] = $_POST['reply1'];
	}
	if($_POST['ureply']){
		$_SESSION['subject'] = $_POST['reply'];
	}
	
if ( isset($_POST['submit1']) ) {
	// clean user inputs to prevent sql injections
	$message = trim($_POST['message']);
	$message = strip_tags($message);
	$message = htmlspecialchars($message);

	//error handling
	if(empty($message)){
		$check = 1;
		$messError = "Message cannot be blank";
	}
	//no errors
	if($check==0){
		//creates the variables to reply and send message to DB
		$fromId = (int) $_SESSION['user'];
		$subject = $_SESSION['subject'];
		$query1 = "SELECT * FROM users WHERE userId='$fromId'";
	    $result1 = mysql_query($query1);
	    if($result1){
	    	$row = mysql_fetch_array($result1);
	    	$fromEmail = $row['userEmail'];

	    }else{
	    	$error = "Id does not match system id,  How?";
	    	$check = 1;
	    }

	    //checks the subject to know which message it is and gets user info
	    $result2 = mysql_query("SELECT * FROM `messages` WHERE `toid` = '$fromId' AND subject = '$subject'");
	    $row3 = mysql_fetch_array($result2);

	    if($result1){
	    	$toId =  (int) $row3['fromid'];
	    	$toEmail = $row3['fromEmail'];
	    }else{
	    	$error = "Horrible Error";
	    	$check = 1;
	    }

	 
	 	//inserts data into the table messages
	 	$query3 = "INSERT INTO `messages` (`fromid`, `fromEmail`, `toid`, `toEmail`, `subject`, `message`, `read`, `date`)
	 	VALUES('$fromId','$fromEmail','$toId','$toEmail','$subject','$message','$read', CURRENT_TIMESTAMP)";
    	$results3 = mysql_query($query3);
 

	    //error checking
	    if ($results3) {
	    	$error = "Success";
	    	echo "<h3>Success Message Sent</h3>";
	    	echo "<a href = 'read.php'>Go Back To Messages</a>";
		}else{
			$error = "ERROR inserting into Table";
		}

}

}

}else{
	header("Location: index.php");
}


?>
<html>
<head>
	<title> Messaging</title>
	<h3> Reply to the user <?php echo $toEmail; ?> </h3>
	<h3> <?php echo $subject; ?></h3>
	<link href="css.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<form method = "post" action="">
<!-- Creates a CSS table for the inputs -->
<div class = "table">
	<span class = "error">* <?php echo $error;?></span>

	<div class = "row">
		<div class = "col">Message:</div>
		<div class = "col"><textarea name ="message" cols="80" rows= "20"><?php echo $message;?></textarea></div>
		<span class = "error">* <?php echo $messError;?></span>
	</div>

	<div class = "row">
		<div class = "col"><input type="submit" name = "submit1" value ="Submit"></div>
	</div>
</div>
</form>



</body>
