<?php
//save les inputs dans le fichier csv
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.php');
Global $USER;
//client qui repond ce question
$inputuser=$USER->username; 

$username=$_GET['username'];
$realname=$_GET['realname'];
$questionName=$_GET['questionName'];
$dir = '../server/php/inputTextResultat/'.$username.'/';
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
	fputcsv ($fp, array($inputuser,$_POST['input']));
	flock($fp,LOCK_UN);
}else{
	echo "Error ecrit le fichier";
}
	fclose ($fp);
	
	
?>