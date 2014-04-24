<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/configav.php");
include_once("include/fonction.php");

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

$sql = "SELECT * FROM " . $tblpref ."mail 
WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
	{
	$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
	}
else{
	$sql .= "ORDER BY date DESC ";
	}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());


/* pagination */
// Paramétrage de la requête (ne pas modifier le nom des variable)

//=====================================================
// Nombre d'enregistrements par page à afficher
if ( isset ( $_GET['parpage'] ) && $_GET['parpage'] != '')
	{
	$parpage=$_GET[parpage];
	}
else
	{
	$parpage = 10;
	}
//==============================================================================
// Déclaration et initialisation des variables (ici ne rien modifier)
//==============================================================================

// On définit le suffixe du lien url qui affichera les pages
// $_SERVEUR['PHP_SELF'] donne l'arborescence de la page courante
$url = $_SERVER['PHP_SELF']."?limit=";

$total = mysql_query($sql); // Résultat total de la requête $sql
$nblignes = mysql_num_rows($total); // Nbre total d'enregistrements
// On calcule le nombre de pages à afficher en arrondissant
// le résultat au nombre supérieur grâce à la fonction ceil()
$nbpages = ceil($nblignes/$parpage); 

 // Si une valeur 'limit' est passée par url, on vérifie la validité de
// cette valeur par mesure de sécurité avec la fonction validlimit()
 // cette fonction retourne automatiquement le résultat de la requête
 $result = validlimit($nblignes,$parpage,$sql); 

?>
<script type="text/javascript" src="javascripts/confdel.js"></script>

<SCRIPT langage="Javascript">
  function ouvrir(fichier,fenetre) {
  ff=window.open(fichier,fenetre,"width=250,etc...") }
</SCRIPT>

<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
			<h3>Liste des mails envoyés </h3>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;"  >
			<center>
				<form action="lister_mail.php" method="post">
					<table >
						<tr>
							<td width="27%" class="texte0">
								<select name="annee_1">
								<option value="<?php echo"$annee_1"; ?>"><?php $date_1=$annee_1-1;echo"$date_1 -$annee_1"; ?></option>
								<option value="<?php $date=date("Y");echo"$date"; ?>"><?php $date=date("Y");$date_1=$date-1;echo"$date_1 - $date"; ?></option>
								<option value="<?php $date=(date("Y")-1);echo"$date"; ?>"><?php $date=(date("Y")-1);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
								<option value="<?php $date=(date("Y")-2);echo"$date"; ?>"><?php $date=(date("Y")-2);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
								<option value="<?php $date=(date("Y")-3);echo"$date"; ?>"><?php $date=(date("Y")-3);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
								<option value="<?php $date=(date("Y")-4);echo"$date"; ?>"><?php $date=(date("Y")-4);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
								<option value="<?php $date=(date("Y")-5);echo"$date"; ?>"><?php $date=(date("Y")-5);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
								<option value="<?php $date=(date("Y")-6);echo"$date"; ?>"><?php $date=(date("Y")-6);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
								</select> 
							</td>
							<td class="submit" colspan="4"><input type="submit" value='Choisir la saison culturelle'>
							</td>
						</tr>
					</table>
				</form> 
			</center>
			<br/>
		</td>
	</tr>
	<tr>
		<td>
			<FORM method="get" action="lister_mail.php">
				Nombre de lignes affichées :
				<SELECT name="parpage" onchange='submit()'>
					<OPTION VALUE="<?php echo$parpage;?>"><?php if ($parpage=="10000"){echo "Tout";}else{echo$parpage;}?></OPTION>
					<OPTION VALUE="20">20</OPTION>
					<OPTION VALUE="100">100</OPTION>
					<OPTION VALUE="200">200</OPTION>
					<OPTION VALUE="300">300</OPTION>
					<OPTION VALUE="10000">Tout</OPTION>
				</SELECT>
			</form>
		</td>
	</tr>
	<tr>
		<td>
			<center>
				<table class="boiteaction">	
					<caption>Liste des mails</caption>
						<tr> 
							<th width='4%'><a href="lister_mail.php?ordre=id_mail">N°</a></th>
							<th width='20%'><a href="lister_mail.php?ordre=date">Date et heure d'envoi</a></th>
							<th width='15%'><a href="lister_mail.php?ordre=user_name">Envoyés par</a></th>
							<th width='35%'><a href="lister_mail.php?ordre=objet">Objet</a></th>
							<th width='8%'><a href="lister_mail.php?ordre=message">Message</a></th>
							<th ><a href="lister_mail.php?ordre=mail_client">Destinataires</a></th>
						</tr>
							<?php
							$nombre="1";
							while($data = mysql_fetch_array($result))
							{
							$id_mail = $data['id_mail'];
							$user_name = $data['user_name'];
							$date = $data['date'];
							list($annee2, $mois2, $jour2) = explode("-", $date);
							list($jour, $heure) = explode("", $jour2);
							$objet = stripslashes($data['objet']);
							$message = stripslashes($data['message']);
							$mail_client = $data['mail_client'];
							$nombre = $nombre +1;
							if($nombre & 1){
							$line="0";
							}
							else{
							$line="1";
							}
							?>
						<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
							<td class="highlight"><?php echo $id_mail;?></td>
							<td class="highlight"><?php echo $date;?></td>
							<td class="highlight"><?php echo $user_name;?></td>
							<td class="highlight"><?php echo $objet; ?></td>
							<td class="highlight"><a href="voir_mail.php?id_mail=<?php echo $id_mail;?>" onClick="ouvrir(this.href,this.target);return false"><img src="image/voir.gif"></a></td>
							<td class="highlight"><a href="voir_destinataires.php?id_mail=<?php echo $id_mail;?>" onClick="ouvrir(this.href,this.target);return false"><img src="image/voir.gif"></a></td>
							<?php }?>
						</tr>
						<tr>
							<td colspan="5" class="submit"></td>
						</tr>
				</table>
			</center>
		</td>
	</tr>
	<tr>
		<td>
			<?php
			//=====================================================
			// Menu de pagination que l'on place après la requête 
			//======================================================
			 echo "<div class='pagination'>";
			 echo pagination($url,$parpage,$nblignes,$nbpages,$initial);
			function position($parpage){
			if (isset($_GET['limit'])) {
				$pointer = split('[,]', $_GET['limit']); // On scinde $_GET['limit'] en 2
				$debut = $pointer[0];
				$page = ($debut/$parpage)+1;
			return $page;
			}
			}
			 echo "</div>";
			 mysql_free_result($result); // Libère le résultat de la mémoire
			 ?>
		</td>
	</tr>
</table>

<?php
include_once("include/bas.php");
?> 

