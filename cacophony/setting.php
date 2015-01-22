<?php
	require_once((dirname(dirname(dirname(dirname(__FILE__))))).'/config.php');
	Global $USER;
	$username=$USER->username;
?>
<!DOCTYPE html>
<html > 
<head> 
<title>cacophony settings</title> 
<script type="text/javascript" src="build/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/settingPage.js"></script>
<script type="text/javascript" src="js/video.js"></script>
<script type="text/javascript" src="build/bootstrap.min.js"></script>
<script type="text/javascript" src="build/validator.min.js"></script>
<link href="css/video-js.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<script>
    videojs.options.flash.swf = "js/video-js.swf";

	var Request = new Object();
	Request = GetRequest();
	var filename=Request['filename'];
	var realname=filename.substring(0,filename.lastIndexOf("."));	
	var username="<?php echo $username; ?>";
$(document).ready(function(){

	//si le video deja settings. charger les infos
	$.ajax({
		url: "utils/settingFile.php",
		dataType:'JSON',
		type:"POST",
		data:{realname:realname},
		success:function(data){	
			if(data!="no exists"){
			var obj = eval ("(" + data + ")");
			var qcm=obj.qcm;
			var button=obj.button;
			var inputText=obj.inputText;
			var text=obj.text;
			for(var i=0;i<qcm.rows.length;i++){
					AddQCM(qcm.rows[i]);
			}
			for(var i=0;i<button.rows.length;i++){
			  if(button.rows[i].hasOwnProperty("time")){
				AddJumpTo(button.rows[i]);
				}else{
				AddChapitre(button.rows[i]);
			 }
			}
			for(var i=0;i<inputText.rows.length;i++){
					AddInputText(inputText.rows[i]);
			}
			for(var i=0;i<text.rows.length;i++){
					AddText(text.rows[i]);
			}
			$("#inputDiv").html("<button class='btn' type='submit'>Submit</button>");
		}
	  }
	});
	var sourceMp4="server/php/files/<?php echo $username; ?>/"+realname+".mp4";
	var sourceWebm="server/php/files/<?php echo $username; ?>/"+realname+".webm";
	var sourceOgv="server/php/files/<?php echo $username; ?>/"+realname+".ogv";
	$("#sourceMp4").attr('src',sourceMp4);
	$("#sourceWebm").attr('src',sourceWebm);
	$("#sourceOgv").attr('src',sourceOgv);
	
	$("#myVideo").mousemove(function(e){
	var Y = e.pageY-$('#myVideo').offset().top; 
	var X = e.pageX-$('#myVideo').offset().left; 
    $("span").text(" x : "+X+", y : " + Y);
	});
});

function addUnLigne(){
var checkValue=$("#select_option").val();
	if(checkValue=="text"){
		textfunction();
	}else if(checkValue=="chapitre"){
		chapitrefunction();
	}else if(checkValue=="inputText"){
		inputTextfunction();
	}else if(checkValue=="jump"){
		jumpfunction();
	}else if(checkValue=="qcm"){
		qcmfunction();
	}
}

//submit le table pour creer une activite
function submitButton(type){
	$("#inputDiv").html("<button class='btn' type='submit'>Submit</button>");
	if(type=="text"){
		AddText("");
	}else if(type=="chapitre"){
		AddChapitre("");
	}else if(type=="inputText"){
		AddInputText("");
	}else if(type=="jump"){
		AddJumpTo("");
	}else if(type=="qcm"){
		AddQCM("");
		nbOptions=1;
	}
	$("#tableInput").html("");
	$("#submitButton").html("");
}

</script>
<style>
.inputTable{
	margin-top:50px;
}
</style>  
</head> 
<body> 
<div class="container">
<div class="row">
	<div class="col-md-6">
		<div class="col-sm-2">
			<button onclick="addUnLigne()" class="btn">add</button>
		</div>
		<div class="col-sm-4">
			<select id="select_option" class="form-control">
			  <option value ="text">Text</option>
			  <option value ="chapitre">Chapitre</option>
			  <option value="inputText">Input Text</option>
			  <option value="jump">Jump to Button</option>
			  <option value="qcm">QCM</option>
			</select>
		</div>
		<div class="inputTable">
			<table id="tableInput" class="table">
			</table>
			<div id="submitButton"> </div>
		</div>
		<p>
		<form  data-toggle="validator" onsubmit="return submitForm()"> 
			<!--Text -->
			<div class="form-group">
			<div id="titreText"></div>
			<table id="textTable" class="table">
			</table>
			<div id="btnText"></div>
			</div>
			
			<!--Chapitre-->
			<div class="form-group">
			<div id="titreChapitre"></div>
			<table id="chapitreTable" class="table">
			</table>
			<div id="btnChapitre"></div>
			</div>
			
			<!--input Text-->
			<div class="form-group">
			<div id="titreInputText"></div>
			<table id="inputTable" class="table">
			</table>
			<div id="btnInputText"></div>
			</div>
			
			<!--Button-->
			<div class="form-group">
			<div id="titreButton"></div>
			<table id="buttonTable" class="table">
			</table>
			<div id="btnButton"></div>
			</div>
			
			<!--QCM-->
			<div class="form-group">
			<div id="titreQCM"></div>
			<table id="qcmTable" class="table">
			</table>
			<div id="btnQCM"></div>
			</div>
		
			<div class="form-group">
			<div id="inputDiv">
			</div>
			</div>
		</form>
	</div>
	<div class="col-md-4">
	  <video id="myVideo" class="video-js vjs-default-skin" controls preload="none" width="600" height="400"
		  data-setup="{}">
		<source id="sourceMp4" src="" type='video/mp4' />
		<source id="sourceWebm" src="" type='video/webm' />
		<source id="sourceOgv" src="" type='video/ogg' />
		<track kind="captions" src="css/demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
		<track kind="subtitles" src="css/demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
		<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
	  </video>
	</div>
	<div>
	<p><span></span>.</p>
	</div>
 </div>
</div>
</body> 
</html>
