<?php

	include 'db_connection.php';

	if(isset($_POST['p'], $_POST['username'], $_POST['email'])){

		//TODO: Validation of this values
		$username = $_POST['username'];
		$email = $_POST['email'];

		//Password hashed from form registration
		$password = $_POST['p'];
		//Create random salt
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		//Create salted password
		$password = hash('sha512', $password.$random_salt);
		
		//Insert to database
		if($insert_stmt = $mysqli->prepare("INSERT INTO members(username,email,password,salt) VALUES (?, ?, ?, ?)")){
			$insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);	
			
			if($insert_stmt->execute() == false){
				header('Location: ../index.php?error=1');
			}else{
				header('Location: ../index.php');	
			}
			
		}else{
			header('Location: ../index.php?error=2');
		}
		
	}else{
		echo 'Invalid request';	
	}
?>