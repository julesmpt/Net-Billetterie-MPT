<!-- Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors: José Das Neves pitu69@hotmail.fr-->
<HEAD>
<script type="text/javascript">
<!-- Begin
/* Ce script et d'autres sont sur le code java GRATUIT
Le code java - http://www.lecodejava.com
 */

function reFresh() {
  location.reload(true)
}
/* Definir le temp de refraichir le nombre en  in milliseconds, 1 minute = 60000 milliseconds. */
window.setInterval("reFresh()",10000);
// End -->
</script>
</HEAD>
<?php 
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/headers.php");


$nbr=isset($_POST['nbr'])?$_POST['nbr']:"";

	// ==================================================
	// Pour que la page se rafraichisse sans arret = delai 
		$url =$_SERVER['SCRIPT_NAME'];
		$dom =$_SERVER['HTTP_HOST'];
	$delai=5; //en seconde//
	$url="http://$dom$url";
	header("Refresh: $delai;url=$url");
	// ==================================================




	if ($nbr=="")
	{
	//On ouvre le fichier en lecture et ecriture
	$fichier_a_ouvrir = fopen ("nbr.txt", "r+");
	}
	
	if ($nbr!="")
	{
	//On ouvre le fichier en lecture et ecriture ça marche mieu avec w+ au lieu de r+
	$fichier_a_ouvrir = fopen ("nbr.txt", "r+");
		//On écrit le nouveau chiffre
		fwrite($fichier_a_ouvrir,$nbr);	
	}
	fseek($fichier_a_ouvrir, 0);

	$nbr = fgets($fichier_a_ouvrir);

	?>
<div id="bandeau2">
	<h1><?php echo $slogan; ?></h1>
	Nous nous occupons actuellement du spectateur<br><b style="color:#ffffff; font-size: 370px;"><?php echo $nbr; ?></b>
</div>

<div id="piedpage">
		<form action="projection.php" method="POST">		
		<input type=button value='-' onclick='javascript:process(1)'>Nous nous occupons actuellement du spectateur N° 
		<input type=test  id='v' name='nbr' value='<?php echo $nbr; ?>'>
		<input type=button value='+' onclick='javascript:process(-1)'>
			<script language=javascript>
			function process(v){
			document.getElementById('v').value-=v;
			}
			</script>
		<input type="submit" name="Submit" value="Enregister" >
	<form/>	
	<br>
	<a href='lister_articles.php' >Retour à Net-Billetterie</a><br>
	<a href='Projection_numero.php' >N'afficher que le Numéro</a>
</div>


