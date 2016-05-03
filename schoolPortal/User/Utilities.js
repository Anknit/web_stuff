
/***
 * Utility functions _rm 
 * THIS SECTION OF THE CODE SHOULD CONTAIN ALL COMMON UTILITY FUNCTIONS WHICH ARE SELF SUFFICIENT 
 * IN NATURE. IDEALLY THIS FILE SHOULD BE USABLE IN OTHER PORJECTS WITHOUT DEPENDING ON ANY OTHER 
 * FILE 
 * 
 */


var gAJXObj = 0; 
var gAsyncAJXObj = 0; 

var gAsyncTimer = 0;
var gAJXTimerValue = 200; 
var ErrorString = "Error";
var gXMLDoc = 0;

var gAppURI = "AppModule.php"; //"http://localhost/ECLIPSE_WORKSPACE/PROTO/Login/AppModule.php"; //
var gAJAXResponse = "";
var gAJAXResult = 'REQ_COMPLETED'; 
var REQ_DATA_COMPLETED = 4; 
var REQ_DATA_OPEN = 1; 
var REQ_DATA_INITIALIZED = 0; 
var gRequestPool=[]; 
var gAsyncMode = true ;//false;// true; 
var bFirstTimeSend = false; 

function AJX_RequestWithPureXMLReponse( RespDataType, ModID, RequestId, RequestBody)
{
	if(!gAJXObj)
		gAJXObj =  new XMLHttpRequest(); 
	
	
	//gAJXObj.open("GET","http://localhost/USER_DATA/mala_dir/wksdata_HTM.xml", false ); 
	//http://localhost/ECLIPSE_WORKSPACE/PROTO/Login/AppModule.php?modid=WKSM&reqid=100&type=XML";
    var newURI = gAppURI + "modid=" + ModID + "&reqid=" + RequestId + "&type=" + RespDataType; 
	gAJXObj.open("POST",newURI, false );
	gAJXObj.send(RequestBody); 		
	return gAJXObj.responseXML;
}

function BlockUIinAjax(bFlag) {

    if ((bFlag == true) && (gUIBlock == false)){    	
    	gUIBlock = true; 
    	//document.body.style.cursor = "wait";
    	WAL_showWaitPromptWindow('waitwindow', true); 
      /*   $.blockUI({ css: {
        border: 'none',
        padding: '15px',
        backgroundColor: '#000',
        '-webkit-border-radius': '10px',
        '-moz-border-radius': '10px',
        opacity: .5,
        color: '#fff'
        }
        });
         
         setTimeout(function(){		
        	 gUIBlock = false;        	
             $.unblockUI(); 			
		}, 3500); */
         
    }
    else if( (bFlag == false) && (gUIBlock == true) ){
    	gUIBlock = false; 
    	WAL_showWaitPromptWindow('waitwindow', false); 
       // $.unblockUI(); 
       // Debug_Message("Now unblocking"); 
    }

}

function AJX_RequestWithReponseData(RespDataType, ModID, RequestId, RequestBody)
//function AJX_RequestWithPureTextReponse(RespDataType, ModID, RequestId, RequestBody)
{
 if (!gAJXObj)
      gAJXObj = new XMLHttpRequest();

 //BlockUIinAjax(true);
  if(gAJAXResult == 'REQ_PENDING')
  {
  	Debug_Message("Pending Request Incompleted");
  	return ; 
  }
  var newURI = gAppURI + "?modid=" + ModID + "&reqid=" + RequestId + "&type=" + RespDataType;
  gAJXObj.open("POST", newURI, false);  
//  Debug_Message("Sending the Request"); 
  
  gAJAXResult = 'REQ_PENDING'; 
 // Debug_Message("Send Req id =" +RequestId ); 
  try
  {
  	 gAJXObj.send(RequestBody);
  } 
  catch(err)
	{
		 Debug_Message("AJX_RequestWithReponseData: Error encountered");
		 gAJAXResult = 'REQ_COMPLETED'; 
	}
  var respstr = gAJXObj.responseText; 
  var patt1=/\r\n/g;
  var respstr = respstr.replace(patt1, ""); 
  
  //Debug_Message("Received Response"); 
  gAJAXResult = 'REQ_COMPLETED';
  //Debug_Message("Recv Req id =" +RequestId ); 
  return respstr;
}



