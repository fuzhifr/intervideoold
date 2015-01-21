
function GetRequest() {
	   var url = location.search; //get les lettres apres "?"
	   var theRequest = new Object();
	   if (url.indexOf("?") != -1) {
		  var str = url.substr(1);
		  strs = str.split("&");
		  for(var i = 0; i < strs.length; i ++) {
			 theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
		  }
	   }
	   return theRequest;
	}

//creer une champ pour entrer les infos de Text
function textfunction(){
 var myVid=document.getElementById("myVideo_html5_api");
 var time=Math.round(myVid.currentTime);
 $("#tableInput").html("<tr><th>time</th><th>message</th></tr>")
 $("#tableInput").append("<tr align='center'>"
                                +"<td><input class='form-control' min=1 type='number' name='timeText' id='timeText' size='5' value='"+time+"' required></td>"
								+"<td><input class='form-control' type='text' name='msgText' id='msgText' required></td>"	
						+"</tr>");  
 $("#submitButton").html("<button class='btn' onclick=\"submitButton('text');\">Submit</button>");
}

//creer une champ pour entrer les infos de Chapitre
function chapitrefunction(){
 var myVid=document.getElementById("myVideo_html5_api");
 var time=Math.round(myVid.currentTime);
 $("#tableInput").html("<tr><th>time</th><th>introduction</th></tr>")
 $("#tableInput").append("<tr align='center'>"
                                +"<td><input class='form-control' min=1 type='number' name='timeChapitre' id='timeChapitre' size='5' value='"+time+"'/></td>"
								+"<td><input class='form-control' type='text' name='msgChapitre' id='msgChapitre' /></td>"	
						+"</tr>");  
 $("#submitButton").html("<button class='btn' onclick=\"submitButton('chapitre');\">Submit</button>");
}


//creer une champ pour entrer les infos de inputText
function inputTextfunction(){
 var myVid=document.getElementById("myVideo_html5_api");
 var time=Math.round(myVid.currentTime);
 $("#tableInput").html("<tr><th>time</th><th>jump to</th><th>message</th></tr>")
 $("#tableInput").append("<tr align='center'>"
                                +"<td><input class='form-control' min=1 type='number' name='timeInput' id='timeInput' size='5' value='"+time+"'/></td>"
								+"<td><input class='form-control' min=1 type='number' name='jumpToInput' id='jumpToInput' size='5' /></td>"
								+"<td><input class='form-control' type='text' name='msgInput' id='msgInput' /></td>"	
						+"</tr>");  
 $("#submitButton").html("<button class='btn' onclick=\"submitButton('inputText');\">Submit</button>");
}

//creer une champ pour entrer les infos de Button
function jumpfunction(){
 var myVid=document.getElementById("myVideo_html5_api");
 var time=Math.round(myVid.currentTime);
 $("#tableInput").html("<tr><th>time</th><th>jump to</th><th>label</th></tr>")
 $("#tableInput").append("<tr align='center'>"
                                +"<td><input class='form-control' min=1 type='number' name='timeButton' id='timeButton' size='5' value='"+time+"'/></td>"
								+"<td><input class='form-control' min=1 type='number' name='jumpToButton' id='jumpToButton' size='5' /></td>"
								+"<td><input class='form-control' type='text' name='label' id='label' /></td>"	
						+"</tr>");  
 $("#submitButton").html("<button class='btn' onclick=\"submitButton('jump');\">Submit</button>");
}

