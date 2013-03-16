<?php
	define("HOST", "localhost"); //What is the host of the DB.
	define("USER", "sec_user"); //The user of the DB. Should match to the one of your host.
	define("PASSWORD", "amwyqmaG3hcKLjH4"); //Password of the previous user on the database. Should match to the one of your host.
	define("DATABASE", "fileshareweb"); //DB name. Should match to the one of your host.
	
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
?>