function AJX_RPCSend(phpSessionID, oprtnType, oprtnName, paramStr)
{
   if (!gAJXObj)
        gAJXObj = new XMLHttpRequest();

   //BlockUIinAjax(true);
    if(gAJAXResult == 'REQ_PENDING')
    {
    	Debug_Message("Pending Request Incompleted");
    	return ; 
    }
    var newURI = gAppURI + "?PHPSESSIONID=" + phpSessionID + "&OPERATION_TYPE=" + oprtnType + "&OPERATION_NAME=" + oprtnName;    
    gAJXObj.open("POST", newURI, false);  
    
    gAJAXResult = 'REQ_PENDING'; 
   // Debug_Message("Send Req id =" +RequestId ); 
    try
    {
    	 gAJXObj.send(paramStr);
    } 
    catch(err)
	{
		 Debug_Message("AJX_RequestWithReponseData: Error encountered");
		 gAJAXResult = 'REQ_COMPLETED'; 
	}
    var respstr = gAJXObj.responseText; 
    var patt1=/\r\n/g;
    var respstr = respstr.replace(patt1, ""); 
    
    //Debug_Message("Received Response"); 
    gAJAXResult = 'REQ_COMPLETED';
    //Debug_Message("Recv Req id =" +RequestId ); 
    return respstr;
}


function AJX_SessionRequestWithReponseData(sessionName, sessionID, RespDataType, ModID, RequestId, RequestBody)
//function AJX_RequestWithPureTextReponse(RespDataType, ModID, RequestId, RequestBody)
{
 if (!gAJXObj)
      gAJXObj = new XMLHttpRequest();

 //BlockUIinAjax(true);
  if(gAJAXResult == 'REQ_PENDING')
  {
  	Debug_Message("Pending Request Incompleted");
  	return ; 
  }
  var sessionstring = sessionName + '='+sessionID; 
  var newURI = gAppURI + '?' + sessionstring + "&modid=" + ModID + "&reqid=" + RequestId + "&type=" + RespDataType;
  gAJXObj.open("POST", newURI, false);  
//  Debug_Message("Sending the Request"); 
  
  gAJAXResult = 'REQ_PENDING'; 
 // Debug_Message("Send Req id =" +RequestId ); 
  try
  {
  	 gAJXObj.send(RequestBody);
  } 
  catch(err)
	{
		 Debug_Message("AJX_RequestWithReponseData: Error encountered");
		 gAJAXResult = 'REQ_COMPLETED'; 
	}
  var respstr = gAJXObj.responseText; 
  var patt1=/\r\n/g;
  var respstr = respstr.replace(patt1, ""); 
  
  //Debug_Message("Received Response"); 
  gAJAXResult = 'REQ_COMPLETED';
  //Debug_Message("Recv Req id =" +RequestId ); 
  return respstr;
}



function AJX_RequestWithNoReponseData(RespDataType, ModID, RequestId, RequestBody)
//function AJX_RequestWithPureTextReponse(RespDataType, ModID, RequestId, RequestBody)
{
	 var respstr; 
	 if(gAsyncMode == true)
	 {
		 if (!gAsyncAJXObj)
			   gAsyncAJXObj = new XMLHttpRequest();
		 
		 if(!gAsyncTimer)
			   gAsyncTimer = setInterval(function(){AJX_TimerHandler(); },gAJXTimerValue);
		 
		 AJX_AsyncCreateRequestPool(RespDataType, ModID, RequestId, RequestBody);
		 if(bFirstTimeSend ==  false)
		{
			 AJX_AsyncSendReqPoolData(); 
			 bFirstTimeSend = true; 
		}
		 respstr = 'OK'; 
		// Debug_Message("AJX_RequestWithNoReponseData Called"); 
	 }
	 else
	 {
		 respstr = AJX_RequestWithReponseData(RespDataType, ModID, RequestId, RequestBody); 
	 }
	
	 
	 return respstr;  
}


function AJX_DataLoadCallback()
{
	if(gAsyncAJXObj.readyState == REQ_DATA_COMPLETED)
	{
		var respstr = gAsyncAJXObj.responseText; 
	    var patt1=/\r\n/g;
	    var respstr = respstr.replace(patt1, ""); 
	    if(respstr != 'OK')
	    {
	    	Debug_Message("respstring = " + gAsyncAJXObj.responseText ); 
	    	gAJAXResult = 'ERROR';
	    	return ; 
	    }
	    else
	    {
	    	
	    	gAJAXResult = 'SUCCESS';	
	    	
	    	AJX_AsyncSendReqPoolData();
	    	
	    	//return ; 
	    	
	    }
	    	
	}
	 
}
function AJX_AsyncRequestWithPureTextReponse(RespDataType, ModID, RequestId, RequestBody) {
	      
	   //BlockUIinAjax(true);	  
	    var newURI = gAppURI + "?modid=" + ModID + "&reqid=" + RequestId + "&type=" + RespDataType;
	    gAsyncAJXObj.onreadystatechange = AJX_DataLoadCallback; 
	    gAsyncAJXObj.open("POST", newURI, true);  
	    //Debug_Message("Sending the Async Request ReqID=" +RequestId ); 
	    gAsyncAJXObj.send(RequestBody);	    
	   // BlockUIinAjax(false); 
	    return ; 	    
}

