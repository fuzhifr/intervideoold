<?php
//save les inputs dans le fichier csv
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.php');
Global $USER;
//client qui repond ce question
$inputuser=$USER->id; 
$inputuser_name=$USER->username;
$inputuser_email=$USER->email;
$userid=$_GET['userid'];
$realname=$_GET['realname'];
$questionName=$_GET['questionName'];
$dir = '../server/php/inputTextResultat/'.$userid.'/';
if(!file_exists($dir)){
	mkdir($dir);
}
$dirVideo=$dir.$realname.'/';

if(!file_exists($dirVideo)){
	mkdir($dirVideo);
}

$file=$questionName.".csv";
$fp = fopen ($dirVideo.$file, 'a');

if(flock($fp, LOCK_EX | LOCK_NB)){
	fputcsv ($fp, array($inputuser,$inputuser_name,$inputuser_email,$_POST['input']));
	flock($fp,LOCK_UN);
}else{
	echo "Error ecrit le fichier";
}
	fclose ($fp);
	
	
?>