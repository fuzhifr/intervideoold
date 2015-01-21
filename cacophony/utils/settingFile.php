<?php
	$realname=$_POST["realname"];
	$username=$_COOKIE['username'];
	$dir_file= '../server/php/StoryFile/'.$username.'/Info_'.$realname.'.json';
	if(file_exists($dir_file)){
		$json=file_get_contents($dir_file);
		print_r($json);
	}else{
		echo "no exists";
	}
?>