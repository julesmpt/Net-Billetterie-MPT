<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/configav.php");

///=============================================
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
?>

<table border="0" class="page" align="center">
  <tr>
    <td  class="page" align="center">
    <?php

    //on recupère les infos par post ou get
    $client=isset($_POST['listeville'])?$_POST['listeville']:"";
    $date=isset($_POST['date'])?$_POST['date']:"";
    $id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";


    if ($client=="") 
    {
    $client=isset($_GET['listeville'])?$_GET['listeville']:"";
    $date=isset($_GET['date'])?$_GET['date']:"";
    $id_tarif=isset($_GET['id_tarif'])?$_GET['id_tarif']:"";
    }

    list($jour, $mois,$annee) = preg_split('/\//', $date, 3);

    include_once("include/language/$lang.php");
    if($client=='0')
    {
    $message="<h1> $lang_choix_client</h1>";
    exit;
    }

    //on recupère les info du client pour la 1er ligne de la page
    $sql_nom = "SELECT  nom, nom2 FROM " . $tblpref ."client WHERE num_client = $client";
    $req = mysql_query($sql_nom) or die('Erreur SQL_nom !<br>'.$sql.'<br>'.mysql_error());
    while($data = mysql_fetch_array($req))
    {
    $nom = $data['nom'];
    $nom2 = $data['nom2'];
    $phrase = "$lang_bon_cree";
    ?>
    <h1><?php echo "$phrase: $nom - $nom2 $lang_bon_cree2 $date <br>";?></h1><br>
    <?PHP
    }

    // on créer un bon de commmande		
    $sql1 = "INSERT INTO " . $tblpref ."bon_comm(client_num, date, id_tarif, user) VALUES ('$client', '$annee-$mois-$jour', '$id_tarif', '$user_nom')";
    mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
    // on affiche les infos du bon de commande
    $sql_num = "SELECT  num_bon FROM " . $tblpref ."bon_comm WHERE client_num = $client order by num_bon desc limit 1 ";
    $req = mysql_query($sql_num) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data = mysql_fetch_array($req))
    {
    $num_bon = $data['num_bon'];
    ?>
    <h3><?php echo "$lang_commande_numero $num_bon saisi par \"$user_nom\"";?></h3><br>
    <?PHP
    }
    ?>
      <center>
        <form name='formu2' method='post' action='bon_suite.php'>
          <table class="boiteaction">
          <caption>Composer la commande</caption>
          <?php

          // pour ne montrer que les articles dont le stock est "0" ou inf.
          $rqSql11 = "SELECT uni, num, article, DATE_FORMAT( date_spectacle, '%d/%m/%Y' ) AS date, prix_htva, stock, stomin, stomax
          FROM " . $tblpref ."article
          WHERE stock < '1'
          AND date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
          ORDER BY date_spectacle ASC";
          $result11 = mysql_query( $rqSql11 )
          or die( "Exécution requête impossible.");
          ?> </td> </tr>
          <?php

          while ( $row = mysql_fetch_array( $result11)) 
          {		
          $article= stripslashes($row["article"]);
          $date = $row["date"];
          $stock = $row['stock'];
          if ($stock<=0 ) 
          {
          $stock="Ce spectacle est complet";
          $style= 'style="color:red; background:#cccccc; font-weight:bold;"';
          $option1="".$article." ---". $date."-- ".$stock."";
          }

          ?>
          <p <?php echo"$style"; ?>><?php echo"$option1"; ?></p>
          <?php } ?>

          <tr>
          <td class="texte0">Choisir la quantité d'entrée par spectacle </td>
          <td class="texte_left" colspan="3">
          <input type="text" name="quanti" value="1" SIZE="1"></td>

          </tr>
          <tr>
          <td class="texte0">Choisir le  <?php echo "$lang_article"; ?></td>
          <?php
          //pour n 'affichés que les articles  en stock
          $rqSql = "SELECT uni, num, article, DATE_FORMAT( date_spectacle, '%d/%m/%Y' ) AS date, prix_htva, stock, stomin, stomax
                    FROM " . $tblpref ."article
                    WHERE stock > '0'
                    AND date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
                    ORDER BY date_spectacle ASC";
          $result = mysql_query( $rqSql )or die( "Exécution requête impossible.");
          ?>
          <td class="texte_left">
            <?php                                                    
            $i=1;
            while ( $row = mysql_fetch_array( $result)) 
            {
              $num = $row["num"];
              $article= stripslashes($row["article"]);
              $date = $row["date"];
              $stock = $row['stock'];
              $min = $row['stomin'];

                if ($stock<=0 ) 
                {
                 $option="toto";
                }
                elseif ($stock <= $min && $stock >= 1  ) 
                {
                  $stock="Attention plus que $stock places";
                  $style= 'style="color:#961a1a; background:#ece9d8;"';
                  $option="".$article." ---". $date." ---".$stock."";
                }
                else 
                {
                  $stock= "Le stock est de ".$stock." places";
                  $style= 'style="color:black; background-color:##99fe98;"';
                  $option="".$article." ---". $date." ---".$stock."";
                }
            ?>
            <input  type="checkbox" VALUE='<?php echo $num; ?>' name="article[]"  ><b <?php echo$style; ?>><?php echo" $option"; ?><b><br>
            <?php 
              $i++; 
            }
            ?>
          <tr>
            <td class="texte0">Choisir le<?php echo "$lang_tarif";?>
              <?php
                $rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif FROM " . $tblpref ."tarif WHERE id_tarif=$id_tarif ";
                $result3 = mysql_query( $rqSql3 )
                or die( "Exécution requête impossible.");
                while ( $row = mysql_fetch_array( $result3)) 
                {
                  $id_tarif = $row["id_tarif"];
                  $nom_tarif = $row["nom_tarif"];
                  $prix_tarif = $row["prix_tarif"];
              ?>
            </td>
            <td class="texte_left">
              <SELECT NAME='id_tarif'>
              <OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
                <?php 
                }
                ?>
              <?php
              //on recupère les tarif pour la selection du form
                $rqSql4= "SELECT id_tarif, nom_tarif, prix_tarif, saison FROM ".$tblpref."tarif
                WHERE saison BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
                AND id_tarif<>$id_tarif
                AND selection='1'
                ORDER BY nom_tarif ASC";
                $result4 = mysql_query( $rqSql4 )
                or die( "Exécution requête impossible.");
                while ( $row = mysql_fetch_array( $result4)) 
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
            <td class="submit" colspan="4">
              <input type="hidden" name="nom" id="nom" value='<?php echo $nom ?>'>
              <input type="hidden" name="bon_num"  value='<?php echo $num_bon ?>'>
              <input type="hidden" name="num_client" value='<?php echo $client ?>'>
              <input style="color:#961a1a;background:yellow" type="submit" name="Submit" value='Enregistrer le spectacle'>
            </td>
          </tr>
          </table>
        </form>
      </center>
    </td>
  </tr>
</table>
<?php
include_once("include/bas.php");
?>

