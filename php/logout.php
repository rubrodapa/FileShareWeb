<?php
	include 'functions.php';
	sec_session_start();
	
	//Unset the session values
	$_SESSION = array();
	
	//Get session parameters
	$params = session_get_cookie_params();
	
	//Delete the actual cookie
	setcookie(session_name(), '', time() - 42000, $params['path'], $params["domain"], $params["secure"], $params["httponly"]);
	
	//Destroy the session
	session_destroy();
	header('Location: ../index.php');
?>