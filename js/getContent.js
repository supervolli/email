var xmlHttpObject = false;

if (typeof XMLHttpRequest != 'undefined') 
{
    xmlHttpObject = new XMLHttpRequest();
}
if (!xmlHttpObject) 
{
    try 
    {
        xmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e) 
    {
        try 
        {
            xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch(e) 
        {
            xmlHttpObject = null;
        }
    }
}

function testJQuery(){
	if(typeof jQuery == "function")
		  alert("jQuery geladen");
		else
		  alert("jQuery nicht geladen");
}

function loadContent(site, target)
{
    xmlHttpObject.open('get',site);
    xmlHttpObject.onreadystatechange = handleContent(target);
    xmlHttpObject.send(null);
    return false;
}

function handleContent(target)
{
    if (xmlHttpObject.readyState == 4)
    {
        document.getElementById(target).innerHTML = xmlHttpObject.responseText;
    }
}