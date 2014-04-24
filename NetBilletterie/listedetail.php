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
<script type="text/javascript" src="javascripts/confdel.js"></script>

<table class="page" align="center">

    <tr>
        <td class="page" align="center">
             <h3>Liste détaillée des commandes de billets </h3>
        </td>
    </tr>
    <tr>
        <td>
             <form action="lister_detail_bon.php" method="get">
                <center>
                    <table>
                      <caption>
                      Liste détaillée des commandes en choisissant les dates.
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
    </tr>
	
	<tr>
        <td>
             <form action="lister_pointes_ok.php" method="get">
                <center>
                    <table>
                      <caption>
                      Liste détaillée des commandes pointées "ok" en choisissant les dates
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
    </tr>
    
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


            $mois = date("n");
            $annee = date("Y");

//=============================================
//pour que les articles soit classés par saison
$mois=date("n");
if ($mois=="11"||$mois=="12") {
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
            $sql = "SELECT num_bon, fact, nom, 
					DATE_FORMAT(date,'%d-%m-%Y') AS date, tot_tva as ttc, paiement
					FROM factux_bon_comm
					RIGHT JOIN factux_client on factux_bon_comm.client_num = num_client
					WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
					AND attente='0'
                             ";
                             //ORDER BY " . $tblpref ."bon_comm.`num_bon` DESC

            if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
            {
            $sql .= " ORDER BY " . $_GET[ordre] . " ASC";
            }
            else
            {
            $sql .= "ORDER BY " . $tblpref ."bon_comm.`num_bon` DESC ";
            }}
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

/* pagination */
// Paramétrage de la requête (ne pas modifier le nom des variable)

//=====================================================
// Nombre d'enregistrements par page à afficher
$parpage = 500;
//=====================================================


//==============================================================================
// Déclaration et initialisation des variables (ici ne rien modifier)
//==============================================================================

// On définit le suffixe du lien url qui affichera les pages
// $_SERVEUR['PHP_SELF'] donne l'arborescence de la page courante
$url = $_SERVER['PHP_SELF']."?limit=";

$total = mysql_query($sql); // Résultat total de la requête $sql
$nblignes = mysql_num_rows($total); // Nbre total d'enregistrements
// On calcule le nombre de pages à afficher en arrondissant
// le résultat au nombre supérieur grâce à la fonction ceil()
$nbpages = ceil($nblignes/$parpage); 

 // Si une valeur 'limit' est passée par url, on vérifie la validité de
// cette valeur par mesure de sécurité avec la fonction validlimit()
 // cette fonction retourne automatiquement le résultat de la requête
 $result = validlimit($nblignes,$parpage,$sql); 


 

