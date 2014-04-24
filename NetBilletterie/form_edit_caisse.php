<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/var.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

$id_enregistrement_caisse=isset($_GET['id_enregistrement_caisse'])?$_GET['id_enregistrement_caisse']:"";

$sql1 = "SELECT * FROM ".$tblpref."enregistrement_caisse
	WHERE id_enregistrement_caisse='$id_enregistrement_caisse'";
$req1 = mysql_query($sql1) or die('Erreur SQL 1!<br>'.$sql1.'<br>'.mysql_error());
while($data = mysql_fetch_array($req1))
{$commentaire = $data['commentaire'];
$commentaire=stripslashes($commentaire); 
$total = $data['total'];
$pointe = $data['pointe'];}

$sql2 = "SELECT * FROM ".$tblpref."caisse
	WHERE id_enregistrement_caisse='$id_enregistrement_caisse'";
$req2 = mysql_query($sql2) or die('Erreur SQL 2!<br>'.$sql2.'<br>'.mysql_error());

?>

<script type="text/javascript">
function addition()
{
var ch01=new Number(document.cj.nbr01.value);
var ch02=new Number(document.cj.nbr02.value);
var ch05=new Number(document.cj.nbr05.value);
var ch1=new Number(document.cj.nbr1.value);
var ch2=new Number(document.cj.nbr2.value);
var ch5=new Number(document.cj.nbr5.value);
var ch10=new Number(document.cj.nbr10.value);
var ch20=new Number(document.cj.nbr20.value);
var ch50=new Number(document.cj.nbr50.value);

var total01=Number(ch01*0.1);
var total02=Number(ch02*0.2);
var total05=Number(ch05*0.5);
var total1=Number(ch1*1);
var total2=Number(ch2*2);
var total5=Number(ch5*5);
var total10=Number(ch10*10);
var total20=Number(ch20*20);
var total50=Number(ch50*50);
var total=Number(total01+total02+total05+total1+total5+total10+total20+total2+total50);


document.cj.p1.value=total01.toFixed(2) +"";
document.cj.p2.value=total02.toFixed(2) +"";
document.cj.p3.value=total05.toFixed(2) +"";
document.cj.p4.value=total1.toFixed(2) +"";
document.cj.p5.value=total2.toFixed(2) +"";
document.cj.p6.value=total5.toFixed(2) +"";
document.cj.p7.value=total10.toFixed(2) +"";
document.cj.p8.value=total20.toFixed(2) +"";
document.cj.p9.value=total50.toFixed(2) +"";
document.cj.p10.value=total.toFixed(2) +"";
}

</script>


