$(function(){
	$('#pswd').keypress(function(event){
		return nospaceallowed(event);
	});
	
	$('form').find('input')[0].focus();
});

function Login(){
    var EntryCorrect = validate();
	if(EntryCorrect == 'err1'){
		AlertMessage({msg:ErrorMessages[8]});
		return false;	
	}
	else if(EntryCorrect == 'err3'){
		AlertMessage({msg:ErrorMessages[9]});
		return false;	
	}
	else if(EntryCorrect == 'err2'){
		AlertMessage({msg:ErrorMessages[10]});
		return false;
	}
	else if(EntryCorrect == 'err4'){
		AlertMessage({msg:ErrorMessages[11]});
		return false;
	}
	else if(EntryCorrect == 'correct'){
	
	var Username    	= $('#usname').val();
	var Password    	= $('#pswd').val();
	var Data_random 	= randomize_Data('usname='+Username+'&pswd='+Password);
	var Data_encoded 	= EncodeData(Data_random);
	$('input').each(function(){$(this).val("");});
	$('#FormValues').val(Data_encoded);
	}
}

function validate(){
	if($('#usname').val() == '' || $('#usname').val() == undefined ){
		return 'err1';
	}
	else if(($('#usname').val().indexOf('@') == -1) || ($('#usname').val().indexOf('.') == -1)) {
    			return 'err3';
	}
	else if($('#pswd').val() == '' || $('#pswd').val() == undefined ){
		return 'err2';
	}
	else if(($('#pswd').val().length <= 6) || ($('#pswd').val().length >= 20)) {
		return 'err4'
	}
    else {
		return 'correct';
	}
}
