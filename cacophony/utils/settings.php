<?php

// Note: This is a demo only. Don't store emails
// in a text file like this on a real site!

$realname=$_POST["realname"];
$username=$_COOKIE['username'];
$filename='../server/php/StoryFile/'.$username.'/'.$realname.'.js';
$fileDir='../server/php/StoryFile/'.$username;
if(!file_exists($fileDir)){
	mkdir($fileDir);
}
$fp= fopen ($filename, 'w');
fwrite ($fp, "_s[0] = [
	{a:'bg_fade_in'}];");
fclose ($fp);

$data=$_POST["data"];
$file='../server/php/StoryFile/'.$username.'/info_'.$realname.'.json';
$fb= fopen ($file, 'w');
fwrite ($fb, $data);
fclose ($fb);

$fp = fopen ($filename, 'a');
fwrite ($fp, "\n");

$data=json_decode($data);
writeText($data->text,$fp);

writeInputText($data->inputText,$fp);

writeQCM($data->qcm,$fp);

fclose ($fp);

function writeText($text,$fp){
	$textRows=$text->rows;

	foreach($textRows as $row){
	 $write="_s[".$row->time."]=[{a:'lyrics', d:{txt:\"";
	 $write.=$row->msg."\",x: 100, y: 100,
	 colour:'rgba(0, 0, 0, 1)' }}];\n";
	 fwrite ($fp,$write);
	}
}

function writeInputText($inputText,$fp){
	
	$inputTextRows=$inputText->rows;

	foreach($inputTextRows as $row){
	 $write="_s[".$row->time."]=[{a:'input_text', d:{msg:\"";
	 $write.=$row->msg;
	 $write.="\",thanks:\"Thanks for your input\",
		save_to: 'save_input.php?filename=".$realname."',jump_to:";
	 $write.=$row->jumpTo."}},
		{a:'pause'}]; \n";
	 fwrite ($fp,$write);
	}
}

function writeQCM($qcm,$fp){
	
$qcmRows=$qcm->rows;	
    foreach($qcmRows as $row){
		// pour tous les rows
		$options=$row->options;
		print_r($options);
		$nb=count($options);
		$write="_s[".$row->time."]=[{a:'input_branching', d:{msg:\"";
		$write.=$row->msg;
		$write.="\",options:[";
		$i=0;
		while($i<$nb-1){
			if (is_numeric($options[$i]->jumpTo)) {
			$write.="{choice:\"".$options[$i]->option."\",jump_to:".$options[$i]->jumpTo."},";
			}else{
			 $write.="{choice:\"<a target='_blank' href='".$options[$i]->jumpTo."'>".$options[$i]->option."</a>\"},";	
			}
			$i++;
		}
		if (is_numeric($options[$i]->jumpTo)) {
		$write.="{choice:\"".$options[$i]->option."\",jump_to:".$options[$i]->jumpTo."}]}},{a:'pause'}];\n";
		}else{
			$write.="{choice:\"<a target='_blank' href='".$options[$i]->jumpTo."'>".$options[$i]->option."</a>\"}]}},{a:'pause'}];\n";
		}
		fwrite ($fp,$write);
	}
}
?>