<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
			<h3>Formulaire d'enregistrement de caisse journalière</h3>
		</td>
	</tr>
	<tr>
		<td>
			<h3><a href="lister_caisse_billetterie.php"><img src="image/retour.png" alt= "Retour à la caisse billetterie">Caisse "billetterie"</a></h3>
			<h3><a href="lister_caisse_bar.php">Caisse "buvette"</a></h3>
		</td>
	</tr>
	<tr>
		<td>
			<table style="width:600" align="center">				
					<caption>Enregistrements N° <?php echo $id_enregistrement_caisse; ?> pour un total de <?php echo "$total $devise"; ?></caption>
					<tr>
						<th>N° ligne</th>
						<th>Type d'espèce</th>
						<th>Nbr</th>
						<th>Total</th>
						<th>Action</th>
					</tr>
						<?php
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
					<td class="highlight" ><?php echo "$id_caisse"; ?></td>
					<td class="highlight"><?php echo "$espece"; ?><?php echo "$devise";?></td>
					<td class="highlight"><?php echo "$nbr";?></td>
					<td class="highlight"><?php echo "$total"; ?><?php echo "$devise";?></td>
					<td class="highlight"><a href="delete_caisse.php?id_caisse=<?php echo $id_caisse; ?>&amp;total=<?php echo $total;?>" onClick="return confirmDelete('<?php echo"$lang_con_effa $num_bon"; ?>')"><img border="0" src="image/delete.png" alt="delete" Title="Supprimer cette ligne" ></a></td>
				</tr><?php
							}
							?>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table style="width:600" align="center">
				<form id="caissejournaliere" name="cj" method="post" action="caisse_new.php" >
					<caption>Ajouter une entrée ou sortie à l'enregistrement</caption>
					<tr>
						<td>&nbsp;</td>
						<th>Type d'espèce</th>
						<th>Nbr</th>
						<th>Total</th>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="texte1">0.1 <?php echo $devise; ?></td>
						<?php $i=0; $i++;?><input name="esp[]" type="hidden"  value="0.1"/>
						<td class="texte1"><input name="nbr[]" type="text" id="nbr01" size="3" value="0" onChange="addition()"/></td>
						<td class="texte1"><input name="p[]" type="text" id="p1" size="3"  readonly/> <?php echo $devise; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="texte0">0.2 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="0.2"/>
						<td class="texte0"><input name="nbr[]" type="text" id="nbr02" size="3" value="0" onChange="addition()"/> </td>
						<td class="texte0"><input name="p[]" type="text" id="p2" size="3"  readonly/> <?php echo $devise; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="texte1">0.5<?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="0.5"/>
						<td class="texte1"><input name="nbr[]" type="text" id="nbr05" size="3" value="0" onChange="addition()"/></td>
						<td class="texte1"><input name="p[]" type="text" id="p3" size="3"  readonly/> <?php echo $devise; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="texte0">1 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="1"/>
						<td class="texte0"><input name="nbr[]" type="text" id="nbr1" size="3" value="0" onChange="addition()"/></td>
						<td class="texte0"><input name="p[]" type="text" id="p4" size="3"  readonly/> <?php echo $devise; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="texte1">2 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="2"/>
						<td class="texte1"><input name="nbr[]" type="text" id="nbr2" size="3" value="0" onChange="addition()"/></td>
						<td class="texte1"><input name="p[]" type="text" id="p5" size="3"  readonly/> <?php echo $devise; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="texte0">5 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="5"/>
						<td class="texte0"><input name="nbr[]" type="text" id="nbr5" size="3" value="0" onChange="addition()"/></td>
						<td class="texte0"><input name="p[]" type="text" id="p6" size="3" readonly/> <?php echo $devise; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="texte1">10 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="10"/>
						<td class="texte1"><input name="nbr[]" type="text" id="nbr10" size="3" value="0" onChange="addition()"/></td>
						<td class="texte1"><input name="p[]" type="text" id="p7" size="3"  readonly/> <?php echo $devise; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="texte0">20 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="20"/>
						<td class="texte0"><input name="nbr[]" type="text" id="nbr20" size="3" value="0" onChange="addition()"/></td>
						<td class="texte0"><input name="p[]" type="text" id="p8" size="3"  readonly/> <?php echo $devise; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="texte1">50 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="50"/>
						<td class="texte1"><input name="nbr[]" type="text" id="nbr50" size="3" value="0" onChange="addition()"/></td>
						<td class="texte1"><input name="p[]" type="text" id="p9" size="3"  readonly/> <?php echo $devise; ?></td>
					</tr>
					<tr>
						<td colspan="5" class="texte0"><h1>Total des encaissements ou du retraits à ajouter à l'enregistrement</h1></td>
						<td class="texte0">
							<input name="p10" type="text" STYLE='color=#FFFF00' id="p10" size="5" readonly/><?php echo $devise; ?></td>
					</tr>
					<tr>
						<td colspan="6">&nbsp;</td>
					</tr>
					<tr>
						<td class="texte1" colspan="2"><h2>Commentaires</h2></td>
						<td class="texte1" colspan="4"><TEXTAREA rows="3" id="commentaire" name="commentaire" /><?php echo $commentaire; ?></TEXTAREA></td>
					</tr>
					<tr>
						<td>
									<?php
									if($pointage!='ok'){ 
										if ($user_dev != 'n'){ 
									?>
							<input type="radio" name="pointage" value="ok">Pointé
							<input type="radio" name="pointage" value="non" checked="checked">Non pointé
									<?php 
										} 
										else {
									?>
							<input type="hidden" name="pointage" value="non">
									<?php
										}
									}
								else { ?>
							<input type="hidden" name="pointage" value="ok">
									<?php 
								}
									?>
						</td>
					</tr>
					</tr>
						<td class="submit" colspan="6"> 
							<input name="id_enregistrement_caisse" type="hidden"  value="<?php echo $id_enregistrement_caisse; ?>"/>
							<input name="total_enregistrement_caisse" type="hidden"  value="<?php echo $total; ?>"/>
							<input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0"> 
						</td>
					</tr>
				</form>
			</table>
		</td>
	</tr>
</table>

<?php
include_once("include/bas.php");
?>

  
