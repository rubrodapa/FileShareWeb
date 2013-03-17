<?php
//Return an array with all the files and directories at the
//directory passed as argument.
function readADir($directory){
	$i = 0;
	$result = array();
	//Open the directory
	if($handle = opendir($directory)){
		//Iterate through the directory
		while(false !== ($entry = readdir($handle))){
			//Scape the actual directory
			if($entry != "."){
				//Store the variables
				$result[$i]['name'] = $entry;
				$result[$i]['link'] = $directory.$entry;
				//See if it is a directory
				if(is_dir($directory.$entry)){
					//If it is a directory doesn't have a size
					$result[$i]['isdir'] = true;
				}else{
					//If it is not a directory, calculate the size
					$result[$i]['isdir'] = false;
					$result[$i]['size'] = filesize($directory.$entry);
				}
			}
			$i++;
		}
	}
	return $result;
}

//Write as the rows of an HTML Table the array passed as argument
//The array must be in the same structure that is given by the function readADir
function writeAsTable($filesInArray){
	foreach($filesInArray as $result){
		if($_SESSION['route']['depth'] == 0 && $result['name'] == ".."){
			continue;
		}
		
		echo '<tr>';
		if($result['name']==".."){
			echo '<td>Previous directory</td>';
		}else{
			echo '<td>'.$result['name'].'</td>';
		}
		if(!$result['isdir']){
			$size = writeSize($result['size']);
			echo '<td>'.$size.'</td>';
			echo '<td><a href="'.$result['link'].'">Download</a></td>';
		}else{
			echo '<td>---</td>';	
			echo '<td><a href="php/processDirectoryChange.php?d='.$result['name'].'">Go inside</a></td>'; //TODO
		}
		echo '</tr>';
	}
}

function writeSize($size){
	if($size<1024){
		return $size.' Bytes';
	}else if($size >= 1024 && $size < 1024*1024){
		$s = round($size/1024,2);
		return $s.' KBytes';	
	}else{
		$s = round($size/1024/1024,2);
		return $s.' MBytes';	
	}
}

//Change the directory that is listed in the mainpage
//It is stored at the session.
function changeDir($directory){
	
	$depth = $_SESSION['route']['depth'];
	$ini = "../files/";
	$i = 0;
	if($directory == ".."){
			if(!$depth<=0){
				$_SESSION['route']['depth'] = $depth - 1;	
			}
	}else{
		
		$pos = strpos($directory,'/');
		$nchar = strlen($directory);
		
		//Whe check that there is only one character '/' and it is at the end of the string.
		//To be sure that noone try to navigate where he can't
		if($pos + 1 == $nchar){
		
			$temp = $ini;
			
			while($i < $depth){
				$temp = $temp.$_SESSION['route'][$i];
				$i++;
			}
			
			$temp = $temp.$directory;
			
			if(is_dir($temp)){
				
				$_SESSION['route']['depth'] = $depth + 1;	
				$_SESSION['route'][$depth] = $directory;
			}
			
		}
		
	}
	
	
}

?>