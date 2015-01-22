<?php 
function downfile($fileurl,$nom,$realname)
{
$filename=$fileurl;
$fileD  =  fopen($filename, "rb"); 
header('Content-Type: application/vnd.ms-excel');
// data.csv :nom de file exporté
header('Content-Disposition: attachment;filename="'.$realname.'.csv"');
header('Cache-Control: max-age=0');

$contents = "";
$contents.=$nom."\n";
while (!feof($fileD)) {
 $contents .= fread($fileD, 8192);
}
echo $contents;
fclose($fileD); 
}

$username=$_GET['username'];
$realname=$_GET['realname'];

$dir = "../server/php/inputTextResultat/".$username."/".$realname."/";
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
	if($file != "." && $file != ".."){
		  $url=$dir.$file;
		  downfile($url,$file,$realname);
	  }
    }
    closedir($dh);
  }
}else{
	echo "false";
}
?>