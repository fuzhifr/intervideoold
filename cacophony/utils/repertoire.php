<?php
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.php');
	Global $USER;
	$username=$USER->username; 
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
		$resultat=array(
		  "fileList"=>$fileList,
		  "username"=>$username
			);
		echo json_encode($resultat);
	}else{
		mkdir($current_dir);
	}
?>