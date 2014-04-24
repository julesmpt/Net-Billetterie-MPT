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
$retrait=isset($_GET['retrait'])?$_GET['retrait']:"";

?>

<script type="text/javascript">
function verif_formulaire(){
	if(document.cj.libelle.value == "")  {
		alert("Veuillez choisir un des libellés!");
		document.cj.libelle.focus();
		return false;
	}
}

function addition(){
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


	document.cj.p1.value="<?php if($retrait=="y"){echo '-';} ?>"+total01.toFixed(2) +"";
	document.cj.p2.value="<?php if($retrait=="y"){echo '-';} ?>"+total02.toFixed(2) +"";
	document.cj.p3.value="<?php if($retrait=="y"){echo '-';} ?>"+total05.toFixed(2) +"";
	document.cj.p4.value="<?php if($retrait=="y"){echo '-';} ?>"+total1.toFixed(2) +"";
	document.cj.p5.value="<?php if($retrait=="y"){echo '-';} ?>"+total2.toFixed(2) +"";
	document.cj.p6.value="<?php if($retrait=="y"){echo '-';} ?>"+total5.toFixed(2) +"";
	document.cj.p7.value="<?php if($retrait=="y"){echo '-';} ?>"+total10.toFixed(2) +"";
	document.cj.p8.value="<?php if($retrait=="y"){echo '-';} ?>"+total20.toFixed(2) +"";
	document.cj.p9.value="<?php if($retrait=="y"){echo '-';} ?>"+total50.toFixed(2) +"";
	document.cj.p10.value="<?php if($retrait=="y"){echo '-';} ?>"+total.toFixed(2) +"";
}
</script>

<table border="0" class="page" align="center">
	<tr>
		</tr>
			<td colspan="2">
				<?php 
					if($retrait=="y"){
						echo"<h3>Effectuer un <i>RETRAIT</i> de caisse</h3>";
					}
					else{
						echo"<h1>Enregistrer le contenu de la caisse journalière</h1>";
					}?>
				</td>
			</tr>
	<tr>
		<td>
			<table  align="center" width="70%">
				<form id="caissejournaliere" name="cj" method="post" action="caisse_new.php" onSubmit="return verif_formulaire()" >
					
					<tr>
						<th width="33%">Type d'espèce</th>
						<th width="33%">Nbr<?php if($retrait=="y"){echo ' retirées';} ?></th>
						<th width="34%">Total</th>
					</tr>
					<tr>
						<td class="texte1">0.1 <?php echo $devise; ?></td>
						<?php $i=0; $i++;?><input name="esp[]" type="hidden"  value="0.1"/>
						<td class="texte1"> <input name="nbr[]" type="text" id="nbr01" size="3" value='0' onChange="addition()"/></td>
						<td class="texte1"><input name="p[]" type="text" id="p1" size="1"  readonly><?php echo $devise; ?></td>
					</tr>
					<tr>
						<td class="texte0">0.2 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="0.2"/>
						<td class="texte0"><input name="nbr[]" type="text" id="nbr02" size="3" value="0" onChange="addition()"/> </td>
						<td class="texte0"><input name="p[]" type="text" id="p2" size="1"  readonly><?php echo $devise; ?></td>
					</tr>
					<tr>
						<td class="texte1">0.5<?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="0.5"/>
						<td class="texte1"><input name="nbr[]" type="text" id="nbr05" size="3" value="0" onChange="addition()"/></td>
						<td class="texte1"><input name="p[]" type="text" id="p3" size="1"  readonly><?php echo $devise; ?></td>
					</tr>
					<tr>
						<td class="texte0">1 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="1"/>
						<td class="texte0"><input name="nbr[]" type="text" id="nbr1" size="3" value="0" onChange="addition()"/></td>
						<td class="texte0"><input name="p[]" type="text" id="p4" size="1"  readonly><?php echo $devise; ?></td>
					</tr>
					<tr>
						<td class="texte1">2 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="2"/>
						<td class="texte1"><input name="nbr[]" type="text" id="nbr2" size="3" value="0" onChange="addition()"/></td>
						<td class="texte1"><input name="p[]" type="text" id="p5" size="1"  readonly><?php echo $devise; ?></td>
					</tr>
					<tr>
						<td class="texte0">5 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="5"/>
						<td class="texte0"><input name="nbr[]" type="text" id="nbr5" size="3" value="0" onChange="addition()"/></td>
						<td class="texte0"><input name="p[]" type="text" id="p6" size="1" readonly><?php echo $devise; ?></td>
					</tr>
					<tr>
						<td class="texte1">10 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="10"/>
						<td class="texte1"><input name="nbr[]" type="text" id="nbr10" size="3" value="0" onChange="addition()"/></td>
						<td class="texte1"><input name="p[]" type="text" id="p7" size="1"  readonly><?php echo $devise; ?></td>
					</tr>
					<tr>
						<td class="texte0">20 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="20"/>
						<td class="texte0"><input name="nbr[]" type="text" id="nbr20" size="3" value="0" onChange="addition()"/></td>
						<td class="texte0"><input name="p[]" type="text" id="p8" size="1"  readonly><?php echo $devise; ?></td>
					</tr>
					<tr>
						<td class="texte1">50 <?php echo $devise; ?></td>
						<?php $i++;?><input name="esp[]" type="hidden"  value="50"/>
						<td class="texte1"><input name="nbr[]" type="text" id="nbr50" size="3" value="0" onChange="addition()"/></td>
						<td class="texte1"><input name="p[]" type="text" id="p9" size="1"  readonly><?php echo $devise; ?></td>
					</tr>
					<tr>
						<td class="texte0" colspan="2"><h1><?php if($retrait=="y"){echo "TOTAL du retrait à la caisse";} else{echo"TOTAL de la caisse";}?></h1></td>
						<td class="texte0">
							<input name="p10" type="text" id="p10" size="5" readonly><?php echo $devise; ?></td>
					</tr>
			</table>
		</td>
		<td>
			<table  align="center" width="50%">
					<tr>
						<td colspan="6">&nbsp;</td>
					</tr>
						<tr>
						<td class="texte1" ><h2>Libellé</h2></td>
						<td class="texte1" >
							<SELECT NAME='libelle'>
										<OPTION VALUE="">Choisissez </OPTION>
										<OPTION VALUE="billetterie">Caisse journalière "billetterie"</OPTION>
										<OPTION VALUE="bar">Caisse journalière "buvette"</OPTION>
						</td>
					</tr>
					<tr>
						<td class="texte1" ><h2>Commentaire</h2></td>
						<td class="texte1" ><TEXTAREA rows="3" id="commentaire" name="commentaire"  value="" /></TEXTAREA></td>
					</tr>
					</tr>
						<td class="submit" colspan="2"> 
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

  