function AJX_TimerHandler()
{
/*	if( (gAsyncAJXObj.readyState == REQ_DATA_COMPLETED) || (gAsyncAJXObj.readyState == REQ_DATA_OPEN ) 
			||( REQ_DATA_INITIALIZED ==gAsyncAJXObj.readyState))*/
	
	if(gAsyncAJXObj.readyState == REQ_DATA_COMPLETED)
	{
		if(gRequestPool.length > 0)
		{
			//Debug_Message("Scheduling Request gAsyncAJXObj.readyState=" + gAsyncAJXObj.readyState + "pool len = " + gRequestPool.length); 
			AJX_AsyncSendReqPoolData();
		}		
	}	
	else
	{
		//Debug_Message("gAsyncAJXObj.readyState = "+ gAsyncAJXObj.readyState); 
	}
		
		
}
function AJX_AsyncCreateRequestPool(RespDataType, ModID, RequestId, RequestBody)
{
	var reqPoolrecord = []; 
	reqPoolrecord.push([RequestId, ModID, RespDataType,RequestBody]); 
	gRequestPool.push(reqPoolrecord); 
}

function AJX_AsyncSendReqPoolData()
{
	var reqPoolrecord ; 
	if(gRequestPool.length > 0)
	{
		reqPoolrecord = gRequestPool.shift(); 
		AJX_AsyncRequestWithPureTextReponse(reqPoolrecord[0][2],reqPoolrecord[0][1],reqPoolrecord[0][0], reqPoolrecord[0][3] );
		
		//Debug_Message("AJX_AsyncSendReqPoolData: Length = " +gRequestPool.length); 
		return true;
	}
	else
	{
		//Debug_Message("Save Completed"); 
		return false; 	
	}
		
}

function LoadXMLDOMFromString(stringXML)
{
	if (window.DOMParser) {
        parser = new DOMParser();
        xmlDoc = parser.parseFromString(stringXML, "text/xml");
    }
    else // Internet Explorer
    {
        xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
        xmlDoc.async = false;
        xmlDoc.loadXML(stringXML);
    }
	return xmlDoc; 
}


function GetNode(startNode, targetnodeId) {

	var myNode = document.getElementById(targetnodeId); 
	return myNode; 
	
    var currentNode = startNode;
    
    //check if currentNode ID is equal to targetnodeId
    var currnodeID = currentNode.getAttribute("id");
    if (targetnodeId == currnodeID) {
        return currentNode;
    }

  
    //check if there are children
    var bChild = currentNode.hasChildNodes();
    if (bChild == true) {

        var childlistlen = currentNode.childNodes.length;
        currentNode = currentNode.firstElementChild;
        for (var i = 0; i < childlistlen; i++) {
            if (currentNode.nodeType == "1") {
                retNode = GetNode(currentNode, targetnodeId);
                if (retNode != null)
                    return retNode;
            }
            currentNode = currentNode.nextSibling; 
        }//for
    }

    return null; 
}


function SortNumberArray(inputarr)
{
	var myArray = inputarr; 
	
	myArray.sort( function(x, y) {

        if (x < y)  
           return -1;
        else if(x > y)
        	return 1;
        else
        	return 0;       
       });

	return myArray; 	
}

function SortMultiDimArray(inputarr, sortIndex)
{
	var myArray = inputarr;
	
	myArray.sort(function(a, b){
		var x, y; 
		if(sortIndex == -1) //for single dim array 
		{
			x = a; y = b; 
		}
		else
		{
			x = a[sortIndex];
			y = b[sortIndex]; 
		}		
		
		if (x < y)  
			return -1;
	    else if(x > y)
	       	return 1;
	    else
	       	return 0;	
	}); 
	
	return myArray;
}

function UtilGetItemIndexFromArray(myArray, itemText)
{
	//first convert the itemtext to uppercase 
	var inputItem = itemText.toUpperCase();	
	for(var k = 0; k < myArray.length; k++)
	{
		if(inputItem == myArray[k].toUpperCase())
			return k; 
	}
	return -1; 
	
}

function Debug_Message(str)
{
	alert(str); 
}