<html>
<head>
<script language = "JavaScript">
//function that validates input
function valid_form(){
	//store input variables
	var user_name = document.getElementById('user_name');
	var email = document.getElementById('email');
	var subject = document.getElementById('subject');
	var message = document.getElementById('message');
	var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;

	//checks if its empty
	if(!user_name.value){
	alert("Enter Your Name Please");
	user_name.focus();
	return false;
	}
	//checks if its a valid email and empty
	if(!email.value || !email.value.match(re)){
	alert("Enter Your Valid Email Please");
	email.focus();
	return false;
	}
	if(!subject.value){
	alert("Enter a Subject Please");
	subject.focus();
	return false;
	}
	if(!message.value){
	alert("Enter a Message Please");
	message.focus();
	return false;
	}
}
</script>

<link rel="stylesheet" type="text/css" href="mainstyle.css">
<title>Email Form</title>
</head>
<body>
<?php
//turns form display on
$display = true;
//checks if submit was clicked
if(isset($_POST['submit']))
{
	send_email($_POST['user_name'], $_POST['email'], $_POST['subject'], $_POST['message']);
	//turns off display
	$display = false;
}

//creates the email fields and sends email
function send_email($user_name, $email, $subject, $message){
	$my_email = 'jls865@nau.edu';

	$message = "{$message} {$user_name}";
	mail($my_email, $subject, $message, "From:".$email);

	//displays this after mail success
	echo "<h2> Email Sent! </h2>";
	echo "<h4><a href = 'index.php'>Back to Login</a></h4>";


}
//shows form if it has not been submitted
if($display==true) {
 ?>

<h3>Fill Out Email Form to Email Admin</h3>
	<table border = "4">
	<form id = "form" action = "email2.php" method ="POST">
	<tr>
	<td>Your Name-</td>.
	<td><input id ="user_name" name = "user_name" type= "input" size ="100"/></td>
	</tr>

	<tr>
	<td>Your Email-</td>.
	<td><input id ="email" name = "email" type= "input" size ="100"/></td>
	</tr>
	<tr>
	<td>Subject-</td>.
	<td><input id ="subject" name = "subject" type= "input" size ="100"/></td>
	</tr>

	<tr>
	<td>Message</td>.
	<td><textarea id = "message" name ="message" cols="76" rows= "10"></textarea></td>
	</tr>

	<tr>
	<td><input id = "submit" onclick = "return valid_form();" name = "submit" type = "submit" value = "Send"/></td>
	</tr>
</table>

</form>



</body>
</html>
<?php } ?>