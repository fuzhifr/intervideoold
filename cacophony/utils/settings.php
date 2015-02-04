<?php

// Note: This is a demo only. Don't store emails
// in a text file like this on a real site!

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.php');
Global $USER;
$userid=$USER->id; 
$realname=$_POST["realname"];

$filename='../server/php/StoryFile/'.$userid.'/'.$realname.'.js';
$fileDir='../server/php/StoryFile/'.$userid;
if(!file_exists($fileDir)){
	mkdir($fileDir);
}
$fp= fopen ($filename, 'w');
fwrite ($fp, "_s[0] = [
	{a:'bg_fade_in'}];");
fclose ($fp);

$data=$_POST["data"];
$file='../server/php/StoryFile/'.$userid.'/info_'.$realname.'.json';
$fb= fopen ($file, 'w');
fwrite ($fb, $data);
fclose ($fb);

$fp = fopen ($filename, 'a');
fwrite ($fp, "\n");

$data=json_decode($data);
writeText($data->text,$fp);

writeInputText($data->inputText,$fp,$userid,$realname);

writeQCM($data->qcm,$fp);

fclose ($fp);
echo json_encode($userid);

function writeText($text,$fp){
	$textRows=$text->rows;
	foreach($textRows as $row){
	 $write="_s[".$row->begin."]=[{a:'html', d:{html:\"<h2>";
	 $write.=$row->msg."</h2>\",top:".$row->y.", left:".$row->x." }}];\n";
	 $write.="_s[".$row->end."]=[{a:'clear_html'}];\n";
	 fwrite ($fp,$write);
	}
}

function writeInputText($inputText,$fp,$userid,$realname){
	
	$inputTextRows=$inputText->rows;

	foreach($inputTextRows as $row){
	 $write="_s[".$row->time."]=[{a:'input_text_lp', d:{msg:\"";
	 $write.=$row->msg;
	 $write.="\",thanks:\"Merci pour votre saisie\",
		save_to: 'utils/save_input.php?questionName=".$row->msg."&userid=".$userid."&realname=".$realname."',top:".$row->x.",left:".$row->y."}},{a:'pause'}]; \n";
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