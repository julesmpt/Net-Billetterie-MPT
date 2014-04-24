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
include_once("include/fonction.php");
include_once("include/finhead.php");
include_once("include/head.php");
$date_today= date("Y-m-d");

?> 
<table class="page" align="center">
    <tr>
        <td class="page" align="center">
             <h3>Liste détaillée des commandes de billets </h3>
        </td>
    </tr>
    <!-- tr>
        <td>
             <form action="lister_detail_bon.php" method="get">
                <center>
                    <table>
                      <caption>
                      Liste détaillée des commandes en choisissant les dates.
                      </caption>
                      <tr>
                        <td class="texte0">Choisir les dates entre le (aaaa-mm-jj)</td>
                        <td align=left> <input name="date_debut" type="text" size="10" maxlength="40" default=""value="<?php echo $date_today;?>" ></td>
                        <td class="texte0">et le </td>
                        <td align=left> <input name="date_fin" type="text" size="10" maxlength="40" value="<?php echo $date_today;?>"></td>
                        <td class="submit" colspan="2"> <input type="submit" name="Submit" value="Visualiser la liste"></td>
                        <td></td>
                      </tr>
                    </table>
                </center>
              </form>
        </td>
    </tr>
	<tr>
        <td>
            <form action="lister_pointes_ok.php" method="get">
                <center>
                    <table>
                      <caption>
                      Liste détaillée des commandes dites "encaissée" en choisissant les dates
                      </caption>
                      <tr>
                        <td class="texte0">Choisir les dates entre le (aaaa-mm-jj)</td>
                        <td align=left> <input name="date_debut" type="text" size="10" maxlength="40" value="<?php echo $date_today;?>"></td>
                        <td class="texte0">et le </td>
                        <td align=left> <input name="date_fin" type="text" size="10" maxlength="40" value="<?php echo $date_today;?>"></td>
                        <td class="submit" colspan="2"> <input type="submit" name="Submit" value="Visualiser la liste"></td>
                        <td></td>
                      </tr>
                    </table>
                </center>
             </form>
        </td>
    </tr-->
    <tr>
        <td  class="page" align="center">
            <?php

            if ($message!='') {
             echo"<table><tr><td>$message</td></tr></table>";
            }
            if ($user_com == n) {
            echo"<h1>$lang_commande_droit";
            exit;
            }
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
            if ($user_com == y) {
					//on recupère les infos des bons de commandes
				$sql = "SELECT num_bon, fact, nom, 
						DATE_FORMAT(date,'%d-%m-%Y') AS date, tot_tva as ttc, paiement, DATE_FORMAT(date_fact,'%d-%m-%Y') AS date_fact
						FROM ". $tblpref."bon_comm
						RIGHT JOIN ". $tblpref."client on ". $tblpref."bon_comm.client_num = num_client
						WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
						AND attente='0'
						ORDER BY " . $tblpref ."bon_comm.`num_bon` DESC
								 ";
			}
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

?>
	</td>
</tr>
<tr>
	<td>
    <center>
        <table class="boiteaction">
            
                    <caption> Les commandes détaillées de la saison culturelle <?php echo "$annee_2 - $annee_1"; ?></caption> 
                    
               
                <tr>
                    <th><?php echo $lang_numero; ?></th>
                    <th width=60px;><?php echo $lang_client; ?></th>
                    <th><?php echo $lang_date; ?></th>
                    <th><?php echo $lang_total_ttc; ?></th>
                    <th>Réglé?</th>
					<th>Encaissé ? le</th>
					<th>Billets</th>
                    <th>NBR</th>
					<th>Spectacle</th>
					<th>Type tarif</th>
					<th>Prix unitare</th>
                    <th>total</th>
                </tr>
                    <?php
