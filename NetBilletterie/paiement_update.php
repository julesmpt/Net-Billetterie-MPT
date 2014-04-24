<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");

$paiement=isset($_POST['paiement'])?$_POST['paiement']:"";
$paiement= AddSlashes($paiement);
$banque=isset($_POST['banque'])?$_POST['banque']:"";
$banque= AddSlashes($banque);
$coment=isset($_POST['coment'])?$_POST['coment']:"";
$coment= AddSlashes($coment);
$ctrl=isset($_POST['ctrl'])?$_POST['ctrl']:"";
$date_fact=isset($_POST['date_fact'])?$_POST['date_fact']:"";
$dateScind = explode("-", $date_fact);
$jour = $dateScind[0];
$mois = $dateScind[1];
$annee = $dateScind[2];
$date_fact=$annee."-".$mois."-".$jour; 
$titulaire_cheque=isset($_POST['titulaire_cheque'])?$_POST['titulaire_cheque']:"";
$pointage=isset($_POST['pointage'])?$_POST['pointage']:"";
$num_bon=isset($_POST['num_bon'])?$_POST['num_bon']:"";


$sql22 = "UPDATE `".$tblpref."bon_comm` SET `paiement`='$paiement', `banque`='$banque', `date_fact`='$date_fact', `coment`='$coment', `ctrl`='$ctrl', `titulaire_cheque` = '$titulaire_cheque', `fact`='$pointage'
WHERE `num_bon` ='".$num_bon."' ";
mysql_query($sql22) OR die("<p>Erreur Mysql<br/>$sql22<br/>".mysql_error()."</p>");

if($pointage=="ok"){
$message= "<h1>La réservation <font color=red> N° $num_bon </font>est enregistrée comme encaissée. <br/> Elle ne peux plus être modifiée. C'est pour cette raison qu'elle n'est plus présentée dans la liste ci-dessous</h1>";
}
else{
	$message= "<h1>La réservation <font color=red> N° $num_bon </font> a bien été modifiée</h1>";
	}
require("lister_commandes_non_facturees.php");
 ?> 



