<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description: Login is the landing page in user driven mode
*/
@extract($_GET);
$queryString 	= $_SERVER['QUERY_STRING'];
$cleanQuery		= Random_decode($queryString);
parse_str($cleanQuery);
if(isset($FormValues)) {
	require_once __DIR__.'./../VerifyUser.php';
}
if(isset($_SESSION['userID']))
	RedirectTo('Home');
	
if(isset($err) && $err != ''){$CustomHtml['#Status']	=	getErrorMessage($err);}
?>
<link rel="stylesheet" href="../css/Login.css" type="text/css" />
<hr style="margin-left: 0px;opacity: 0.5;color: #eee;" />
<div style="padding: 1%;" align="center">
    <form id="LoginForm" action="">
        <fieldset style="height: 260px">
            <legend style="font-color; opacity:0.7" align="center">Sign in</legend>
                <table class="Login" style="height:100%">
                    <tr>
                        <td>Email</td>
                        <td><input class="mediumInputBox" title = '<?php echo TITLE1 ;?>' type="text" id="usname" name="usname" /></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input class="mediumInputBox" title = '<?php echo TITLE2 ;?>' type="password" id="pswd" name="pswd" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align = 'center'>
					        <input type="hidden" name="FormValues" id="FormValues" value="" />
                        	<button type="submit" class="largeButton" id="loginButton" onClick="return Login();">Login</button>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="2" align="center" style="font-size: small">
                    		<a title = '<?php echo TITLE3 ;?>' href="ForgotPassword.php" style="margin-left: 5px">
                                Forgot Password?  
                            </a>
<?php /*                      <a title = '<?php echo TITLE4 ;?>' href="#" style="margin-left: 5px">
                                Terms of Use | 
                            </a>
                            <a title = '<?php echo TITLE5 ;?>' href="#" style="margin-left: 5px">
                                Security | 
                            </a>
                            <a title = '<?php echo TITLE6 ;?>' href="#" style="margin-left: 5px">
                                Privacy
                            </a>	*/ ?>   
                    	</td>
                </table>
        </fieldset>
    </form>
</div>
<div id="Status" align="center"></div>
<script type="text/javascript" src="../js/Login.js"></script>
