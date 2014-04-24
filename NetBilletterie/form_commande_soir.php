<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include('include/head.php');
include('include/finhead.php');

//=============================================
//pour que les articles soit classés par saison
$today=date ("Y-m-d");
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
?>


<table border="0" class="page" align="center">
    <tr>
        <td class="page" align="center">

                <h3>Encaissement au soir du spectacle</h3>
        </td>
    </tr>
    <tr>
        <td  class="page" align="center">
            <?php
             if ($message!='') {
             echo"<table><tr><td>$message</td></tr></table>";
            }
            if ($user_fact == n) {
            echo"<h1>$lang_commande_droit";
            exit;
            }            
            $jour = date("d");
            $mois = date("m");
            $annee = date("Y");

            $rqSql = "SELECT num_client, nom, nom2 FROM " . $tblpref ."client WHERE actif != 'non' ";
            if ($user_com == r) {
            $rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'
                     and (" . $tblpref ."client.permi LIKE '$user_num,'
                     or  " . $tblpref ."client.permi LIKE '%,$user_num,'
                     or  " . $tblpref ."client.permi LIKE '%,$user_num,%'
                     or  " . $tblpref ."client.permi LIKE '$user_num,%')
                    ";
            }
             ?> 
        </td>
	</tr>
	<tr> 
		<td>
			<center>
			<table>
				<tr>
					

<!-- Formulaire pour les enregistrements le jour du spectacle-->
					<td>
						<form name="formu" method="post" action="bon_soir.php" >
							<table>
								<caption>Enregistrement de caisse au soir du spectacle</caption>
								<tr><td>
									<SELECT NAME='num'>
											<?php
											$rqSql_article = "SELECT num, article, DATE_FORMAT( date_spectacle, '%d/%m/%Y' ) AS date FROM " . $tblpref ."article
													WHERE  date_spectacle
														BETWEEN '$today' AND '$annee_1-$fin_saison'
													ORDER BY date_spectacle";
											$result_article = mysql_query( $rqSql_article )or die( "Exécution requête impossible_article.");
											while ( $row = mysql_fetch_array( $result_article)) 
												{
													$article= stripslashes($row["article"]);
													$num = $row["num"];
													$date = $row["date"];
											?>
										<OPTION VALUE='<?php echo $num; ?>'><?php echo "$article le $date"; ?></OPTION>
											<?php }?>
									</SELECT>
									</td>
								</tr>
								<tr>
									<td class="submit" colspan="6"> 
									<input type="hidden" name="date" value="<?php echo"$jour/$mois/$annee";?>" >
										<input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0">
									</td>
								</tr>
							</table>
						</form>	
					</td>
				</tr>
			</center>
			</table>
		</td>
	</tr>
		<?php 
			if ($user_admin != 'n'){ ?>
	<tr><td><a href="form_commande_caisse_postdate.php"><img src="image/billetterie.png">Effectuer un enregistrement de caisse postdaté.</a></td></tr>
	<?php } ?>
	<tr>
		<td>
			<?php
			include_once("include/bas.php");
			?>
		</td>
	</tr>
</table>




