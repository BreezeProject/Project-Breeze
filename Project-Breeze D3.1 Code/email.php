<?php
//email form to get familair with PHP and to set up the form to get input.
//Create variables for the input here.
$name = $email = $subject = $message = $type = $reply = $date ="";
$check = 0;



//creates error variables so that they can be printed if errors occur
$emailError = $nameError = $subError = $typeError = $messError = "";
$myEmail ="jls865@nau.edu";

if($_SERVER["REQUEST_METHOD"] == "POST"){

	//checks if name is empty throws error if it is
	if(empty($_POST["name"])){
		$nameError = "Name is required";
	}else{
		$name = getInput($_POST["name"]);//saves value of name
	}
	
	//checks if the email field is empty and throws error
	if(empty($_POST["email"])){
		$emailError = "email is required";

	//checks to see if the appropriate endings are on the email

	}elseif(strpos(getInput($_POST["email"]), '.com') ||
		strpos(getInput($_POST["email"]), '.gov') ||
		strpos(getInput($_POST["email"]), '.edu') ||
		strpos(getInput($_POST["email"]), '.org') !== false){

			if(strpos(getInput($_POST["email"]), '@') !==false){
				$email = getInput($_POST["email"]); //saves value of email
				$check = 1;

			}else{$emailError = "Email must contain @";}

	}else{
		//if the email doesnt contain the endings error
		$emailError = "EMAIL must be of type @/ .gov/.org/.edu/.com";

		
	}
	
	//checks if subject is empty and error checking
	if(empty($_POST["subject"])){
		$subError = "Subject is required";
	
	}else{
		$subject = getInput($_POST["subject"]);//saves value of subject
		$check = 1;
	}

	//checks message emptiness and displays error
	if(empty($_POST["name"])){
		$messError = "Message is required";
	}else{
		$message = getInput($_POST["message"]);//saves message to variable message
		$check = 1;
	}
	
	//checks if type is empty and errors

	if(empty($_POST["type"])){
		$typeError = "Type is required";
		
	}else{
		$type =  $_POST["type"]; //gets the type of email
		$check = 1;
	}

	//reply is not necessary for error because it can be unchecked
	if(isset($_POST["reply"])){
		$reply = " reply pls ";
		$check = 1;
	}
	

}
//this was a variable I created to check if input was given for all fields
//at first I was just checking if it was empty which when the page was loaded it would send blank email
if($check == 1){

	//double checks to make sure the errors are empty
	if(empty($typeError) &&  empty($messError) && empty($nameError) && empty($subError) &&empty($emailError)==true){
		$date = date('l jS \of F Y h:i:s A');

		//mail function that sends the email with proper inputs
		mail("{$myEmail} {$email}", "$subject", "From: {$name},\n {$message}\n{$reply} \n{$type} \n{$date}",
		 ("From: ". $email . "\r\n" ."Cc:" . $email . "\r\n"));
		$typeError = "Your email was sent!!!!!";

	}else{$emailError = "Email was NOT sent, bad input\n";}
     
}



//function that trims down whitespace and removes slashes and assigns the data accordingly
function getInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
<http>
<head>
	<title>Email Josh</title>
	<link href="css.css" type="text/css" rel="stylesheet"/>
</head>
	<h3>Email me for questions, comments, urgencies, or business inquiries:</h3>

<body id = "email">
	<ul>
	<li><a href="index.html">Home</a></li>
	<li><a href="pictures.html">Pictures(Proj2Homepage)</a></li>
	</ul>


<form method = "post" action="">
<!-- Creates a CSS table for the inputs -->
<div class = "table">

	<div class = "row" >
		<div class = "col">Email:</div>
		<div class = "col"><input type="text" name = "email" size= "100" value = "<?php echo $email;?>"></div>
		<span class = "error">* <?php echo $emailError;?></span>
	</div>

	<div class = "row">
		<div class = "col">Name:</div>
		<div class = "col"><input type="text" name = "name" size= "100" value = "<?php echo $name;?>"></div>
		<span class = "error">* <?php echo $nameError;?></span>
	</div>

	<div class = "row">
		<div class = "col">Subject:</div>
		<div class = "col"><input type="text" name = "subject" size="100" value = "<?php echo $subject;?>"></div>
		<span class = "error">* <?php echo $subError;?></span>

	<div class = "row">
		<div class = "col">Message:</div>
		<div class = "col"><textarea name ="message" cols="100" rows= "10"><?php echo $message;?></textarea></div>
		<span class = "error">* <?php echo $messError;?></span>
	</div>



	<div class = "row">
		<div class = "col">Type of email:</div>
		<div class = "col"><input type="radio" name="type" value="Question">Question
	    	<input type="radio" name="type" value="Comment">Comment
	    	<input type="radio" name="type" value="Urgent">Urgent</div>
		<span class = "error">* <?php echo $typeError;?></span>
	</div>

	<div class = "row">
		<div class = "col"><input type="checkbox" name="reply" value="Return">Do you want a reply?</div>		
	</div>

	<div class = "row">
		<div class = "col"><input type="submit" name = "submit" value ="Submit"></div>
	</div>
</div>
</form>


	
</body>
</http>