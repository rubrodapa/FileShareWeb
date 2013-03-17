<?php
	//TODO: Collect data from registration form

	//Password hashed from form registration
	$password = $_POST['p'];
	//Create random salt
	$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	//Create salted password
	$password = hash('sha512', $password.$random_salt);
	
	//Insert to database
	if($insert_stmt = $mysqli->prepare("INSERT INTO members(username,mail,password,salt) VALUES (?, ?, ?, ?)")){
		$insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);	
		$insert_stmt->execute();
	}
	
	//TODO: Redirect to success or not success page
?>