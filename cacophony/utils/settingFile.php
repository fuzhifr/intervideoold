<?php
	
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.php');
	Global $USER;
	$userid=$USER->id; 
	$realname=$_POST["realname"];
	
	$dir_file= '../server/php/StoryFile/'.$userid.'/Info_'.$realname.'.json';
	if(file_exists($dir_file)){
		$json=file_get_contents($dir_file);	
		print_r($json);
	}else{
		echo "no exists";
	}
	
?>