$(function(){
	$('#NewPswd').keypress(function(event){
		return nospaceallowed(event);
	});
	$('#confNewPswd').keypress(function(event){
		return nospaceallowed(event);
	});
});

function saveNewPwd(){
	var newPassword = $('#NewPswd').val();
	if(newPassword.length <= 6 || newPassword.length >=20){
		$("#NewPswd").jqxTooltip({ content: ErrorMessages[11],  position: 'right',  left: 10, name: 'testTooltip',theme:JQXTHEME});
		$("#NewPswd").jqxTooltip('open');
	    $("#NewPswd").jqxTooltip('close',500);
		return false;
	}
	if(newPassword == $('#confNewPswd').val()){
		var updatePwd	=	new Object();
		updatePwd.actionScriptURL	=	'action/updateUserPwd.php?UID='+UID+'&pwd='+newPassword;
		updatePwd.callBack		=	function (Response){
										if(Response == '1'){
											$('#change').css("display",'none');
											$('#SubmitStatus').css("display",'block');
										}
									};
		send_remoteCall(updatePwd);
		return;
	}

	$("#confNewPswd").jqxTooltip({ content: ErrorMessages[12],  position: 'right',  left: 10, name: 'testTooltip',theme:JQXTHEME});
	$("#confNewPswd").jqxTooltip('open');
    $("#confNewPswd").jqxTooltip('close',500);
	return false;

}

function redirectToLogin(){
	window.location = "index.php";
}