?>


    <center>
        <table class="boiteaction">
            
                    <caption> Les commandes détaillées de la saison culturelle <?php echo "$annee_2 - $annee_1"; ?></caption> 
                    
               
                <tr>
                    <th><a href="lister_detail_commandes.php?ordre=num_bon"><?php echo $lang_numero; ?></a></th>
                    <th width=60px;><a href="lister_detail_commandes.php?ordre=nom"><?php echo $lang_client; ?></a></th>
                    <th><a href="lister_detail_commandes.php?ordre=date"><?php echo $lang_date; ?></a></th>
                    <th><?php echo $lang_total_ttc; ?></th>
                    <th>Réglé?</th>
					<th>Pointé?</th>
					<th></th>
                    <th>NBR</th>
					<th>Spectacle</th>
					<th>Type tarif</th>
					<th>Prix unitare</th>
                    <th>total</th>
                </tr>
                    <?php
                    $nombre = 1;
					while($data = mysql_fetch_array($result))
		{
                      $num_bon = $data['num_bon'];
                      $paiement = $data['paiement'];
                      $date = $data["date"];
                      $nom = $data['nom'];
                        $nom = htmlentities($nom, ENT_QUOTES);
                        $nom_html = htmlentities (urlencode ($nom));
					  $fact = $data['fact'];
                      $ttc = $data['ttc'];
                      $nombre = $nombre +1;
                            if($nombre & 1){
                            $line="0";
                            }else{
                            $line="1";
                            }
                      ?>
                <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
                    <td class="highlight"><?php echo "$num_bon"; ?></td>
                    <td class="highlight"><?php echo "$nom"; ?></td>
                    <td class="highlight"><?php echo "$date"; ?></td>
                    <td class="highlight"><?php echo montant_financier($ttc); ?></td>
                    <td class="highlight"><?php echo "$paiement"; ?></td>
					<td class="highlight"><?php echo "$fact"; ?></td>
					<td class="highlight">Billets</td>
					<?php 
					$sql11 = "SELECT article, quanti, factux_tarif.id_tarif, factux_tarif.prix_tarif, nom_tarif, to_tva_art FROM `factux_cont_bon`, factux_article, factux_tarif 
								WHERE factux_tarif.id_tarif=factux_cont_bon.id_tarif
								AND factux_article.num=factux_cont_bon.article_num
								And factux_cont_bon.bon_num=$num_bon";
					$req11 = mysql_query($sql11) or die('Erreur SQL11 !<br>'.$sql11.'<br>'.mysql_error());
					while($data = mysql_fetch_array($req11))
            {
                      $article = $data['article'];
					  $quanti = $data['quanti'];
					  $nom_tarif = $data['nom_tarif'];
					  $prix_tarif = $data['prix_tarif'];
					  $to_tva_art = $data['to_tva_art'];
					  $id_tarif = $data['id_tarif'];
					$sql10 = "
					SELECT CB.id_tarif, SUM( to_tva_art ) AS total, T.nom_tarif, T.prix_tarif, SUM(quanti) AS quanti, T.carnet
					FROM factux_cont_bon CB, factux_bon_comm BC, factux_tarif T, factux_article ART
					WHERE CB.bon_num = BC.num_bon
					AND BC.attente=0
					AND CB.id_tarif=T.id_tarif
					AND ART.num=CB.article_num
					AND	BC.num_bon <=$num_bon
					AND CB.id_tarif=$id_tarif";
					$req10 = mysql_query($sql10) or die('Erreur SQL11 !<br>'.$sql10.'<br>'.mysql_error());

					while($data = mysql_fetch_array($req10))
				{    
					$carnet = $data['carnet'];
					$quanti01 = $data['quanti'];
					$id_tarif = $data['id_tarif'];
					$nom_tarif = $data['nom_tarif'];
					?>
				<tr>
					<td></td><td></td><td></td><td></td><td></td><td></td><td>
						<?php 
							$du=$carnet+$quanti01-$quanti;
							$au=$carnet+$quanti01-1;
							echo "billet du $du au $au";
							$quanti+=$quanti;
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
		} ?>
                </table></center></td></tr>
       

        
    

    <tr>
        <td>
             <?php
//=====================================================
// Menu de pagination que l'on place après la requête 
//======================================================
 echo "<div class='pagination'>";
 echo pagination($url,$parpage,$nblignes,$nbpages,$initial);
function position($parpage){
if (isset($_GET['limit'])) {
    $pointer = split('[,]', $_GET['limit']); // On scinde $_GET['limit'] en 2
    $debut = $pointer[0];
    $page = ($debut/$parpage)+1;
return $page;
}
}
 echo "</div>";

 mysql_free_result($result); // Libère le résultat de la mémoire
 ?>
        </td>
    </tr>
    <tr>
        <td>
        <?php
include("help.php");
include_once("include/bas.php");
$url = $_SERVER['PHP_SELF'];
$file = basename ($url); 
?>
        </td>
    </tr>
</table>

<?php 

if ($file=="form_commande.php" or $file=="login.php") { 
echo"</table>"; 
}
 ?> 
<?php 
include_once("include/footers.php");
 ?> 
