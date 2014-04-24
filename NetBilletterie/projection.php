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
<div id="bandeau">
	Nous nous occupons actuellement du spectateur<br><b style="color:#ffffff; font-size: 170px;"><?php echo $nbr; ?></b>
</div>

<hr/>
<div id="contenu">
		<?php 
//=============================================
//pour que les articles soit classés par saison
$mois=date("n");
if ($mois=="10"||$mois=="11"||$mois=="12") {
 $mois=date("n");
}
else{
  $mois =date("0n");
}
$jour =date("d");
$date_ref="$mois-$jour";
$annee = date("Y");
//pour le formulaire
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";
if ($annee_1=='') 
{
  $annee_1= $annee ;
  if ($mois.'-'.$jour <= $fin_saison)
  {
  $annee_1=$annee_1;
  }
  if ($mois.'-'.$jour >= $fin_saison)
  {
  $annee_1=$annee_1+1;
  }  
}
$annee_2= $annee_1 -1;
//=============================================

		$sql = "SELECT * FROM " . $tblpref ."article 
		WHERE date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison' ORDER BY date_spectacle";
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$nombre="1";
		while($data = mysql_fetch_array($req))
			{
				$article = $data['article'];
				$image = $data['image_article'];		
				$article_html = stripslashes($article);
				$lieu = $data['lieu'];
				$lieu_html=stripslashes($lieu);
				$horaire = $data['horaire'];
				$date = $data['date_spectacle'];
				$min = $data['stomin'];
				$stock = $data['stock'];
				$actif = $data['actif'];
				$image = $data['image_article'];
				list($annee, $mois, $jour) = explode("-", $date);
				
				if ($stock<=0 ) 
				{                                                
					$option="<FONT COLOR='#961a1a'>COMPLET</font> ";
				}
				elseif($stock <= $min && $stock >= 1  ) 
				{
					$stock_txt="Attention plus que ".$stock." places";
					$option="<BLINK><FONT COLOR='#961a1a'> ".$stock_txt." </font></BLINK> ";
				}
				else 
				{
				 $stock_txt= "Il reste encore ".$stock." places";
				 $option="".$stock_txt."";
				}
				
				
				?>
				<div id="bloprojection"><h1><?php echo $article ;?></h1><img class="photo" src="<?php echo $image;?>" height="100px"><br><?php echo $option; ?></div>
			<?php
			}
			?>
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
	<h1><?php echo $slogan; ?></h1>
	<a href='lister_articles.php' >Retour à Net-Billetterie</a><br>
	<a href='Projection_numero.php' >N'afficher que le Numéro</a>
</div>


