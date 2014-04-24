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
WHERE date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
	{
	$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
	}
else{
	$sql .= "ORDER BY date_spectacle ASC ";
	}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<script type="text/javascript" src="javascripts/confdel.js"></script>

<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
			<h3>Liste des spectacles </h3>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;"  >


         <center>
        	<form action="lister_articles.php" method="post">
        			<table >
						<tr>
							<td width="27%" class="texte0">
							    	<select name="annee_1">
									<option value="<?php echo"$annee_1"; ?>"><?php $date_1=$annee_1-1;echo"$date_1 -$annee_1"; ?></option>
									<option value="<?php $date=(date("Y")+1);echo"$date"; ?>"><?php $date=(date("Y")+1);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=date("Y");echo"$date"; ?>"><?php $date=date("Y");$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-1);echo"$date"; ?>"><?php $date=(date("Y")-1);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-2);echo"$date"; ?>"><?php $date=(date("Y")-2);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-3);echo"$date"; ?>"><?php $date=(date("Y")-3);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-4);echo"$date"; ?>"><?php $date=(date("Y")-4);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-5);echo"$date"; ?>"><?php $date=(date("Y")-5);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-6);echo"$date"; ?>"><?php $date=(date("Y")-6);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									</select>
							</td>
							<td class="submit" colspan="4"><input type="submit" value='Choisir la saison culturelle'></td>
						</tr>
	       			</table>
	    	</form> 
	    </center>
		<br>
  <center><table class="boiteaction">	

  <caption><?php echo $lang_articles_liste; ?></caption>
  <tr> 
  <th> Image</th>
		<th><a href="lister_articles.php?ordre=article"> <?php echo $lang_article; ?></a></th>
		<th><a href="lister_articles.php?ordre=lieu">Lieu</a></th>
		<th><a href="lister_articles.php?ordre=horaire">horaire</a></th>
		<th><a href="lister_articles.php?ordre=date_spectacle">date</a></th>
		<th><a href="lister_articles.php?ordre=stock"><?php echo $lang_stock; ?></a></th>
		<th><a href="lister_articles.php?ordre=stomax"><?php echo $lang_stomax; ?></a></th>
		<th><?php echo $langCommentaire2; ?></th>
		<?php if ($user_art != n) 
		{ ?> 
		<th><a href="lister_articles.php?ordre=stomax">Liste des spectateurs</a></th>
		<th colspan="3"><?php echo $lang_action; ?></th>
		<?php } ?> 
  </tr>
  <?php
	$nombre="1";
while($data = mysql_fetch_array($req))
    {
		$article = $data['article'];		
		$article_html = stripslashes($article);
		$lieu = $data['lieu'];
		$lieu_html=stripslashes($lieu);
		$horaire = $data['horaire'];
		$date = $data['date_spectacle'];
		$num =$data['num'];
		$prix = $data['prix_htva'];
		$tva = $data['taux_tva'];
		$uni = $data['uni'];
		$stock = $data['stock'];
		$commentaire = $data['commentaire'];
		$max = $data['stomax'];
		$image = $data['image_article'];
		list($annee, $mois, $jour) = explode("-", $date);
                if ($stock<=0 ) {
  	$stock="<h3>$stock</h3>";
		}
		if ($stock <= $min ||$stock >= $max  ) { 
  	$stock="<h1>$stock</h1>";
		}
		
		$nombre = $nombre +1;
		if($nombre & 1){
			$line="0";
			}
		else{
			$line="1";			 
			}
		?>
		<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
		<td class="highlight"><img src="<?php echo$image; ?>" height="100"></td>
		<td class="highlight"><?php echo $article_html; ?></td>	
		<td class="highlight"><?php echo $lieu_html; ?></td>
		<td class="highlight"><?php echo $horaire; ?></td>
		<td class="highlight"><?php echo $jour . '-' . $mois . '-' . $annee; ?></td>		
		<td class="highlight"><?php echo $stock; ?></td>
		<td class="highlight"><?php echo $max; ?></td>
		<td class="highlight"><?php echo $commentaire; ?></td>
			<?php 
			if ($user_art != n) 
			{ ?> 
		<td class="highlight"><a href='lister_spectateurs.php?article=<?php echo $num; ?>'>liste des spectateurs pour ce spectacle</a></td>
		<td class="highlight"><a href='edit_art.php?article=<?php echo $num; ?>' title='Editer'>
			<img border=0 alt="<?php echo $lang_editer; ?>" src="image/edit.gif" alt='Editer'></a></td>
	    <td class="highlight"><a href='form_article_duplic.php?num=<?php echo $num; ?>' title='Dupliquer'>
			<img border=0 alt="dupliquer ce spectacle" src="image/duplicat.png" alt='Dupliquer'></a></td>
		<td class="highlight"><a href="delete_article.php?article=<?php echo $num; ?>" onClick="return confirmDelete('<?php echo"$lang_art_effa $article_html ?"; ?>')" title='Supprimer'>
			<img border=0 alt="<?php echo $lang_suprimer; ?>" src="image/delete.png" ></a>
		</td> 
			<?php }?>
	</tr>
    <?php
		}
 ?>
 <tr><td colspan="10" class="submit"></td>
  </table>
  </center>
  <?php
 $aide = article;
 ?>
<?php

include_once("include/bas.php");

$url = $_SERVER['PHP_SELF'];
$file = basename ($url);
if ($file=="form_article.php") { 
echo"</table>"; 
} ?>
</table></body>
</html>
