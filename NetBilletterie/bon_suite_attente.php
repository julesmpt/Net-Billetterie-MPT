<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors: José Das Neves pitu69@hotmail.fr*/

require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/configav.php");

$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$article=isset($_POST['article'])?$_POST['article']:"";
$num=isset($_POST['bon_num'])?$_POST['bon_num']:"";
$num_client=isset($_POST['num_client'])?$_POST['num_client']:"";
$attente=isset($_POST['attente'])?$_POST['attente']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
$max ="$num";
$client_num = $num_client;


?>
<SCRIPT language="JavaScript" type="text/javascript">
		function confirmDelete(num)
		{
		var agree=confirm('confirmer l\'effacement'+num);
		if (agree)
		 return true ;
		else
		 return false ;
		}

				function verif_formulaire()
					{
				if(document.formu2.article.value == "0")  {
				alert("Veuillez Choisir un spectacle!");
				document.formu2.article.focus();
				return false;
						}
					}

		</script>
<?php
if($article=='0' || $quanti=='' )
    {
    $message= "<h1>$lang_champ_oubli </h1>";
  /*   include('form_commande.php'); */ // On inclus le formulaire d'identification
    exit;
    }
    ?>
<table width="760" border="0" class="page" align="center">
<tr><td>
<table class='boiteaction'>

<?php
 
//on recupere l'prix_tarif
$rqSql33= "SELECT id_tarif, nom_tarif, prix_tarif FROM " . $tblpref ."tarif WHERE id_tarif=$id_tarif ";
				 $result33 = mysql_query( $rqSql33 )
             or die( "Exécution requête impossible.");
						while ( $row = mysql_fetch_array( $result33)) 
							{
    							$id_tarif = $row["id_tarif"];
    							$nom_tarif = $row["nom_tarif"];
								$prix_tarif = $row["prix_tarif"];
							}
                                 $mont_tva = $prix_tarif * $quanti ;



//inserer les données dans la table du compte des bons.
$sql1 = "INSERT INTO " . $tblpref ."cont_bon(bon_num, article_num, quanti, prix_tarif, id_tarif, to_tva_art)
VALUES ('$max', '$article', '$quanti', '$prix_tarif', '$id_tarif', '$mont_tva')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

//ici on decremnte le stock
$sql12 = "UPDATE `" . $tblpref ."article` SET `stock` = (stock - ".$quanti.") WHERE `num` = '".$article."'";
mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error());

$sql_nom = "SELECT  nom, nom2 FROM " . $tblpref ."client WHERE num_client = $num_client";
$req_nom = mysql_query($sql_nom) or die('Erreur SQL_nom !<br>'.$sql_nom.'<br>'.mysql_error());
while($data = mysql_fetch_array($req_nom))
    {
		$nom = $data['nom'];
		$nom2 = $data['nom2'];
		$phrase = "$lang_bon_cree";
                $date = date("d-m-Y");
                ?><h3>Liste d'attente </h3>
		<h1><?php echo "Liste d'attente pour: $nom - $nom2 $lang_bon_cree2 $date <br>";?></h1><br><?php } ?>
 <caption>Composition du billet d'attente:</caption>
 <tr>
    <th><?php echo $lang_quantite ;?></th>
    <th><?php echo $lang_article ;?></th>
    <th><?php echo $lang_montant_htva ;?></th>
	<?php
	if ($lot =='y') {?>
 		 <th><?php echo "$lang_lot"; ?></th>
	<?php } ?>
   <!--th><? echo $lang_editer ;?></th -->
  <!--th><? echo $lang_supprimer ;?>
  </th-->

 <?php
//on recherche tout les contenus du bon et on les detaille
$sql = "SELECT " . $tblpref ."cont_bon.num, uni, DATE_FORMAT(date_spectacle,'%d-%m-%Y') AS date, quanti, article, to_tva_art
        FROM " . $tblpref ."cont_bon
        RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_bon.article_num = " . $tblpref ."article.num
        WHERE  bon_num = $max ";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

