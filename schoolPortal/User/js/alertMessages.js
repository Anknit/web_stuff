/*
* Author: Aditya
* date: 21-Aug-2014
* Description: This defines Alert messages for user interface
*/

var AlertMessageArrVar = new Array();	// This variable collects the arguments and pass it to alert.getmessages
function AlertDynamicMessage(ArrayStrings)
{
	//Assumption: Message will always start with string. Variables will always be Arrays. Variables and strings will alternate as -- string+variable+string+variable+string+....
	this.getMessages = function getMessages(Variable)
	{
		var messageReturn = "";
		for(var ijk = 0; ijk < ArrayStrings.length; ijk++)
		{
			if(ArrayStrings[ijk] != "" && ArrayStrings[ijk] != undefined)
			{
				messageReturn += ArrayStrings[ijk];
			}
			if(Variable[ijk] != "" && Variable[ijk] != undefined)
			{
				messageReturn += Variable[ijk];
			}
		}
		return messageReturn;
	};
}

var SuccessMessages = new Array();
SuccessMessages[1]	= 'User details updated successfully';
SuccessMessages[2]	= 'User deleted successfully';
SuccessMessages[3]	= 'The user has been registered successfully and a verification email has been sent to the registered user. The user needs to complete the registration process by clicking the verification link in the email';
SuccessMessages[4]	= 'Voucher code has been generated successfully. Please check your email for the voucher details';
SuccessMessages[5]	= 'Your credit amount has been updated successfully';
SuccessMessages[6]	= 'Voucher has been cancelled';
SuccessMessages[7]	= 'Voucher has been assigned successfully';
SuccessMessages[8]	= 'SMTP settings saved successfully';
SuccessMessages[9]	= 'Invoice details have been sent to registered email address.';
SuccessMessages[10]	= 'Support email address have been saved successfully';
SuccessMessages[11]	= 'SUID has been reset successfully';
SuccessMessages[12]	= 'Mail sent successfully';

var ErrorMessages = new Array();
ErrorMessages[0]	= 'No processing has been done yet';
ErrorMessages[1]	= 'All requests have been completed successfully';
ErrorMessages[2]	= 'Sufficient credits are not available for completing this action';
ErrorMessages[3]	= 'The user doesn\'t exist';
ErrorMessages[4]	= 'The user is currently under unlimited plan. The subscription can only be modified after expiry of the plan';
ErrorMessages[5]	= 'The user has been logged out';
ErrorMessages[6]	= 'The user has not set the password';
ErrorMessages[7]	= 'Incorrect password. Please re-enter your credentials';
ErrorMessages[8]	= 'Username can not be left empty';
ErrorMessages[9]	= 'Invalid username';
ErrorMessages[10]	= 'Password can not be left empty';
ErrorMessages[11]	= 'Password should be greater than 6 and less than 20';
ErrorMessages[12]	= 'Passwords do not match';
ErrorMessages[13]	= 'Error in cancelling the voucher';
ErrorMessages[14]	= 'Please enter a valid customer email address';
ErrorMessages[15]	= 'Error in assigning voucher';
ErrorMessages[16]	= 'Enter a valid Reset Code';
ErrorMessages[17]	= 'Failed to save SMTP settings';
ErrorMessages[18]	= 'Please fill the support form correctly';
ErrorMessages[19]	= 'Error in processing your support request';
ErrorMessages[20]	= 'Please enter a valid contact number';
ErrorMessages[21]	= 'Unable to Generate Invoice for this transaction';
ErrorMessages[22]	= 'Failed to create database backup';
ErrorMessages[23]	= 'Amount must be greater than 100 USD';
ErrorMessages[24]	= 'Your account validity has expired';
ErrorMessages[25]	= 'Failed to save support email address';
ErrorMessages[26]	= 'Failed to reset SUID because of invalid user';	//Bad request/ UserID not sent
ErrorMessages[27]	= 'Failed to reset SUID because of invalid user';	//Bad request/ User is not a customer/Operator
ErrorMessages[28]	= 'Failed to reset SUID';	//probably a db error
ErrorMessages[29]	= 'Please enter all input for sending mail';	//Bad request All inputs not provided
ErrorMessages[30]	= 'Failed to send Mail';	//probably a db error
ErrorMessages[31]	= 'Unauthorized access';	


var CreditErrorMessages = new Array();
CreditErrorMessages[2]	= 'Error in updating the license validity';
CreditErrorMessages[3]	= 'Voucher code has already been used';
CreditErrorMessages[4]	= 'Voucher code has been cancelled';
CreditErrorMessages[5]	= 'Voucher code has expired';
CreditErrorMessages[6]	= 'Voucher code is invalid';
CreditErrorMessages[7]	= 'Error in updating the subscription validity';
CreditErrorMessages[8]	= 'Please enter a voucher code';
CreditErrorMessages[9]	= 'Error in updating the credits';
CreditErrorMessages[10]	= 'This voucher has already been assigned to another user';

var UserAddEditDelete = new Array();
UserAddEditDelete[1]	= 'Failed to delete user';
UserAddEditDelete[2]	= 'Failed to add new user';
UserAddEditDelete[3]	= 'User is already registered';

var VoucherGenerateErrorMessages = new Array();
VoucherGenerateErrorMessages[0]	= '';
VoucherGenerateErrorMessages[1]	= '';
VoucherGenerateErrorMessages[2]	= 'The voucher amount must be greater than or equal to USD 100';
VoucherGenerateErrorMessages[3]	= 'Please enter a valid voucher amount';
VoucherGenerateErrorMessages[4]	= 'Please enter all the required voucher details';

var RegistrationErrorMessages	= new Array();
RegistrationErrorMessages[0]	= "Name cannot be left empty";
RegistrationErrorMessages[1]	= "Name cannot contain any numeric value";
RegistrationErrorMessages[2]	= "Enter the organization name";
RegistrationErrorMessages[3]	= "Name cannot contain any special characters";

var SMTPErrorMessages	= new Array();
SMTPErrorMessages[0]	= 'HostName cannot be left empty';
SMTPErrorMessages[1]	= 'SMTP port number cannot be left empty';
SMTPErrorMessages[2]	= 'Sender name cannot be left empty';

var AddUserErrorMessages	=	new Array();
AddUserErrorMessages[0]	=	'User type must be specified';
AddUserErrorMessages[1]	=	'Email address must be specified';
AddUserErrorMessages[2]	=	'Enter a valid email address';
