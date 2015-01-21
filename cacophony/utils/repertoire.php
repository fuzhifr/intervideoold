<?php
	$username=$_COOKIE['username'];
	$current_dir = '../server/php/StoryFile/'.$username.'/';
	if(file_exists($current_dir)){
		$dir = opendir($current_dir);
		$fileList=array();
		while(false !== ($file=readdir($dir))){
		if($file != "." && $file != ".."){
		 $filename=pathinfo($file);
			if($filename['extension']=="js"){
				array_push($fileList, basename($file,'.js'));
			}
		 }
		}
		closedir($dir);
		echo json_encode($fileList);
	}else{
		mkdir($current_dir);
	}
?>