while($data = mysql_fetch_array($req))
    {
		$quanti = $data['quanti'];
		$uni = $data['uni'];
		$article = $data['article'];
        $date = $data['date'];
		$tot = $data['to_tva_art'];
		$num_cont = $data['num'];//$lang_li_tot2
		$num_lot = $data['num_lot'];
		$nombre = $nombre +1;
		if($nombre & 1){
		$line="0";
		}else{
		$line="1";
		}

		?>
	<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
		<td class ='highlight'><?php echo"$quanti";?>
		<td class ='highlight'><?php echo"$article | $date";?>
		<td class ='highlight'><?php echo"$tot $devise"; ?>
		<?php
		if ($lot =='y') { ?>
  	<td class ='highlight'><a href=voir_lot.php?num=<?php echo"$num_lot";?> target='_blank'><?php echo"$num_lot";?></a>
	<?php } ?>
		<!-- td class ='highlight'><a href="edit_cont_bon.php?num_cont=<?php echo"$num_cont";?>"><img border="0" alt="editer" src="image/edit.gif"></a -->
		<!--td class ='highlight'><a href="delete_cont_bon_attente.php?num_cont=<?php echo"$num_cont";?>&amp;num_bon=<?php echo"$max"; ?>&amp;id_tarif=<?php echo"$id_tarif"; ?>" onClick='return confirmDelete( 'de l\'enregistrement N°'<?php echo"$num_cont"; ?>)'><img border="0" src="image/delete.jpg" alt="effacer" ></a>&nbsp;</tr-->
		<?php }
//on calcule la somme des contenus du bon
$sql = " SELECT SUM(to_tva_art) FROM " . $tblpref ."cont_bon WHERE bon_num = $max";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$total_bon = $data['SUM(to_tva_art)'];
				}
//on calcule la some de la tva des contenus du bon
$sql = " SELECT SUM(to_tva_art) FROM " . $tblpref ."cont_bon WHERE bon_num = $max";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$total_tva = $data['SUM(to_tva_art)'];



//    $sql5 = "UPDATE " . $tblpref ."bon_comm SET `tot_tva`='".$total_tva."'  WHERE `num_bon` = $max";
//    mysql_query($sql3) OR die("<p>Erreur Mysql5<br/>$sql5<br/>".mysql_error()."</p>");
?>
<tr><td class='totalmontant' colspan="3">TOTAL DU BON</td>

<td class='totaltexte'><?php echo "$total_tva $devise "; ?></td><td colspan='2' class='totalmontant'><?php

   $sql5 = "UPDATE " . $tblpref ."bon_comm SET tot_tva = $total_tva WHERE num_bon = $max";
  mysql_query($sql5) OR die("<p>Erreur Mysql5<br/>$sql5<br/>".mysql_error()."</p>");
} ?>
</td></tr></table>


    <tr><td>


		<form action="bon_fin_attente.php" id="paiement" method="post" name="paiement">

<center><table class="boiteaction">

  <tr>
  <td class="submit" >
	<?php echo $lang_ajo_com_bo ; ?><tr>
<td class="submit" colspan="2"><textarea name="coment" cols="45" rows="3"></textarea>


<input type="hidden" name="id_tarif" value=<?php echo "$id_tarif"; ?>>
<input type="hidden" name="tot_tva" value=<?php echo "$total_tva"; ?>>
<input type="hidden" name="client" value=<?php echo "$client_num"; ?>>
<input type="hidden" name="bon_num" value=<?php echo "$max"; ?>>
<input type="hidden" name="paiement" value="non">


<tr>
<td colspan="2" class="submit">

  <input type="submit" name="Submit" value="<?php echo "$lang_ter_enr"; ?>" OnClick="return confirm('<?php echo"$lang_regler_fac $max dans la liste d'attente?"; ?>');">
	</center></td>
    </table>
</center>
</form>



<tr><td>
<br><br><br><br>


<?php
include("include/bas.php");
 ?>
 </td></tr></table>
