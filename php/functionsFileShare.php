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
		echo '<tr>';
		echo '<td>'.$result['name'].'</td>';
		if(!$result['isdir']){
			$size = writeSize($result['size']);
			echo '<td>'.$size.'</td>';
			echo '<td><a href="'.$result['link'].'">Download</a></td>';
		}else{
			echo '<td>---</td>';	
			echo '<td><a href="#">Go inside</a></td>'; //TODO
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

?>