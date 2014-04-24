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
//on recupère les infos des tarifs
$sql = "SELECT * FROM " . $tblpref ."tarif
WHERE saison BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
if ($user_admin == 'n')
{
$sql.="AND nom_tarif<> 'Gratuit'";}

if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
{
$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
}else{
$sql .= "ORDER BY saison ASC ";}

$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
?>

<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
		    	<h3>Liste des différents tarifs 
			<?php if ($user_admin != 'n'){?>
			<SCRIPT LANGUAGE="JavaScript">
				if(window.print)
					{
					document.write('<A HREF="javascript:window.print()"><img border=0 src= image/printer.gif ></A>');
					}
				</SCRIPT>
				<?php } ?>
			
			<br>
			</h3>
		    <h1>Seul les administrateurs peuvent utiliser le tarif "gratuit"</h1>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;"  >			
			<?php 
			if ($user_art == n) { 
			echo "<h1>$lang_tarif_droit";
			exit;  
			}
			if ($message !='') { 
			 echo "<table><tr><td>$message</td></tr></table>"; 
			}	
			?>
	  		<center>        
				<form action="lister_tarif.php" method="post">
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
	  			<caption><?php echo $lang_tarif_liste; ?></caption>
	  			<tr>
			    		<th><a href="lister_tarif.php?ordre=nom_tarif"> <?php echo $lang_tarif; ?></a></th>
					<th><a href="lister_tarif.php?ordre=prix_tarif"><?php echo $lang_prix_tarif; ?></a></th>
					<th>Num&eacute;ro du ticket au d&eacute;part du carnet</th>
					<th>sélectionnable</th>
					<th colspan="2"><?php echo $lang_action; ?></th>
  				</tr>
				<?php
					$nombre="1";
				while($data = mysql_fetch_array($req)){
					$nom_tarif = $data['nom_tarif'];
					$prix_tarif = $data['prix_tarif'];
					$id_tarif =$data['id_tarif'];
					$carnet =$data['carnet'];
					$nombre = $nombre +1;
					$selection =$data['selection'];
					if($nombre & 1){
				$line="0";
				}else{
				$line="1";
				 }
				?>
				<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
					<td class="highlight"><?php echo "$nom_tarif"; ?></td>
					<td class="highlight"><?php echo "$prix_tarif";?><?php echo "$devise";?></td>
					<td class="highlight"><?php echo "$carnet"; ?></td>
					<td class="highlight"><?php if ($selection=='1') {echo "oui";} else {echo "<b> Non selectionnable -> Carnet vide</b>"; } ?></td>
					<td class="highlight"><a href='edit_tarif.php?id_tarif=<?php echo $id_tarif; ?>'><img border=0 alt="<?php echo $lang_editer; ?>" src="image/edit.gif"></a></td>
					<td class="highlight"><a href="delete_tarif.php?id_tarif=<?php echo $id_tarif; ?>" onClick="return confirmDelete('<?php echo"$lang_tarif_effa ?"; ?>')"><img border=0 alt="<?php echo $lang_suprimer; ?>" src="image/delete.jpg" ></a></td>
				</tr>
				<?php
				}
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td><a href="form_tarif.php" rel="menu5"><img border ="0" src="image/tarif.png" alt="Tarifs">Créer un Tarifs</a>
		</td>
	</tr>
</table>
<?php
include_once("include/bas.php");
?>


