<script type="text/javascript">
		window.print() ;
	</script>
<style type="text/css">
	body{font-size:0.8em;}

div#ticket{
	text-align:left;
	width:280pt;
	height:135pt;
	border: 2px solid #cccccc;
}
 saut{
page-break-before : always;
}

div#gauche{
	font-size:0.8em;
	float:left;
	text-align:center;
	margin-top:10pt;
	width:80pt;
	height:96pt;
}
div#droite{
	background-image:url(image/saison [320x200].png);
	border-left: 1px solid #000000;
	float:right;
	margin:5 10 0 0;
	text-align:right;
	width:190pt;
	height:130pt;
}
div#h3{
	text-align:center;
}
div#p{
	text-align:center;
	font-size:1.1em;
}
div#span{
	font-size:0.7em;
	}
img#pivot {
-webkit-transform:rotate(270deg); /*Safari 3.1+/Chrome*/
-o-transform:rotate(270deg);  /*Opera 10.5+*/
-moz-transform: rotate(270deg); /*Firefox 3.5+*/
width: 70px;
float:right
  }

</style>
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

$aujourdhui=date ('j-m-Y');

$num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
$num_cont=isset($_GET['num_cont'])?$_GET['num_cont']:"";


    //on recupere l''user
$sql = "SELECT * FROM ".$tblpref."bon_comm WHERE num_bon = '$num_bon'";
$req = mysql_query($sql) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
$user = $data['user'];

//on recupére les info du bon de commande
	$sql = "SELECT nom, paiement FROM ".$tblpref."bon_comm 
		RIGHT JOIN ".$tblpref."client on ".$tblpref."bon_comm.client_num = ".$tblpref."client.num_client
		WHERE num_bon = $num_bon";
	$req = mysql_query($sql) or die('Erreur SQL form_edit_bon !<br>'.$sql.'<br>'.mysql_error());
	$data = mysql_fetch_array($req);
		$paiement = $data["paiement"];
		$nom = htmlentities($data['nom'], ENT_QUOTES);
		?>
<html>
	<body onUnLoad="window.open('test.php?num_cont=<?php echo"$num_cont";?>')">
	<?php
//on recupére les enregistrements du bon de commande
	$sql = "SELECT ".$tblpref."cont_bon.num, ".$tblpref."cont_bon.id_tarif, print, quanti, uni, article, tot_art_htva, to_tva_art, actif, DATE_FORMAT(date_spectacle,'%d-%m-%Y') AS date, stock, ".$tblpref."tarif.nom_tarif
			FROM ".$tblpref."cont_bon 
		RIGHT JOIN ".$tblpref."article on ".$tblpref."cont_bon.article_num = ".$tblpref."article.num
		RIGHT JOIN ".$tblpref."tarif on ".$tblpref."cont_bon.id_tarif = ".$tblpref."tarif.id_tarif
		WHERE  ".$tblpref."cont_bon.num = $num_cont";
	$req5 = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		while($data = mysql_fetch_array($req5))
	{
			$quanti = $data['quanti'];
			$print = $data['print'];
			$uni = $data['uni'];
			$stock = $data['stock'];
			$article = $data['article'];
			$date = $data['date'];
			$tot = $data['to_tva_art'];
			$tva = $data['tva'];
			$id_tarif = $data['id_tarif'];
			$nom_tarif = $data['nom_tarif'];
			$num_cont = $data['num'];
			$actif = $data['actif'];
			$total_bon += $tot;
			$total_tva += $tva;

//on recupère infos du carnet au depart de la saison et la quantité vendu depuis jusqu'à ce bon en filtrant par tarif
	$sql10 = "
			SELECT CB.id_tarif, SUM( to_tva_art ) AS total, T.nom_tarif, T.prix_tarif, SUM(quanti) AS quanti, T.carnet
			FROM ". $tblpref."cont_bon CB, ". $tblpref."bon_comm BC, ". $tblpref."tarif T, ". $tblpref."article ART
			WHERE CB.bon_num = BC.num_bon
			AND BC.attente=0
			AND CB.id_tarif=T.id_tarif
			AND ART.num=CB.article_num
			AND	BC.num_bon <=$num_bon
			AND CB.id_tarif=$id_tarif";
			$req10 = mysql_query($sql10) or die('Erreur SQL10 !<br>'.$sql10.'<br>'.mysql_error());?>

		<?php	while($data = mysql_fetch_array($req10))
		{    
			$carnet = $data['carnet'];
			$quanti01 = $data['quanti'];
			$id_tarif = $data['id_tarif'];
//Pour chaque enregistrement le N° du premier billet vendu
							 if ($t!=$id_tarif){
								 $q='';
								 }
							 if ($q==''){$q=$quanti;}
							 else {$q=$q+$quanti;}
							$du=$carnet+$quanti01-intval($q); 
							 //Pour chaque enregistrement le N° du dernier billet vendu
							 $au=$carnet+$quanti01-1;
//							 echo "carnet=$carnet- quanti01 =$quanti01-quanti_q=$q- quanti_boucle$quanti-au=$au<br>";


//							echo " Billet(s) vendu. ";
							$billet=$du;
							for($i=0; $i<$quanti; $i++){ 
								 ?>

								 <div id="ticket">
									<div id="gauche">
									 <?php
									 echo "N° ".sprintf('%1$04d',$billet)." Tarif $nom_tarif<br>$article<br>Le $date<br><br><span>edité le $aujourdhui <br> par $user</span> ";
									 ?> 
									 <br>
									 <br>
									 <!--generateur de code aen13 via le fichier /include/ean13.php-->
									 <img id="pivot" src="include/EAN13.php?numero=3149025043092&dimension=1">
									 </div>
									 <div id="droite">
									 <?php
									 echo "$nom N° ".sprintf('%1$04d',$billet)." Tarif $nom_tarif<h3>$article</h3><p>Le $date</p><span>edité par $user le $aujourdhui</span>";
									 ?> 
									 <img src="include/EAN13.php?numero=3149025043092&dimension=0.8">
									 </div>
								 </div>
								 <?php
								 $billet++;
							}
						 echo "<br/>";
							 $t=$id_tarif;
							 $quanti01 = $du-1;
		} 
	}
// on enregistre le fait que le bon de commande soit imprimé
//$sql5 = "UPDATE ".$tblpref."cont_bon SET `print`='ok'  WHERE `num` = $num_cont";
//mysql_query($sql3) OR die("<p>Erreur Mysql5<br/>$sql5<br/>".mysql_error()."</p>");
?>

<!--on ferme la fenetre apres avoir lancé l'impression-->
<script language='javascript'>
	window.close()
</script>
</body></html>



