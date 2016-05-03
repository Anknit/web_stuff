var tempX;
var tempY;
function allowDrop(ev) {
    ev.preventDefault();
}
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
    tempX = ev.offsetX;
	tempY = ev.offsetY;  
}
function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    if($(data).attr('cloneOnDrop') == "true"){
	    var newElement = ev.target.appendChild($('#'+data).cloneNode(true));
	    newElement.style.resize = 'both';
	    newElement.style.overflow = 'auto';
	    newElement.setAttribute('cloneOnDrop','false');
	    temp =new Date;
	    temp =temp.getTime();
	    newElement.id = data+'cloned_Page'+temp;
	    newElement.style.position = 'fixed';
	    newElement.style.cursor = 'auto';
    }
    else
	    var newElement = ev.target.appendChild($('#'+data)[0]);
	newElement.style.top = parseInt(ev.clientY)-parseInt(tempY);
	newElement.style.left = parseInt(ev.clientX)-parseInt(tempX);
}	
function create_openDB(){
    try {
        var dbreq = window.indexedDB.open(indexedDBName);
        dbreq.onsuccess = function (event) {
            var db = event.result;
            output_trace("indexedDB: " + indexedDBName + " created or opened");
            PrintDBInformation(db);
            db.close();
        }
        dbreq.onerror = function (event) {
            output_trace("indexedDB.open Error: " + event.message);
        }
    }
    catch (e) {
        output_trace("Error: " + e.message);
    }
}
var indexedDBName = "AsyncIndexedDB2";
var version = "2.0";
var read_only = 1;
var read_write = 0;
var version_change = 2;
var objNames =["KIDSTORE", "CANDYSTORE"];
var OBJECTSTORES =[{ name: "KIDSTORE", keyPath: "id", autoIncrement: true },
                   { name: "CANDYSTORE", keyPath: "id", autoIncrement: false },
                   { name: "CANDYSALESTORE", keyPath: "id", autoIncrement: true }];
var kidsData =[{ name: "Anna", number: 1000 },
                 { name: "Betty", number: 1001 },
                 { name: "Christine", number: 1002 },
                 { name: "Amy", number: 1003 },
                 { name: "Linda", number: 1004 },
                 { name: "Lincoln", number: 1005 }];
var kidsDataUpdate =[{ id: 100, name: "Anna", number: 2000 },
                     { id: 101, name: "Betty", number: 2001 },
                     { id: 102, name: "Christine", number: 2002 },
                     { id: 103, name: "Amy", number: 2003 },
                     { id: 104, name: "Linda", number: 2004 },
                     { id: 105, name: "Lincoln", number: 2005 }];
var candyData =[{id: 10, name: "candy1", weight: 100 },
                { id: 11, name: "candy2", weight: 200 },
                { id: 12, name: "candy3", weight: 300 },
                { id: 13, name: "candy4", weight: 400 }];
   ///////////////////////////////////
  //utility functions
  ////////////////////////////////////
function PrintDBInformation(idb) {
	if (idb) {
		var sName = idb.name;
        var dVersion = idb.version;
        var dTableNames = idb.objectStoreNames;
        var strNames = "IndexedDB name: " + sName + "; version: " + dVersion + "; object stores: ";
        for (var i = 0; i < dTableNames.length; i++) {
        	strNames = strNames + dTableNames[i] + ", ";
        }
        output_trace(strNames);
	}
}
function PrintRecord(tTable, tRecord) {
	if (tRecord != undefined) {
		if (tTable == "KIDSTORE") {
			output_trace("( " + tRecord.id + "," + tRecord.name + "," + tRecord.number + ")");
		}
		else if (tTable == "CANDYSTORE") {
			output_trace("( " + tRecord.id + "," + tRecord.name + "," + tRecord.weight + ")");
		}
		else if (tTable == "CANDYSALESTORE") {
		}
	}
}
function output_trace(sMsg){
	var oTrace = document.getElementById("textentryDB");
	if (oTrace.value == "")
		oTrace.value = sMsg;
	else
		oTrace.value = oTrace.value + "\n"+ sMsg;
}      