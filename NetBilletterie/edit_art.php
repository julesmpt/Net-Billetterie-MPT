<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/configav.php");
include_once("include/language/$lang.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

if ($user_art == n) { 
echo "<h1>$lang_article_droit";
exit;  
}

$article=isset($_GET['article'])?$_GET['article']:"";
$sql = "SELECT * FROM " . $tblpref ."article  
 WHERE num=$article";

$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$article = $data['article'];
		$article=stripslashes($article);
		$num =$data['num'];
		$lieu =$data['lieu'];
		$horaire =$data['horaire'];
		$date =$data['date_spectacle'];
		$prix = $data['prix_htva'];
		$tva = $data['taux_tva'];
		$uni = $data['uni'];
		$stock = $data['stock'];
		$min = $data['stomin'];
		$max = $data['stomax'];
		$commentaire = $data['commentaire'];
		$image = $data['image_article'];
		}
	?>		
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center"><?php echo"<h3>$lang_modi_no $article </h3>"; ?></td>
	</tr>
	<tr>
		<td class="page" align="center">
			<center>
				<form action="article_update.php" method="post" name="id_tarif" id="id_tarif">
					<table class="boiteaction">
						<tr class="texte">
							<th><?php  echo "$lang_article " ?></th>
							<th>Lieu</th>
							<th>Horaire</th>
							<th>Date (aaaa-mm-jj)</th>
							<th><?php echo "$lang_stock"; ?></th>
							<th><?php echo "$lang_stomax"; ?></th>
							<th><?php echo "$lang_stomin"; ?></th>
							<th>Commentaire</th>
						</tr>
						<tr>
							<td><input name="article" type="text" size="15" value ="<?php echo"$article" ?> "></td>
							<td><input name="lieu" type="text" size="10" value ="<?php echo"$lieu" ?>"></td>
							<td><input name="horaire" type="text" size="10" value ="<?php echo"$horaire" ?>"></td>
							<td><input name="date" type="text" size="20" value ="<?php echo"$date" ?>"></td>
							<td><input name="stock" type="text" size="5" value ="<?php echo"$stock" ?>"></td>
							<td><input name="max" type="text" size="5" value ="<?php echo"$max" ?>"></td>
							<td><input name="min" type="text" size="5" value ="<?php echo"$min" ?>"></td>
							<td><input name="commentaire" type="text" size="30" value ="<?php echo"$commentaire" ?>"></td>
						</tr>
						<tr>
						<th  colspan="2">Image<br/> <img src="<?php echo $image;?>"  height="100" ></th>
								<script type="text/javascript">
								function openKCFinder(field) {
								window.KCFinder = {
								callBack: function(url) {
								field.value = url;
								window.KCFinder = null;
								}
								};
								window.open('<?php echo $url_root;?>/kcfinder/browse.php?type=images&lang=fr&dir=images/public', 'kcfinder_textbox',
								'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
								'resizable=1, scrollbars=0, width=800, height=600'
								);
								}
								</script>
						<td  colspan="6" align="left"> <input name="image"  type="text" SIZE="60" readonly="readonly" onclick="openKCFinder(this)"
							value="<?php if ($image!=""){echo $image;} else {echo"Choisir une image jpg";}?>" /><br/> Cliquez dans la case ci dessus pour choisir un fichier image: hauteur 100px<br/> 
							puis cliquer sur upload pour choisir l'image à télécharger depuis votre ordinateur<br/>et enfin double cliquer sur cette dernière.
						</td>
					</tr>
						<tr>
							<td colspan="3" class="submit">
							<input name="num" type="hidden" value= <?php echo "$num" ?></td>
							<td><input type="submit" name="Submit" value="Enregistrer les modifications"></td>
							<td colspan="4" class="submit"></td>
						</tr>
					</table>
				</form>	
			</center>			
		</td>
	</tr>
	
</table>
		
<?php

include_once("include/bas.php");
?>
</td></tr></table>
