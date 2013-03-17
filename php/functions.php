<?php

function sec_session_start(){
	$session_name = "sec_session_id"; //Custom name for the session
	$secure = false; //If using https, put it true
	$httponly = true; //Javascript can not access to the session id
	
	ini_set('session.use_only_cookies', 1); //Force the session to use the cokies
	$cookieParams = session_get_cookie_params(); //Get the current parameters of the cokkies.
	session_set_cookie_params($cookieParams["lifetime"],$cookieParams["domain"],$secure,$httponly);
	session_name($session_name); //Set the session name to the one above.
	session_start();
	session_regenerate_id(true); //Regenerate the sesion, deleting the old one.
}

function login($email,$password,$mysqli){
	
	//Use prepared statements to avoid SQL Injection.
	if($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM members WHERE email = ? LIMIT 1")){
	
		$stmt->bind_param('s', $email); //Add the email to the query.
		$stmt->execute(); //Execute the prepared query.
		$stmt->store_result();
		$stmt->bind_result($user_id,$username,$db_password, $salt); //Get the data from the query in these variables.
		$stmt->fetch();
		$password = hash('sha512',$password.$salt); //hash the password with the unique salt.
		
		if($stmt->num_rows == 1){ 
			//If user exists
			//We check if it has done so many attempts
			if(checkbrute($user_id, $mysqli) == true){
				//Account locked.
				//Do someting because the account is locked.
				return false;	
			}else{
				if($db_password == $password){
					//Password was correct
					$ip_adress = $_SERVER['REMOTE_ADDR']; //IP adress of the user
					$user_browser = $_SERVER['HTTP_USER_AGENT']; //Browser of the user
					
					$user_id = preg_replace("/[^0-9]+/", "", $user_id); //XSS protection as we might print this value
					$_SESSION['user_id'] = $user_id;
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
					$_SESSION['username'] = $username;
					$_SESSION['login_string'] = hash('sha512', $password.$ip_adress.$user_browser);
					//Login was successful
					return true;
				}else{
					//Password not correct
					//Record in database
					$now = time();
					$mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
					return false;						
				}
			}	
		}else{
			//No user exists
			return false;	
		}
	}	
}

function checkbrute($user_id,$mysqli){
	//Get actual timestamp
	$now = time();
	//All login attempts are counted from the past 2 hours
	$valid_attempts = $now - (2 * 60 * 60);
	
	if($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time >= '$valid_attempts'")){
		$stmt->bind_param('i',$user_id);
		$stmt->execute();
		$stmt->store_result();
		//If there are more than 5 failed logins
		if($stmt->num_rows > 5){
			return true;	
		}else{
			return false;
		}
	}
}

function login_check($mysqli){
	//Check if all the session variables are set
	if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])){
		$user_id = $_SESSION['user_id'];
		$username = $_SESSION['username'];
		$login_string = $_SESSION['login_string'];
		$ip_adress = $_SERVER['REMOTE_ADDR'];
		$user_browser = $_SERVER['HTTP_USER_AGENT'];
		
		if($stmt->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")){
			$stmt->bind_param('i',$user_id);
			$stmt->execute();
			$stmt->store_results();
			
			if($stmt->num_rows == 1){ //If the user exists
				$stmt->bind_result($password);
				$stmt->fetch();
				$login_check = hash('sha512', $password.$ip_adress.$user_browser);
				if($login_check == $login_string){
					//Logged in
					return true;
				}else{
					return false;	
				}
			}else{
				return false;	
			}
		}else{
			return false;
		}
	}else{
		return false;	
	}
}

?>