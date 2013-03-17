<?php
	include_once 'php/db_connection.php';
	include_once 'php/functions.php';
	
	sec_session_start();
	
	if(login_check($mysqli) == false) {
	  header('Location: ./index.php?error=3');
	}
?>