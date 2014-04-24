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
include_once("include/finhead.php");

if($num_bon==''){
$num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
$nom=isset($_GET['nom'])?$_GET['nom']:"";
$id_tarif=isset($_GET['id_tarif'])?$_GET['id_tarif']:"";
}
else{
$num_bon=isset($_POST['num_bon'])?$_POST['num_bon']:"";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
}


$sql = "SELECT  coment, client_num, nom, paiement, attente, user 
		FROM " . $tblpref ."bon_comm
		RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bon_comm.client_num = " . $tblpref ."client.num_client
		WHERE num_bon = $num_bon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
$paiement = $data["paiement"];
$attente = $data["attente"];
$user = $data['user'];
$num_client = htmlentities($data['client_num'], ENT_QUOTES);
$coment = htmlentities($data['coment'], ENT_QUOTES);
$nom = htmlentities($data['nom'], ENT_QUOTES);


$sql = "SELECT " . $tblpref ."cont_bon.num, quanti, uni, article, tot_art_htva, to_tva_art, actif, DATE_FORMAT(date_spectacle,'%d-%m-%Y') AS date
        FROM " . $tblpref ."cont_bon
		RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_bon.article_num = " . $tblpref ."article.num
		WHERE  bon_num = $num_bon";
$req5 = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

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

$rqSql1 = "SELECT uni, num, article, DATE_FORMAT( date_spectacle, '%d/%m/%Y' ) AS date, prix_htva, stock, stomin, stomax
            FROM " . $tblpref ."article
            WHERE stock < '1'
            AND date_spectacle
            BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
            ORDER BY date_spectacle";
$result = mysql_query( $rqSql1 )
             or die( "Exécution requètes impossible.");

$rqSql = "SELECT num_client, nom 
			FROM " . $tblpref ."client 
			WHERE actif != 'non'";
if ($user_com == r) {
$rqSql = "SELECT num_client, nom 
			FROM " . $tblpref ."client 
			WHERE actif != 'non'
			 and (" . $tblpref ."client.permi LIKE '$user_num,'
			 or  " . $tblpref ."client.permi LIKE '%,$user_num,'
			 or  " . $tblpref ."client.permi LIKE '%,$user_num,%'
			 or  " . $tblpref ."client.permi LIKE '$user_num,%')
			";
}


$result2 = mysql_query( $rqSql )
             or die('Erreur SQL !<br>'.$rqSql2.'<br>'.mysql_error());
$rqSql33= "SELECT id_tarif, nom_tarif, prix_tarif 
			FROM ".$tblpref."tarif 
			WHERE id_tarif=$id_tarif";
				 $result33 = mysql_query( $rqSql33 )
             or die( "Exécution requétess impossible.");
						while ( $row = mysql_fetch_array( $result33)) {
    							$id_tarif = $row["id_tarif"];
    							$nom_tarif = $row["nom_tarif"];
							$prix_tarif = $row["prix_tarif"];}

?>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<?php

?>
</td>
</tr>
<tr>

<td  class="page" align="center">
<?php
//les infos du bon
$sql_nom = "SELECT  nom FROM " . $tblpref ."client WHERE num_client = $num_client";
$req = mysql_query($sql_nom) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$nom = $data['nom'];
		$phrase = "$lang_bon_cree";
                $date = date("d-m-Y");
                ?>
		<h1><?php echo "$phrase: $nom - $nom2 $lang_bon_cree2 $date <br>par: $user<br><br>";?></h1><br><?php } ?>
		<h3><a href="lister_commandes_attente.php"><img src="image/retour.png" alt= "Retour à la liste d'attente">Revenir à la liste d'attente</a></h3>
<h3>Attention le bon d'attente ne doit comporter qu'un seul spectacle</h3>
<table class="boiteaction">
 <tr>
  <th><? echo $lang_quantite ;?></th>
  <th><? echo $lang_article ;?></th>
  <th>Montant total</th>
  <th><? echo $lang_supprimer ;?></th>
 </tr>
      <?php
//trouver le contenu du bon
$total = 0.0;
$total_bon = 0.0;
$total_tva = 0.0;

while($data = mysql_fetch_array($req5))

{
	$quanti = $data['quanti'];
	$uni = $data['uni'];
	$article = $data['article'];
	$date = $data['date'];
        $actif = $data['actif'];
	$tot = $data['to_tva_art'];
	$tva = $data['tva'];
	$num_cont = $data['num'];
	$num_lot = $data['num_lot'];
	$total_bon += $tot;
	$total_tva += $tva;
	
  ?>
  <tr>
        <td class='<?php echo couleur_alternee (TRUE,"nombre"); ?>'><?php echo $quanti; ?></td>
        <td class='<?php echo couleur_alternee (FALSE); ?>'><?php echo  "$article || $date|| $actif"; ?> </td>
        <td  class='<?php echo couleur_alternee (FALSE,"nombre"); ?>'><?php echo montant_financier ($tot); ?></td>
        <td class='<?php echo couleur_alternee (FALSE); ?>'>
             <?php echo "<a href=delete_cont_bon_attente.php?num_cont=$num_cont&amp;num_bon=$num_bon&amp;id_tarif=$id_tarif onClick='return confirm('Etes-vous sur de vouloir supprimer ce spectacle?')'><img border=0 src= image/delete.jpg ></a>" ?>
        </td>
  </tr>
   <?php

$total += $tot;
}
?>


    <tr>
        <td class='totalmontant' colspan="3"><?php echo $lang_total; ?></td>
        <td  class='totalmontant'><?php echo montant_financier ($total); ?>
        </td>
        <td class='totaltexte'>&nbsp;
        </td>
        <td colspan='2' class='totaltexte'>&nbsp;</td>
    </tr>
