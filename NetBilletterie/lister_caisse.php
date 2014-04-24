<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
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

//on recupère les infos de la caisse par num d'enregistrement
$sql = "SELECT * FROM " . $tblpref ."enregistrement_caisse
	WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
	if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != ''){
	$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
	}else{
	$sql .= "ORDER BY date DESC ";}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

//on recupère le total en caisse
$sql3 = "SELECT SUM(total) as total_caisse FROM " . $tblpref ."enregistrement_caisse
	WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
	$req3= mysql_query($sql3) or die('Erreur SQL3 !<br>'.$sql3.'<br>'.mysql_error());
while($data = mysql_fetch_array($req3))
{
$total_caisse = $data['total_caisse'];
}
?>


<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
		    	<h3>Liste des différents enregistrements de caisse journalière
			<?php if ($user_admin != 'n'){?>
			<SCRIPT LANGUAGE="JavaScript">
				if(window.print)
					{
					document.write('<A HREF="javascript:window.print()"><img border=0 src= image/printer.gif ></A>');
					}
				</SCRIPT>
				<?php } ?>
			<br> <hr>
			La caisse est actuellement de <FONT face="Comic Sans MS" color="red"><?php echo "$total_caisse $devise"; ?></FONT>
			</h3>
		</td>
	</tr>
	<?php 
			if ($message !='') { 
			 echo stripslashes("<tr><td><h1>$message</h1></td></tr>"); 
			}	
			?>
	<tr>
		<td style="text-align:center;"  >
	  		<center>        
				<form action="lister_caisse.php" method="post">
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
		</td>
	</tr>
	<tr>
		<td>
			<table class="boiteaction">
	  			<caption>Liste des encaissements et prélèvements</caption>
	  			<tr>
					<th><a href="lister_caisse.php?ordre=id_enregistrement_caisse">N°</a></th>
					<th>date</th>
					<th><a href="lister_caisse.php?ordre=libelle">Commentaire</a></th>
					<th>Total de <br>l'enregistrement</th>
					<th><a href="lister_caisse.php?ordre=user">Par ?</a></th>
					<th>Types d'espèce</th>
					<th>Nbr</th>
					<th>total</th>
					<th colspan="2"><?php echo $lang_action; ?></th>
  				</tr>
						<?php
						while($data = mysql_fetch_array($req))
						{
							$id_enregistrement_caisse = $data['id_enregistrement_caisse'];
							$libelle = $data['libelle'];
							$libelle=stripslashes($libelle);
							$date = $data['date'];
							$jour = ucwords(strftime("%d", strtotime($data['date'])));
							$mois = ucwords(strftime("%m", strtotime($data['date'])));
							$annees = ucwords(strftime("%Y", strtotime($data['date'])));
							$date=" $jour-$mois-$annees";
							$total = $data['total'];
							$user = $data['user'];
						?>
				<tr class="texte1" onmouseover="this.className='highlight'" onmouseout="this.className='texte1'">
					<td class="highlight"><?php echo "$id_enregistrement_caisse"; ?></td>
					<td class="highlight"><?php echo "$date"; ?></td>
					<td class="highlight"><?php echo "$libelle"; ?></td>
					<td class="highlight"><b><FONT color="red"><?php echo "$total"; ?><?php echo "$devise";?></font></b></td>
					<td class="highlight"><?php echo "$user"; ?></td>
					<td class="highlight" colspan="3">&nbsp;</td>
					<td class="highlight"><a href='form_edit_caisse.php?id_enregistrement_caisse=<?php echo $id_enregistrement_caisse; ?>' title="<?php echo $lang_editer; ?>"><img border=0 alt="<?php echo $lang_editer; ?>" src="image/edit.gif"></a></td>
					<td class="highlight"><a href="delete_caisse.php?id_enregistrement_caisse=<?php echo $id_enregistrement_caisse; ?>" onClick="return confirmDelete('voulez-vous vraiment effacer cet enregistrement?')" title="<?php echo $lang_suprimer; ?>"><img border=0 alt="<?php echo $lang_suprimer; ?>" src="image/delete.jpg" ></a></td>
				</tr>
						<?php
							$sql2 = "SELECT * FROM ".$tblpref."caisse
							WHERE id_enregistrement_caisse=$id_enregistrement_caisse";
							$req2 = mysql_query($sql2) or die('Erreur SQL 2!<br>'.$sql2.'<br>'.mysql_error());
							
						while($data = mysql_fetch_array($req2))
						{
							$id_caisse = $data['id_caisse'];
							$espece = $data['espece'];
							$nbr = $data['nbr'];
							$total =$data['total'];
							$nombre2 = $nombre2 + $nombre;
                            if($nombre2 & 1){
                            $line2="1";
                            }else{
                            $line2="0";
                            }
						?>
				<tr class="texte0" onmouseover="this.className='highlight'" onmouseout="this.className='texte0'">
					<td class="highlight" colspan="5">&nbsp;</td>
					<td class="highlight"><?php echo "$espece"; ?><?php echo "$devise";?></td>
					<td class="highlight"><?php echo "$nbr";?></td>
					<td class="highlight"><?php echo "$total"; ?><?php echo "$devise";?></td>
					<td colspan="2">&nbsp;</td>
				</tr>
					<?php
					}}
					?>
			</table>
		</td>
	</tr>
</table>
<?php
include_once("include/bas.php");
?>


