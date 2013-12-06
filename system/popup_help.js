// browser
var agent = navigator.userAgent;
var isNS4 = (navigator.appName == "Netscape")
var isIE = (agent.indexOf("MSIE") !=-1)
var isDOM = (document.getElementById)
var browserVersion = isIE? parseInt(agent.substring(agent.indexOf('MSIE')+5)) : parseInt(navigator.appVersion);


function hideme() 
{ 
var selNodes = document.getElementsByTagName('select') 
var i=0; 
if (!selNodes.item(0)) 
{ 
return false; 
} 
else 
{ 
do{selNodes.item(i).style.visibility = 'hidden';} 
while(++i < selNodes.length); 
} 
} 

function showme() 
{ 
var selNodes = document.getElementsByTagName('select') 
var i=0; 
if (!selNodes.item(0)) 
{ 
return false; 
} 
else 
{ 
do{selNodes.item(i).style.visibility = 'visible';} 
while(++i < selNodes.length); 
} 
} 



// standard Interact Datasafe scripts
// COOL transparent mouseover FX

        var ycomp = 0;
        var xcomp = 0;

        function ShowInfo(Topic,Body) {
		hideme();
                xcoor = event.clientX;
                ycoor = event.clientY;
                document.getElementById("Topic").innerHTML = Topic;
                document.getElementById("Body").innerHTML = Body;
                document.getElementById("infobox").style.display = "block";

                placex = (xcoor < 360) ? xcoor+15 : xcoor-320;
                placey = (ycoor < 220) ? ycoor+10 : ycoor+10;
                placey = (placey < 30) ? 34 : placey;
                infoheight = (document.getElementById("infobox").clientHeight) ? document.getElementById("infobox").clientHeight : 140;
                placey = (placey+infoheight > 409) ? 409-infoheight : placey;
//               document.getElementById("infobox").style.top = placey-ycomp;
//                document.getElementById("infobox").style.left = placex-xcomp;

                document.getElementById("infobox").style.top = ycoor + document.body.scrollTop;
                document.getElementById("infobox").style.left = placex-xcomp;
        }

        function HideInfo() {
		showme();
                document.getElementById("infobox").style.display = "none";
        }