<?php
//on calcule la somme des contenus du bon
$sql = " SELECT SUM(tot_art_htva) FROM ".$tblpref."cont_bon WHERE bon_num = $num_bon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

//on change le total sur le bon de commande
$sql7 = "UPDATE ".$tblpref."bon_comm SET tot_tva = $total WHERE num_bon = $num_bon";
  mysql_query($sql7) OR die("<p>Erreur Mysql7<br/>$sql7<br/>".mysql_error()."</p>");
?>

</table>
<br>
<table>
<form name="formu2" method="post" action="edit_bon_suite_attente.php">

    <h1><?php echo "$lang_bon_ajouter $lang_numero $num_bon"; ?></h1>
	<tr>
            <td class="texte0"><?php echo $lang_quantite; ?><class="texte0" colspan="8"><input type="text" name="quanti" value="1" SIZE="1"></td>
	</tr>

	<tr>
            <td class="texte0"><h5>Choisir le spectacle pour la liste d'attente</h5>
			<?php
			include_once("include/configav.php"); 
                        ?>
			<class="texte0" colspan="6"> 
		 <SELECT NAME='article'>
			<OPTION VALUE=0>Choisir le spectacle</OPTION>
				<?php
				while ( $row = mysql_fetch_array( $result)) 
				{
					$num = $row["num"];
					$article = $row["article"];
					$prix = $row["prix_htva"];
					$uni = $row["uni"];
					$date = $row["date"];$stock = $row['stock'];
					$min = $row['stomin'];
					$max = $row['stomax'];
					$image = $row['image_article'];
					if ($stock<=0 ) 
					{
                                            $stock="Liste d'attente est de $stock places";
                                            $style= 'style="color:red; background:#cccccc;"';
                                            $option="".$article." ---". $date." ---".$stock."";
					}

							?>
			<OPTION <?php echo"$style"; ?> VALUE='<?php echo $num; ?>'><?php echo" $option"; ?></OPTION>
				<?php
				}
				?>
		</SELECT>
            </td>
        </tr>

        <tr><td>&nbsp;</td>
        </tr>
        <tr>

            <td class="texte0">Choisir le<?php echo "$lang_tarif";?>

		   <?php $rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date FROM " . $tblpref ."tarif
                            WHERE saison BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
                            AND selection='1'
                            ORDER BY nom_tarif ASC" ;
				 $result3 = mysql_query( $rqSql3 )
				or die( "Exécution requètes impossible.");?>

		   <SELECT NAME='id_tarif'>
				<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
				<?php
                                $id_tarif1=$id_tarif;
					while ( $row = mysql_fetch_array( $result3)) 
					{
                                            $id_tarif = $row["id_tarif"];
                                            $nom_tarif = $row["nom_tarif"];
                                            $prix_tarif = $row["prix_tarif"];
							?>
				<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
					<?php
					}
					?>
                    </SELECT>
            </td>
	</tr>
	<tr>


		<td class="submit" colspan="9"> <input type="submit" name="Submit2"   value='<?php echo $lang_bon_ajouter; ?>'>
		  <input name="nom" type="hidden"  value='<?php echo $nom; ?>'>
		  <input name="num_bon" type="hidden"  value='<?php echo $num_bon; ?>'>


		</td>
        </tr>

</form>
</table>
<br>
<?php if ($user_dev != 'n')
	{ ?>
            <form action="form_editer_bon.php" method="post" name="fin_bon_attente">
                    <table class="boiteaction">
                            <caption>
                              Transformer le bon d'attente en bon de commande
                             </caption>
                              <tr>
                                    <td class="libelle">
                                            <input type="hidden" name="num_bon" value='<?php echo $num_bon; ?>'>
                                            <input type="hidden" name="id_tarif" value=<?php echo $id_tarif1 ?>>
                                            <input type="hidden" name="attente" value=<?php echo $attente ?>>
                                            <input type="submit" name="Submit" value="Sortir de la liste d'attente" >
                                    </td>
                              </tr>
                    </table>
            </form>
<?php } ?>
<br>
            <form action="bon_fin_attente.php" method="post" name="fin_bon_attente">
                    <table class="boiteaction">
                            <caption>
                              <?php echo "$lang_bon_enregistrer $lang_numero $num_bon"; ?>
                             </caption>
                              <tr>
                                    <td class="submit" colspan="7"><?php echo $lang_ajo_com_bo ?><br>
                                            <textarea name="coment" cols="45" rows="3"><?php echo $coment; ?></textarea><br>

                                            <?php
                                            include_once("include/paiemment.php");
                                            ?>
                                            <input type="hidden" name="tot_tva" value='<?php echo $total; ?>'>
                                            <input type="hidden" name="bon_num" value='<?php echo $num_bon; ?>'>
                                            <input type="hidden" name="id_tarif" value=<?php echo $id_tarif ?>>
                                            <input type="hidden" name="client" value=<?php echo $num_client ?>>
                                            <input type="submit" name="Submit" value="<?php echo "$lang_ter_enr"; ?>" >
                                    </td>
                              </tr>
                    </table>
            </form>
        </td>
    </tr>
</table>

