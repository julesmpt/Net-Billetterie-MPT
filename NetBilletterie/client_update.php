<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/config/var.php");
	$mail_admin = $mail;
	$nom=isset($_POST['nom'])?$_POST['nom']:"";
	$nom_sup=isset($_POST['nom_sup'])?$_POST['nom_sup']:"";
	$rue=isset($_POST['rue'])?$_POST['rue']:"";
	$rue=AddSlashes($rue);
	$ville=isset($_POST['ville'])?$_POST['ville']:"";
	$ville=AddSlashes($ville);
	$code_post=isset($_POST['code_post'])?$_POST['code_post']:"";
	$num_tva=isset($_POST['num_tva'])?$_POST['num_tva']:"";
	$login=isset($_POST['logincli'])?$_POST['logincli']:"";
	$login2=isset($_POST['login2'])?$_POST['login2']:"";
	$pass=isset($_POST['passcli'])?$_POST['passcli']:"";
	$mail_cli=isset($_POST['mail'])?$_POST['mail']:"";
	$pass2=isset($_POST['pass2cli'])?$_POST['pass2cli']:"";
	$num=isset($_POST['num'])?$_POST['num']:"";
	$civ=isset($_POST['civ'])?$_POST['civ']:"";
	$tel=isset($_POST['tel'])?$_POST['tel']:"";
	$fax=isset($_POST['fax'])?$_POST['fax']:"";
	$actif=isset($_POST['actif'])?$_POST['actif']:"";
$message='';
if($pass != $pass2)
    {
    echo "<h1>$lang_mot_pa</h1>";
    include('form_client.php');
    exit;
    }

$pass = md5($pass);


if($nom=='' || $rue=='' || $ville=='' || $code_post=='' || $ville=='')
    {
    echo "<h1>$lang_oubli_champ";
    include('form_client.php'); // On inclus le formulaire d'identification
    exit;
    }

		if ($login !='') { 
  

$sql = "SELECT * FROM " . $tblpref ."client WHERE login = '".$login."'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$test = mysql_num_rows($req);
if ($test > 0) { 
echo "<h1> $lang_er_mo_pa";
    include('form_client.php');
    exit;
		}
}

$sql2 = "UPDATE " . $tblpref ."client SET `fax`='" . $fax . "', `tel`='" . $tel . "', `civ`='" . $civ . "', `nom`='" . $nom . "', `mail`='" . $mail_cli . "', `num_tva`='" . $num_tva . "', `nom2`='" . $nom_sup . "', `rue`='" .$rue . "', `ville`='" . $ville . "', `cp`='" . $code_post . "', `actif`='" . $actif . "' WHERE `num_client` = '" . $num . "'";
mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");

if($pass2 !='' and $login != '')
    {
$sql2 = "UPDATE " . $tblpref ."client SET login='" . $login . "', pass='" . $pass . "' WHERE num_client = '" . $num . "'";
mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
}

if($pass2 !='' and $login2 != '')
    {
$sql2 = "UPDATE " . $tblpref ."client SET login='" . $login2 . "', pass='" . $pass . "' WHERE num_client = '" . $num . "'";
mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
$to = "$mail_cli";
$from = "$mail_admin" ;

$subject = "$lang_pass_modif" ;
$message_mail =  "$lang_mail_li_up1 $login2 Mot de passe: $pass2</b><br>$lang_mail_cli_up<br> "; 
$header = 'From: '.$from."\n"
 .'MIME-Version: 1.0'."\n"
 .'Content-Type: text/html; charset= ISO-8859-1'."\n"
 .'Content-Transfer-Encoding: 7bit'."\n\n";

mail($to,$subject,$message_mail,$header);
$message.= "<center><h2>$lang_notif_env $mail_cli</h2></center> ";

}
if($pass2 !='' and $login != ''and $mail_cli !='')
{
$to = "$mail_cli";
$from = "$mail_admin" ;

$subject2 = "$lang_cre_mo_pa" ;
$message_mail =  "Cher client<br>Votre mot de passe a ete cr�� par l'administrateur<br><b>Login: $login Mot de passe: $pass2</b><br><br>vous pouver changer ce mot de passe en ligne mais pas le login. <br>Ce mot de pass est encod� dans notre base de donn�e .<br>Si vous le perdiez, veuilliez pr�vevir l <a href=$mail_admin>administrateur</a> pour qu'il vous en donne un nouveau ";
$header = 'From: '.$from."\n"
 .'MIME-Version: 1.0'."\n"
 .'Content-Type: text/html; charset= ISO-8859-1'."\n"
 .'Content-Transfer-Encoding: 7bit'."\n\n";

mail($to,$subject2,$message_mail,$header);
$message.= "<center><h2>$lang_noti_pa</h2></center>";

}

$message.= "<center><h2>$lang_cli_jour</h2></center>";

include("form_client.php");
?>
