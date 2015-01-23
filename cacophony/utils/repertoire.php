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
				$realname=basename($file,'.js');
				$isExist=isExistFile($realname,$username);
				$resultat=array(
					"isExist"=>$isExist,
					"realname"=>$realname
				);
				array_push($fileList,$resultat);
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
	
	function isExistFile($realname,$username){
			$dir = "../server/php/inputTextResultat/".$username."/".$realname."/";
			if (is_dir($dir)){
			  if ($dh = opendir($dir)){
				while (($file = readdir($dh)) !== false){
				if($file != "." && $file != ".."){					  
					 return "true";
				  }
				}
				return "false";
			  }
			}else{
				return "false";
			}
	}
?>