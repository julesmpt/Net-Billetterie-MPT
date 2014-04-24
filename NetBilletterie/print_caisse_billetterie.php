<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/utils.php");
include_once("include/themes/default/style_print.css");

$date_debut=isset($_GET['date_debut'])?$_GET['date_debut']:"";
	list($jour, $mois, $annee) = explode("-", $date_debut);
$date01 = "$annee-$mois-$jour";
$date_fin=isset($_GET['date_fin'])?$_GET['date_fin']:"";
	list($jour, $mois, $annee) = explode("-", $date_fin);
$date02 = "$annee-$mois-$jour";
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
//on recupère les infos de la caisse billetterie par num d'enregistrement
$sql = "SELECT * FROM " . $tblpref ."enregistrement_caisse
		WHERE libelle='billetterie' ";
		if ( $date_debut ==""){
		$sql.= " AND	date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
		ORDER BY date DESC";
		}
		else {
		$sql.= " AND date BETWEEN '$date01' AND '$date02 23:59:59'
		ORDER BY date DESC";
		}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

//on recupère le total en caisse
$sql3 = " SELECT IF(total<0,total,0) neg ,
IF(total>0,total,0) pos, id_enregistrement_caisse
FROM ".$tblpref."enregistrement_caisse
WHERE libelle='billetterie'
ORDER BY `id_enregistrement_caisse` DESC
LIMIT 0,1";
$req3= mysql_query($sql3) or die('Erreur SQL3 !<br>'.$sql3.'<br>'.mysql_error());
	while($data = mysql_fetch_array($req3)){
		$id_enregistrement_caisse = $data['id_enregistrement_caisse'];
		$neg = $data['neg'];
		$pos = $data['pos'];

		//si le dernier enregistrement est negatif (un retrait)
		if($neg!="0"){
			$sql5 = " SELECT sum(total) AS total_caisse
			FROM (SELECT total from ".$tblpref."enregistrement_caisse
			WHERE libelle='billetterie'
			ORDER BY `id_enregistrement_caisse` DESC
			LIMIT 0,2)
			AS total_caisse";
			$req5= mysql_query($sql5) or die('Erreur SQL5 !<br>'.$sql5.'<br>'.mysql_error());
			while($data = mysql_fetch_array($req5)){
				$total_caisse = $data['total_caisse'];
			}
		}

			//si le dernier enregistrement est positif
			if($pos!="0"){
				$total_caisse = $pos;
			}
	}
?>
<script type="text/javascript">
window.print() ;
</script>

<page >

<a href="impression_caisse.php" class="noImpr"><img src="image/retour.png">Revenir en arriére</a><br/>
<div><img src="<?php echo $logo;?>"  width="200" align="left" >
<?php echo "<h4>$slogan $annee_2-$annee_1</h4>$c_postal $ville <br/>$tel <br/> $mail";?></div>
<br/>
<h1>Caisse billetterie</h1>
	<h2>La caisse des espèces est actuellement de <FONT face="Comic Sans MS" color="red"><?php echo "$total_caisse $devise"; ?></FONT></h2>
			Avec <br/>
			<?php
			//On montre ce qu'il y a dans la caissse à ce moment 
				if($pos!="0"){
					$sql1 = "SELECT
							nbr as nbr1, espece, ".$tblpref."caisse.total as total1, libelle FROM `".$tblpref."caisse`, `".$tblpref."enregistrement_caisse`
							WHERE ".$tblpref."caisse.id_enregistrement_caisse=$id_enregistrement_caisse
							AND ".$tblpref."enregistrement_caisse.libelle='billetterie'
							GROUP BY espece";
					$req1= mysql_query($sql1) or die('Erreur sql1 !<br>'.$sql1.'<br>'.mysql_error());
					while($data = mysql_fetch_array($req1))
						{
						$total = $data['total1'];
						$nombre = $data['nbr1'];
						$espece = $data['espece'];
						echo "En espèce de $espece $devise = $total $devise <br> ";
						}
				}
				if($neg!="0"){
					$sql4 = "SELECT `id_caisse`, `id_enregistrement_caisse` AS iec, `espece`, SUM(`nbr`) AS nbr2, SUM(`total`) AS total2 FROM `".$tblpref."caisse`
								WHERE `id_enregistrement_caisse`>=$id_enregistrement_caisse-1
								GROUP BY espece";
					$req4= mysql_query($sql4) or die('Erreur SQL4 !<br>'.$sql4.'<br>'.mysql_error());
						while($data = mysql_fetch_array($req4))
					{
					$total = $data['total2'];
					$nombre = $data['nbr2'];
					$espece = $data['espece'];
					echo "$espece $devise X $nombre= $total $devise <br> ";
					}
				}

			?>

<br/>
<br/>
<br/>
<table class="liste">
	<caption><h2><?php if ( $date_debut == ''){
																		echo "Liste de tous les enregistrements. ";
																		}
																		if ( $date_debut != ''){
																		echo "liste des enregistrements pour la pèriode du $date_debut au $date_fin";
																		}
																		?></h2></caption>
	<tr>
		<th>N°</th>
		<th>date</th>
		<th>Commentaire</th>
		<th>Total de <br>l'enregistrement</th>
		<th>Par ?</th>
		<th>Types d'espèce</th>
		<th>Nbr</th>
		<th>total</th>
	</tr>
			<?php
			while($data = mysql_fetch_array($req))
			{
				$id_enregistrement_caisse = $data['id_enregistrement_caisse'];
				$commentaire = $data['commentaire'];
				$commentaire=stripslashes($commentaire);
				$date = $data['date'];
				$jour = ucwords(strftime("%d", strtotime($data['date'])));
				$mois = ucwords(strftime("%m", strtotime($data['date'])));
				$annees = ucwords(strftime("%Y", strtotime($data['date'])));
				$date=" $jour-$mois-$annees";
				$total = $data['total'];
				$user = $data['user'];
			?>
	<tr>
		<td><?php echo "$id_enregistrement_caisse"; ?></td>
		<td><?php echo "$date"; ?></td>
		<td><?php echo "$commentaire"; ?></td>
		<td><b><FONT color="red"><?php echo "$total"; ?><?php echo "$devise";?></font></b></td>
		<td><?php echo "$user"; ?></td>
		<td class="highlight" colspan="3">&nbsp;</td>
	</tr>
			<?php
				$sql2 = "SELECT * FROM ".$tblpref."caisse
				WHERE id_enregistrement_caisse=$id_enregistrement_caisse
				GROUP BY espece";
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
		<td><?php echo "$espece"; ?><?php echo "$devise";?></td>
		<td><?php echo "$nbr";?></td>
		<td><?php echo "$total"; ?><?php echo "$devise";?></td>
	</tr>
		<?php
		}}
		?>
</table>

</page>