//on boucle sur les bons de commandes
					while($data = mysql_fetch_array($req)){
                      $num_bon = $data['num_bon'];
                      $paiement = $data['paiement'];
                      $paiement=stripslashes($paiement);
                      $date = $data["date"];
                      $date_fact = $data["date_fact"];
                      $nom = $data['nom'];
                      $nom=stripslashes($nom);
					  $fact = $data['fact'];
                      $ttc = $data['ttc'];
                      ?>
                <tr class="texte1" onmouseover="this.className='highlight'" onmouseout="this.className='texte1'">
                    <td class="highlight"><?php echo "$num_bon"; ?></td>
                    <td class="highlight"><?php echo "$nom"; ?></td>
                    <td class="highlight"><?php echo "$date"; ?></td>
                    <td class="highlight"><?php echo montant_financier($ttc); ?></td>
                    <td class="highlight"><?php echo "$paiement"; ?></td>
					<td class="highlight"><?php if ($fact=='non'){ echo "<FONT color='red'>non encaissé</FONT>";} else { echo $fact." le ".$date_fact; }?></td>
					<td colspan="6"></td>
					<?php
						//on recupère les infos de chaque enregistrement
						$sql11 = "SELECT article, quanti, ".$tblpref."tarif.id_tarif, 
									".$tblpref."tarif.prix_tarif, nom_tarif, to_tva_art 
									FROM `".$tblpref."cont_bon`, 
									".$tblpref."article, 
									".$tblpref."tarif 
									WHERE ".$tblpref."tarif.id_tarif=".$tblpref."cont_bon.id_tarif
									AND ".$tblpref."article.num=".$tblpref."cont_bon.article_num
									And ".$tblpref."cont_bon.bon_num=$num_bon
									ORDER BY ".$tblpref."tarif.nom_tarif, ".$tblpref."article.date_spectacle ASC";
						$req11 = mysql_query($sql11) or die('Erreur SQL11 !<br>'.$sql11.'<br>'.mysql_error());
						//on boucles sur les cont_bon en fonction du numero du bon_comm
						while($data = mysql_fetch_array($req11))
						{
						  $article = $data['article'];
							$article=stripslashes($article);
						  $quanti = $data['quanti'];
						  $nom_tarif = $data['nom_tarif'];
							$nom_tarif=stripslashes($nom_tarif);
						  $prix_tarif = $data['prix_tarif'];
						  $to_tva_art = $data['to_tva_art'];
						  $id_tarif = $data['id_tarif'];
							//on recupère infos du carnet au depart de la saison et la quantité vendu depuis jusqu'à ce bon en filtrant par tarif
							$sql10 = "
								SELECT CB.id_tarif, SUM( to_tva_art ) AS total, T.nom_tarif, T.prix_tarif, SUM(quanti) AS quanti, T.carnet
								FROM ". $tblpref."cont_bon CB, ". $tblpref."bon_comm BC, ". $tblpref."tarif T, ". $tblpref."article ART
								WHERE CB.bon_num = BC.num_bon
								AND BC.attente=0
								AND BC.fact='ok'
								AND CB.id_tarif=T.id_tarif
								AND ART.num=CB.article_num
								AND	BC.num_bon <=$num_bon
								AND CB.id_tarif=$id_tarif";
							$req10 = mysql_query($sql10) or die('Erreur SQL10 !<br>'.$sql10.'<br>'.mysql_error());
							while($data = mysql_fetch_array($req10))
							{    
								$carnet = $data['carnet'];
								$quanti01 = $data['quanti'];
								$id_tarif = $data['id_tarif'];
								$nom_tarif = $data['nom_tarif'];
					?>
				</tr>
				<tr class="texte0" onmouseover="this.className='highlight'" onmouseout="this.className='texte0'">
					<td colspan="6" class="highlight"></td>
					<td  WIDTH=20% class="highlight">
						<?php 
						 if ($fact!='ok'){ echo 'pas de billet donné car non encaissé';}
						 else {
								 //Pour chaque enregistrement le N° du premier billet vendu
								 if ($t!=$id_tarif){
									 $q='';
								}
								 if ($q==''){$q=$quanti;
								 }
								 else {$q=$q+$quanti;
								 }
								$du=$carnet+$quanti01-intval($q);
	 
								 //Pour chaque enregistrement le N° du dernier billet vendu
								 $au=$carnet+$quanti01-1;
										//echo "carnet=$carnet- quanti01 =$quanti01-quanti_q=$q- quanti_boucle$quanti-au=$au<br>";
										//echo " Billet(s) vendu. ";
								$billet=$du;
								for($i=0; $i<$quanti; $i++){
								 echo "N°".sprintf('%1$04d',$billet).", ";
								 $billet++;
								}
								 echo "<br/>";
								 $t=$id_tarif;
								 $quanti01 = $du-1;
							} 
						}
						?>
					</td>
                    <td class="highlight">	<?php echo "$quanti";?>				
                    </td>
                    <td class="highlight"><?php echo "$article";?>						
					</td>
                    <td class="highlight"><?php echo "$nom_tarif";?>	
                    </td>
                    <td class="highlight"><?php echo "$prix_tarif";?>	
                    </td>
                     <td class="highlight"><?php echo "$to_tva_art";?>	
					 </td>
					 </tr>
					 <?php 
						}
					$q="0";
					} ?>
         </table>
	</center>
	</td>
</tr>

</table>
<?php
include_once("include/bas.php");
?>
        

