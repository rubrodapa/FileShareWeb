<?php
	include 'db_connection.php';
	include 'functions.php';
	sec_session_start();
	
	if(isset($_POST['email'],$_POST['p'])){
		$email = $_POST['email'];
		$password = $_POST['p']; //Remember that the password is hashed one time from the client side
		
		if(login($email,$password, $mysqli) == true){
			//Login success
			print_r($_SESSION);
			header('Location: ../fileshareweb.php');
		}else{
			//Login fail
			header('Location: ../index.php?error=1');
		}
	}else{
		//No correct POST variables
		echo 'Invalid request';
	}
?>