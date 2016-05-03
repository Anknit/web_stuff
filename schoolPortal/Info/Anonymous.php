<?php 
/*
 This is anonymous user's page.
 
 */

?>
<div class="GlobalInfoSection">
    <form name="Login" method="post" action="verifyUser.php" autocomplete="off">
		<div class="loginInputs">
			<div>
                            <input type="text" name="userName" title="Username" value=" ">
				<div class="lowerTextAttachment">Username</div>
			</div>
			<div>
				<input type="password" name="userPassword" title="Password">
				<div class="lowerTextAttachment">Password</div>
			</div>
			<div>
                            <input type="submit" onclick="" class="loginButton" value="Login" />
			</div>
		</div>
	</form>
</div>
<div class="AnonymousBody">
    <div class="perc_60x80">
	<div class="convertToTabs width-95 restrict_H-98" data-ConvertToTab-Event="click">
	  <ul>
	    <li><a href="#aboutus">About us</a></li>
	    <li><a href="#ourservices">Services</a></li>
	    <li><a href="#schoolresults">Schools and Results</a></li>
	    <li><a href="#schoolresults">Examinations</a></li>
	  </ul>
            <div id="aboutus" class="restrict_H-98 min_H-85">
	    <p>
                <?php require_once 'Content/AboutUs.php';?>
            </p>
	  </div>
	  <div id="schoolresults" class="restrict_H-98 min_H-85">
	    <p>
                <?php require_once 'schoolResults.php';?>
            </p>
	  </div>
	  <div id="ourservices" class="restrict_H-98 min_H-85">
	    <p>
                <?php require_once 'Content/ServicesOffered.php';?>
            </p>
	  </div>
	</div>
    </div>    
    <div class="perc_35x65 image_PortalServices_Div" showChildrensInCyclic="img" >
        <img src="images/digitalSavesTrees.png" height="300" width="300" />
        <img class="initialHidden" src="images/parent-teacher-crossword.png" height="300" width="300" />
        <img class="initialHidden" src="images/school-management-system.png" height="300" width="300" />
    </div>
    <div align="center" class="anonymous_EventsAndNews">
        <marquee behavior="scroll" direction="left" scrollamount="2" onmouseover="this.stop();" onmouseout="this.start();">
            This is the news provided by admin.
        </marquee>
    </div>
</div>