<?php
	include_once 'functionsFileShare.php';
	include_once 'db_connection.php';
	include_once 'functions.php';
	
	sec_session_start();
	
	//checks if the user is logged in, if not make it go to the index
	if(login_check($mysqli) == false) {
	  header('Location: ./index.php?error=3');
	}
	
	//Get the directory where we want to change
	if(isset($_GET['d'])){
		$dir = $_GET['d'];
		//If it is not go up, add the character '/'
		if($dir != '..'){
			$dir = $dir.'/';	
		}
		//Change the directory at the Session and go back to the main page
		changeDir($dir);
		header('Location: ../fileshareweb.php');
		
	}else{
		echo 'Invalid Request';	
	}

?>