//creer une champ pour entrer les infos de QCM
function qcmfunction(){
 var myVid=document.getElementById("myVideo_html5_api");
 var time=Math.round(myVid.currentTime);
 $("#tableInput").html("<tr><th>time</th><th>titre de QCM</th><th>option</th><th>jump to</th></tr>")
 $("#tableInput").append("<tr class='QCM' align='center'>"
                                +"<td><input class='form-control' min=1 type='number' name='timeQCM' id='timeQCM' size='5' value='"+time+"'/></td>"
								+"<td><input class='form-control' type='text' name='titre' id='titre' /></td>"
								+"<td><input class='form-control' type='text' name='optionQ"+nbOptions+"' id='optionQ"+nbOptions+"' /></td>"
								+"<td><input class='form-control' type='text' name='jumpToQ"+nbOptions+"' id='jumpToQ"+nbOptions+"' placeholder='url ou time' /></td>"						
						+"</tr>");  
 $("#submitButton").html("<button class='btn' onclick=\"AddOption();\">Add Option</button>&nbsp;&nbsp;&nbsp;<button class='btn' onclick=\"submitButton('qcm');\">Submit</button>");
}

// function submit les datas
function submitForm(){

	var textData=getText();
	var buttonData=getJumpButton();
	var inputTextData=getInputText();	
	var qcmData=getQCM();
	
	var data={};
	data.qcm=qcmData;
	data.button=buttonData;
	data.inputText=inputTextData;
	data.text=textData;
	dataJson=JSON.stringify(data);
	console.log(data);
	var username=getCookie('username');
	// envoyer tous les datas a  settings.php
	$.ajax({
		url: "utils/settings.php",
		dataType:'JSON',
		type:"POST",
		data:{data:dataJson,realname:realname},
		success:function(data){	
		console.log(data);
		window.open("view.html?username="+username+"&realname="+realname,'_blank');
		}
	});
	
	return false;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function getText(){
	var textData={};
	var rows=[];
	
	var textTable=$("tr.text");
	$(textTable).each(function(){
		var i=$(this).attr("id");
		rows.push({"id":i,"time":$("input[id='timeText"+i+"']").val(),"msg":$("input[id='msgText"+i+"']").val()});
	});
	textData.rows=rows;
	return textData;
}

function getJumpButton(){
	var buttonData={};
	var rows=[];
	
	var textTable=$("tr.jumpButton");
	$(textTable).each(function(){
		var i=$(this).attr("id");
		rows.push({"id":i,"time":$("input[id='timeButton"+i+"']").val(),"label":$("input[id='label"+i+"']").val(),"jumpTo":$("input[id='jumpToButton"+i+"']").val()});
	});
	
	var chapitreTable=$("tr.chapitre");
	$(chapitreTable).each(function(){
		var i=$(this).attr("id");
		rows.push({"id":i,"label":$("input[id='msgChapitre"+i+"']").val(),"jumpTo":$("input[id='jumpToChapitre"+i+"']").val()});
	});
	
	buttonData.rows=rows;
	return buttonData;
	
}
// get QCM table data
function getQCM(){
// recupere data de QCM ------------
	var qcmData={};
	// rows pour tous les QCM
	var rows=[];
	// options pour un QCM
	var options=[];
	
	// ajoute tous les QCM
	for(var j=0; j<arrayQCM.length;j++){
	var _len=$("tr."+arrayQCM[j]).length;
	var options=[];
		for(var i=1;i<=_len;i++){
			options.push({"option":$("input[id='option"+arrayQCM[j]+i+"']").val(),"jumpTo":$("input[id='jumpTo"+arrayQCM[j]+i+"']").val()});
		}
		rows.push({"id":arrayQCM[j],"time":$("input[id='time"+arrayQCM[j]+"']").val(),"msg":$("input[id='msg"+arrayQCM[j]+"']").val(),"options":options});
	}
	qcmData.rows=rows;
	return qcmData;
}

// get Input Text Table data
function getInputText(){
	var inputTextData={};
	var rows=[];
	
	var inputTable=$("tr.inputText");
	$(inputTable).each(function(){
		var i=$(this).attr("id");
		rows.push({"id":i,"time":$("input[id='time"+i+"']").val(),"msg":$("input[id='msg"+i+"']").val(),"jumpTo":$("input[id='jumpTo"+i+"']").val()});
	});
	inputTextData.rows=rows;
	return inputTextData;
}

//nombre de Question
var nbQCM=0;
//nombre de options par un QCM
var nbOptions=1;
// noter les qcm
var arrayQCM=[];
//nombre inputText
var nInputText=0;
//nombre text
var nText=0;
//nombre jump button
var nJump=0;
//nombreo chapitre
var nChapitre=0;

//ajouter un text
function AddText(row){
	if(nText==0){
		$("#titreText").html("<h3>Text</h3>");
		$("#textTable").html("<tr>"
								+"<th>*</th>"
								+"<th>time</th>"
								+"<th>message</th>"
							+"</tr>");
		$("#btnText").html("<input name='' class='btn' type='button' value='delete text' onClick='deleteText()' />");
	} 
	nText+=1;
	if(row==""){
		var timeValue=$("input[id='timeText']").val();
		var msgText=$("input[id='msgText']").val();
	}else{
		var timeValue=row.time;
		var msgText=row.msg;
	}
	  $("#textTable").append("<tr id="+nText+" class='text' align='center'>"
									+"<td><input type='checkbox' name='text'/></td>"
									+"<td><input class='form-control' min=1 type='number' name='timeText"+nText+"' id='timeText"+nText+"' size='5' value='"+timeValue+"' required></td>"
									+"<td><input class='form-control' type='text' name='msgText"+nText+"' id='msgText"+nText+"' value='"+msgText+"' required></td>"	
							+"</tr>"); 		
}

//delete un text 
function deleteText(){ 
	var checked = $("input[type='checkbox'][name='text']"); 
	var len=checked.length;
	$(checked).each(function(){ 
		if($(this).attr("checked")==true)
		{ 
			$(this).parent().parent().remove(); 
			len=len-1;
			if(len==0){
				$("#titreText").html("");
				$("#textTable").html("");
				$("#btnText").html("");
				nText=0;
			}
		} 
	}); 
} 

// ajouter une chapitre
function AddChapitre(row){ 
	if(nChapitre==0){
			$("#titreChapitre").html("<h3>Chapitre</h3>");
			$("#chapitreTable").html("<tr>"
									+"<th>*</th>"
									+"<th>time</th>"
									+"<th>introduction</th>"
								+"</tr>");
			$("#btnChapitre").html("<input class='btn' name='' type='button' value='delete Chapitre' onClick='deleteChapitre()' />");
	} 
	nChapitre+=1;
	if(row==""){
		var timeValue=$("input[id='timeChapitre']").val();
		var msgValue=$("input[id='msgChapitre']").val();
	}else{
		var timeValue=row.jumpTo;
		var msgValue=row.label;
	}
  $("#chapitreTable").append("<tr id="+nChapitre+" class='chapitre' align='center'>"
                                +"<td><input type='checkbox' name='chapitre'/></td>"
								+"<td><input class='form-control' min=1 type='number' name='jumpToChapitre"+nChapitre+"' id='jumpToChapitre"+nChapitre+"' value='"+timeValue+"' size='5' required></td>"
								+"<td><input class='form-control' type='text' name='msgChapitre"+nChapitre+"' id='msgChapitre"+nChapitre+"' value='"+msgValue+"' required></td>"							
						+"</tr>");     
} 

function deleteChapitre(){ 
	var checked = $("input[type='checkbox'][name='chapitre']"); 
	var len=checked.length;
	$(checked).each(function(){ 
		if($(this).attr("checked")==true)
		{ 
			$(this).parent().parent().remove(); 
			len=len-1;
			if(len==0){
				$("#titreChapitre").html("");
				$("#chapitreTable").html("");
				$("#btnChapitre").html("");
				nChapitre=0;
			}
		} 
	}); 
} 

// ajouter un input text
function AddInputText(row){ 
	if(nInputText==0){
			$("#titreInputText").html("<h3>Input Text</h3>");
			$("#inputTable").html("<tr>"
									+"<th>*</th>"
									+"<th>time</th>"
									+"<th>jump to</th>"
									+"<th>message</th>"
								+"</tr>");
			$("#btnInputText").html("<input class='btn' type='button' value='delete InputText' onClick='deleteInputText()' />");
	} 
	nInputText+=1;
	if(row==""){
		var timeValue=$("input[id='timeInput']").val();
		var jumpToValue=$("input[id='jumpToInput']").val();
		var msgValue=$("input[id='msgInput']").val();
	}else{
		var timeValue=row.time;
		var jumpToValue=row.jumpTo;
		var msgValue=row.msg;
	}
  $("#inputTable").append("<tr id="+nInputText+" class='inputText' align='center'>"
                                +"<td><input type='checkbox' name='inputText'/></td>"
                                +"<td><input class='form-control' min=1 type='number' name='time"+nInputText+"' id='time"+nInputText+"' value='"+timeValue+"' size='5' required></td>"
								+"<td><input class='form-control' min=1 type='number' name='jumpTo"+nInputText+"' id='jumpTo"+nInputText+"' value='"+jumpToValue+"' size='5' required></td>"
								+"<td><input class='form-control' type='text' name='msg"+nInputText+"' id='msg"+nInputText+"' value='"+msgValue+"' required></td>"							
						+"</tr>");     
} 

function deleteInputText(){ 
	var checked = $("input[type='checkbox'][name='inputText']"); 
	var len=checked.length;
	$(checked).each(function(){ 
		if($(this).attr("checked")==true)
		{ 
			$(this).parent().parent().remove(); 
			len=len-1;
			if(len==0){
				$("#titreInputText").html("");
				$("#inputTable").html("");
				$("#btnInputText").html("");
				nInputText=0;
			}
		} 
	}); 
} 
// ajouter un jump button
function AddJumpTo(row){ 
	if(nJump==0){
		$("#titreButton").html("<h3>Button</h3>");
		$("#buttonTable").html("<tr>"
								+"<th>*</th>"
								+"<th>time</th>"
								+"<th>jump to</th>"
								+"<th>label</th>"
							+"</tr>");
		$("#btnButton").html("<input class='btn' type='button' value='delete button' onClick='deleteJumpTo()' >");
	} 	
	nJump+=1;
	if(row==""){
	var timeValue=$("input[id='timeButton']").val();
	var jumpToValue=$("input[id='jumpToButton']").val();
	var msgValue=$("input[id='label']").val();
	}else{
	var timeValue=row.time;
	var jumpToValue=row.jumpTo;
	var msgValue=row.label;
	}
  $("#buttonTable").append("<tr id="+nJump+" class='jumpButton' align='center'>"
                                +"<td><input type='checkbox' name='jumpButton'/></td>"
								+"<td><input class='form-control' min=1 type='number' name='timeButton"+nJump+"' id='timeButton"+nJump+"' value='"+timeValue+"' size='5' required></td>"
								+"<td><input class='form-control' min=1 type='number' name='jumpToButton"+nJump+"' id='jumpToButton"+nJump+"' value='"+jumpToValue+"' size='5' required></td>"
								+"<td><input class='form-control' type='text' name='label"+nJump+"' id='label"+nJump+"' value='"+msgValue+"'  required></td>"							
						+"</tr>");     
} 

function deleteJumpTo(){ 
	var checked = $("input[type='checkbox'][name='jumpButton']"); 
	len=checked.length;
	$(checked).each(function(){ 
		if($(this).attr("checked")==true)
		{ 
			$(this).parent().parent().remove(); 
			len=len-1;
			if(len==0){
				$("#titreButton").html("");
				$("#buttonTable").html("");
				$("#btnButton").html("");
				nJump=0;
			}
		} 
	}); 
} 


//ajouter un option pour un QCM 
function AddOption(){ 
   nbOptions+=1;
  $("#tableInput").append("<tr class='Q' align='center'>"
								+"<td></td>"
                                +"<td></td>"
								+"<td><input class='form-control' type='text' name='optionQ"+nbOptions+"' id='optionQ"+nbOptions+"' required></td>"				
								+"<td><input class='form-control' pattern='([a-zA-z]+://[^\s]*)|(^[1-9]\d*$)' type='text' name='jumpToQ"+nbOptions+"' id='jumpToQ"+nbOptions+"' placeholder='url ou time' required></td>"									
						+"</tr>");     
 
} 
//delete les QCM choisie
function deleteQCM(){ 
    var checked = $("input[type='checkbox'][name='QCM']"); 
	$(checked).each(function(){ 
		if($(this).attr("checked")==true)
		{ 
			var trClass=$(this).parent().parent().attr("class");
			var qcmCheck=$("tr."+trClass);
			$(qcmCheck).each(function(){
				$(this).remove();
			});
			
			for(var i=0;i<arrayQCM.length;i++){
				if(arrayQCM[i]==trClass){
					 arrayQCM.splice(i,1);
					 console.log("arrayQCM : "+arrayQCM);
				 }
			}
			if(arrayQCM.length==0){
				$("#titreQCM").html("");
				$("#qcmTable").html("");
				$("#btnQCM").html("");
				nbQCM=0;
			}
		}
	}); 
} 
// ajouter un QCM
function AddQCM(row){ 

	if(nbQCM==0){
		$("#titreQCM").html("<h3>QCM</h3>");
		$("#qcmTable").html("<tr>"
								+"<th>*</th>"
								+"<th>time</th>"
								+"<th>titre de QCM</th>"
								+"<th>option</th>"
								+"<th>jump to</th>"
							+"</tr>");
		$("#btnQCM").html("<input class='btn' type='button' value='delete QCM' onClick='deleteQCM()' >");
	} 	
	nbQCM+=1;
	arrayQCM.push("Q"+nbQCM);
	if(row!=""){
		nbOptions=row.options.length;
	}
	for(var i=1;i<nbOptions+1;i++){
		if(row==""){
			var optionValue=$("input[id='optionQ"+i+"']").val();
			var jumpToValue=$("input[id='jumpToQ"+i+"']").val();
		}else{
			var optionValue=row.options[i-1].option;
			var jumpToValue=row.options[i-1].jumpTo;
		}
		if(i==1){
			if(row==""){
				var timeValue=$("input[id='timeQCM']").val();
				var msgValue=$("input[id='titre']").val();
			}else{
				var timeValue=row.time;
				var msgValue=row.msg;
			}
		$("#qcmTable").append("<tr id="+nbQCM+i+" class='Q"+nbQCM+"' align='center'>"
							+"<td><input type='checkbox' name='QCM' /></td>"
							+"<td><input class='form-control' min=1 type='number'  name='timeQ"+nbQCM+"' id='timeQ"+nbQCM+"' value="+timeValue+"  required></td>"
							+"<td><input class='form-control' type='text'  name='msgQ"+nbQCM+"' id='msgQ"+nbQCM+"' value='"+msgValue+"' required></td>"
							+"<td><input class='form-control' type='text'  name='optionQ"+nbQCM+i+"' id='optionQ"+nbQCM+i+"' value='"+optionValue+"' required></td>"				
							+"<td><input class='form-control' pattern='((http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?)|(^[1-9]\d*$)' type='text'  name='jumpToQ"+nbQCM+i+"' id='jumpToQ"+nbQCM+i+"' value='"+jumpToValue+"' placeholder='url ou time' required></td>"								
					+"</tr>"); 
		}else{
		$("#qcmTable").append("<tr id="+nbQCM+i+" class='Q"+nbQCM+"' align='center'>"
                                +"<td></td>"
								+"<td></td>"
                                +"<td></td>"
								+"<td><input class='form-control' type='text'  name='optionQ"+nbQCM+i+"' id='optionQ"+nbQCM+i+"' value='"+optionValue+"' required></td>"				
								+"<td><input class='form-control' type='pattern='((http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?)|(^[1-9]\d*$)'  name='jumpToQ"+nbQCM+i+"' id='jumpToQ"+nbQCM+i+"' value='"+jumpToValue+"' placeholder='url ou time' required></td>"								
						+"</tr>");
		}
	}				
}
