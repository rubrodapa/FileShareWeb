<?php
	include_once 'php/db_connection.php';
	include_once 'php/functions.php';
	
	sec_session_start();
	
	//checks if the user is logged in, if not make it go to the index
	if(login_check($mysqli) == false) {
	  header('Location: ./index.php?error=3');
	}
?>