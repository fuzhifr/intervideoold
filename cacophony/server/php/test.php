<?php

require_once('../../../../../config.php');

	class UploadHandler
	{
		
		public static function getUsername(){	
			Global $USER;
			return  $USER->username;
		}
	}
	
	$name=UploadHandler::getUsername();
	echo $name;
?>