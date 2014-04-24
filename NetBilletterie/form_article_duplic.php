<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("javascripts/verif_form.js");
include_once("include/head.php");
include_once("include/finhead.php");


$num=isset($_GET['num'])?$_GET['num']:"";
$sql = "SELECT * FROM ".$tblpref."article  
 WHERE num=$num";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$article = $data['article'];
		$num =$data['num'];
		$lieu =$data['lieu'];
		$horaire =$data['horaire'];
		$date =$data['date_spectacle'];
		list($annee, $mois, $jour) = explode("-", $date);
		$image_article = $data['image_article'];
		$commentaire = $data['commentaire'];
		$stock = $data['stock'];
		$min = $data['stomin'];
		$max = $data['stomax'];
		} 
?>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<h3>Formulaire de duplication de spectacle</h3>
</td>
</tr>
<tr>
<td  class="page" align="center">
<?php 
if ($user_art == n) { 
echo "<h1>$lang_article_droit";
exit;  
}
 if ($message1 !='') {
 echo"<table><tr><td>$message1</td></tr></table>";
}


?>
  
<form action="article_new.php" method="post" name="article" id="article" onSubmit="return verif_formulaire()" enctype="multipart/form-data" >
	<center>
		<table>
		  <caption>
		  Changer la date, horaire, lieu ...
		  </caption>
		<tr> 
			<td class='<?php echo couleur_alternee (); ?>'> <?php echo "$lang_art_no"; ?> </td>
			<td align=left> <input name="article" type="text" id="article" size="80" maxlength="40" value="<?php echo $article;?> ">
			</td>
		</tr>
		<tr> 
			<td class='<?php echo couleur_alternee (); ?>'>Lieu </td>
			<td align=left> <input name="lieu" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $lieu;?> ">
			</td>
		</tr>
		<tr> 
			<td class='<?php echo couleur_alternee (); ?>'>horaire</td>
			<td align=left> <input name="horaire" type="text" id="horaire" size="20" maxlength="40" value="<?php echo $horaire;?> ">
			</td>
		</tr>
		<tr> 
			<td class='<?php echo couleur_alternee (); ?>'>DATE 
				</td>
			<td align=left>
				Jour(JJ)<input name="jour" type="text" id="jour" size="8" maxlength="2" value="<?php echo $jour;?>">
				Mois(MM)
				<input name="mois" type="text" id="mois" size="8" maxlength="2" value="<?php echo $mois;?>">
				Année (AAAA)
				<input name="annee" type="text" id="annee" size="16" maxlength="4" value="<?php echo $annee;?>">
			</td>
		 <tr> 
			<td class='<?php echo couleur_alternee (); ?>'> <?php echo "$langCommentaire" ?> : </td>
			<td class='<?php echo couleur_alternee (FALSE); ?>'><input name="commentaire" type="text" size="80" id="commentaire" value="<?php echo $commentaire;?> ">
			</td>
		  </tr>
		  <tr>
			<td class='<?php echo couleur_alternee (); ?>'><?php echo "$lang_stock"; ?></TD>
			<td align=left><input name='stock' type='text' value="<?php echo $stock;?> "> </td>
		  </tr>
		  <tr>
			<td class='<?php echo couleur_alternee (); ?>'><?php echo"$lang_stomin"; ?></td>
			<td align=left><input name='stomin' type='text' value="<?php echo $min;?> "></td>
		  </tr>
		  <tr>
			<td class='<?php echo couleur_alternee (); ?>'><?php echo"$lang_stomax"; ?></td>
			<td align=left><input name='stomax' type='text' value="<?php echo $max;?> "></td>
		  </tr>
			   <!-- On limite le fichier à 100Ko -->
		<tr>
			<td class='<?php echo couleur_alternee (); ?>'><img src="<?php echo$image_article; ?>" height="100"></td>
		</tr>
            <td class="submit" colspan="2">
			<input type="hidden" name="image" value="<?php echo $image_article;?>">
			<input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0"> 
            </td>
        </tr>
        </table>
    </center>
</form>
<?php
require_once("lister_articles.php");
?>





