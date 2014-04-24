<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/config/var.php");
$mail_admin = "$mail";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$nom=AddSlashes($nom);
$nom_sup=isset($_POST['nom_sup'])?$_POST['nom_sup']:"";
$rue=isset($_POST['rue'])?$_POST['rue']:"";
$rue=AddSlashes($rue);
$ville=isset($_POST['ville'])?$_POST['ville']:"";
$ville=AddSlashes($ville);
$code_post=isset($_POST['code_post'])?$_POST['code_post']:"";
$num_tva=isset($_POST['num_tva'])?$_POST['num_tva']:"";
$login=isset($_POST['login'])?$_POST['login']:"";
$pass=isset($_POST['pass'])?$_POST['pass']:"";
$mail_cli=isset($_POST['mail'])?$_POST['mail']:"";
$pass2=isset($_POST['pass2'])?$_POST['pass2']:"";
$civ=isset($_POST['civ'])?$_POST['civ']:"";
$tel=isset($_POST['tel'])?$_POST['tel']:"";
$fax=isset($_POST['fax'])?$_POST['fax']:"";
$ville= ucwords($ville);
$nom= ucwords($nom);

$sql2 = "SELECT * FROM ".$tblpref."client
WHERE nom= '".$nom."'
AND rue= '".$rue."'
AND ville= '".$ville."'";
$req2 = mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
while($data = mysql_fetch_array($req2))
    {
    $client = $data['num_client'];
    $nom1 = stripslashes($data['nom']);
    $nom2 = $data['nom2'];
    $rue1 = $data['rue'];
    $ville1 = stripslashes($data['ville']);
    $mail1 =$data['mail'];
    $civ1 = $data['civ'];
    $tel1 = $data['tel'];
    
    if ($nom1!=""){
        echo "<h3><font color=red>$civ1 $nom1 demeurant: $rue1 à $ville1<br> Dont le mail est: $mail1 <br>est déjà sur la liste</font></h3><hr> <a href='form_client.php'>Retour au formulaire de saisie </a><br><a href='form_commande.php'>Ou aller directement à la saisie de commande</a> ";
        exit;
    }

}
if($pass != $pass2)
    {
    echo "<h1>$lang_mot_pa</h1>";
    include('form_client.php');
    exit;
    }

$pass = md5($pass);


if($nom=='' || $rue=='' || $ville=='' || $code_post=='')
    {
   $message= "<h1>$lang_oubli_champ</h1>";
    include('form_client.php'); // On inclus le formulaire d'identification
    exit;
    }
if ($login !=''){
$sql = "SELECT * FROM " . $tblpref ."client WHERE login = '".$login."'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$test = mysql_num_rows($req);
if ($test > 0) { 
$message= "<h1> $lang_er_mo_pa</h1>";
    include('form_client.php');
    exit;
		}
}
$sql1 = "INSERT INTO " . $tblpref ."client(nom, nom2, rue, ville, cp, num_tva, login, pass, mail, civ, tel, fax) VALUES ('$nom', '$nom_sup', '$rue', '$ville', '$code_post', '$num_tva', '$login', '$pass', '$mail_cli', '$civ', '$tel', '$fax')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

$sql3 = "SELECT * FROM " . $tblpref ."client
WHERE nom= '".$nom."'
";
$req3= mysql_query($sql3) or die('Erreur SQL3 !<br>'.$sql3.'<br>'.mysql_error());
while($data = mysql_fetch_array($req3))
    {
    $client = $data['num_client'];
	$nom=StripSlashes($data['nom']);

$message= "<center><h2>Le client <font color=red>$civ $nom </font> a bien été enregistré </h2></center>";

include("form_client.php");}
?>
