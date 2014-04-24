<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/

// include the Zebra_Session class
include_once("include/config/common.php");
include 'include/lib/Zebra_Session.php';
// instantiate the class
// this also calls session_start()
$session = new Zebra_Session;
//pour regenerer un id a cghque fois
//$session->regenerate_id();
   
if (isset ($_POST) && !empty($_POST['login']) && !empty($_POST['pass']))
{
  extract($_POST);
  $pass=md5($pass);
  
  $sql="SELECT * FROM ".$tblpref."user WHERE login='$login' AND pwd='$pass' ";
  $req=mysql_query($sql) or die (mysql_error());
  if( mysql_num_rows($req)>0)
  {
    $data = mysql_fetch_array($req);
    $login = $data['login'];
    $num=$data['num'];
    
    $_SESSION['Auth']=array(
    'login' =>$login,
    'pass'  =>$pass,
    'lang'  =>'fr',
    'tblpref'=>$tblpref,
    'num'   =>$num
    ); 
    header('location:lister_commandes.php');
  }
  else{
      echo"<h1>Mauvais identifiant ou mot de passe</h1>";  
  }
}

include_once("include/config/var.php"); 
if (!isset($lang)) {
   $lang ="$default_lang";
}
include_once("include/language/$lang.php");

$dir='installeur/index.php';
if (file_exists($dir)) {
	echo"<h1>le dossier d'installation n'est pas supprimer</h1>";
}
?>

<script type="text/javascript">
	function popUp(URL) {
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=250,height=450,left = 412,top = 234');");
	}
</script>

<script language="JavaScript">
<!--
function couleur(obj) {
     obj.style.backgroundColor = "#FFFFFF";
}
 
function check() 
{
  var msg = "";  
	if (document.login.nom.value == "")  
	{
		msg += "Veuillez saisir votre identifiant\n";
		document.login.nom.style.backgroundColor = "#F3C200";
	}

	if (document.login.pass.value == "") 
	{
		msg += "Veuillez saisir votre mot de passe\n";
		document.login.pass.style.backgroundColor = "#F3C200";
	}

	if (msg == "") return(true);
	else 
	{
		alert(msg);
		return(false);
	}
}
//-->
</script> 
<?php
if (ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])) {?>
    <BODY onLoad="javascript:popUp('ie.php')">
		<?php
} 
?>
<style>
body {
		background-color:#454545;
	}
h1 {
	font-size:1.5em;
	text-align: center;
	opacity:0.5;
	background-color: #FFEFD5;}

h2 {
	font-size:1em;
	text-align: center;
	opacity:0.5;
	background-color: #FFEFD5;}

#global {
	position: relative;
	background-repeat:no-repeat;
	margin-left: auto;
	margin-right: auto;
	width: 700; 
	height:500;
	top: 20px;
}
#form{
	color:#ffffff;
	position: absolute;
	top: 100px;
	width: 20%;
}
#logo{
	opacity:0.8;
	position: absolute;
	width:260px;
	height:260px;
	top: 300px;
	
}
#image{
	position: absolute;
	width:260px;
	height:260px;
	top: 100px;
	left:300px;
	
}

</style>
<body>
<div id=global>

	<div>
		<a href="http://net-billetterie.tuxfamily.org/"><h1>Net-Billetterie</h1></a><h2>Logiciel de billetterie et de gestion des abonnements</h2>
	</div>
	<div id=image>
		<a href="http://net-billetterie.tuxfamily.org/"><img src="image/logoNetBilletterie.png" alt="NetBilletterie" ></a>
	</div>
	<div id=logo>
		<a href="<?php echo $site;?>"><img src="<?php echo $logo;?>"   width="200"></a>
	</div>
	<div id=form>
		<form action="login.inc.php" name="login" method='post' onSubmit="return check();">
			<?php echo $lang_login ?><input type="text" name="login" id="nom" maxlength="250"><br/>
			<?php echo $lang_mai_cr_pa ?><input type="password"name="pass" id="pass" maxlength="30"><br/>
			<input name="submit" type="Image" src="image/cadenas.png" border="0" /> 
		</form>
	</div>
</div>
</body>


