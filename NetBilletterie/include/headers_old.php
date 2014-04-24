<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
include_once("include/configav.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
	<title>Billetterie saison culturelle</title>
<link rel="stylesheet" type="text/css" href="include/themes/<?php echo"$theme";?>/style.css">
<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >
<link rel="stylesheet" type="text/css" href="include/themes/default/menu/menu.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
<script src="javascripts/menu.js">
/***********************************************
* DD Mega Menu (c) Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/
</script>


<script>

ddmegamenu.docinit({
	menuid:'solidmenu',
	dur:200 //<--no comma after last setting
})

	
ddmegamenu.docinit({
	menuid:'megaanchorlink',
	dur:500,
	easing:'easeInOutCirc' //<--no comma after last setting
})

</script>
<script language="JavaScript">
window.history.forward();
var layers = false;
var ie4 = (document.all) ? true : false;
var ns6 = (document.getElementById&&!document.all) ? true : false;
if (ie4 || ns6) {layers = true;} 

 
function test_f5(e)

{ 
var val="";
if(ie4)	{
	val="K"+window.event.keyCode;
	if (val == "K116" || val == "F17") { 
		window.close();
	} else {
		return true; 
	}
}
if (ns6) {
	val="K"+e.which;
	if (val == "K116") { 
		window.close();
	} else {
		return true; 
	}
}
}

function noBack(){window.history.forward()} 
noBack(); 
window.onload=noBack; 
window.onpageshow=function(evt){if(evt.persisted)noBack()} 
window.onunload=function(){void(0)} 
</script> 
</head>
<?php include_once("../analytics.php") ;?>
	<body onunload="window.history.forward();" onKeyDown="test_f5(event)">
		<a name="retour"></a>
