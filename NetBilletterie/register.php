<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/config/common.php");
include_once("include/verif.php");
include_once("include/language/$lang.php");

$login2=isset($_POST['login2'])?$_POST['login2']:"";
$pass=isset($_POST['pass'])?$_POST['pass']:"";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$prenom=isset($_POST['prenom'])?$_POST['prenom']:"";
$mail=isset($_POST['mail'])?$_POST['mail']:"";
$pass2=isset($_POST['pass2'])?$_POST['pass2']:"";

$menu=isset($_POST['menu'])?$_POST['menu']:"";

$dev=isset($_POST['dev'])?$_POST['dev']:"";
$com=isset($_POST['com'])?$_POST['com']:"";
$fact=isset($_POST['fact'])?$_POST['fact']:"";
$dep=isset($_POST['dep'])?$_POST['dep']:"";
$stat=isset($_POST['stat'])?$_POST['stat']:"";
$art=isset($_POST['art'])?$_POST['art']:"";
$cli=isset($_POST['cli'])?$_POST['cli']:"";
$print_user=isset($_POST['print_user'])?$_POST['print_user']:"";
$admin=isset($_POST['admin'])?$_POST['admin']:"";

if ($admin == y) { 
$dev = "y";
$com = "y";
$fact = "y";
$dep = "y"; 
$stat = "y";
$art = "y";
$cli = "y";
$print_user="y";
}

if($login2=='' || $pass==''|| $nom=='' || $pass2=='')
{
echo "$lang_oublie_champ";
include('form_utilisateurs.php');
exit;
}
if($pass != $pass2)
    {
    echo "<h1>Erreur les deux mots de passe ne correspondent pas</h1>";
    include('form_utilisateurs.php'); // On inclus le formulaire d'identification
    exit;
    }
else

$sql = "SELECT * FROM " . $tblpref ."user WHERE login = '".$login2."'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$test = mysql_num_rows($req);
if ($test > 0) { 
echo "<h1> Erreur le login existe deja";
    include('form_utilisateurs.php');
    exit;
		}

$pass_crypt = md5($pass);
mysql_select_db($db) or die ("Could not select $db database");
$sql7 = "INSERT INTO " . $tblpref ."user (login, pwd, nom, prenom, email, dev, com, fact, dep, stat, art, cli, admin, print_user, menu) VALUES ('$login2', '$pass_crypt', '$nom', '$prenom', '$mail', '$dev', '$com', '$fact', '$dep', '$stat', '$art', '$cli', '$admin', '$print_user', '$menu')";
mysql_query($sql7) or die('Erreur SQL !<br>'.$sql7.'<br>'.mysql_error());
$message= " <h2>$prenom $nom $lang_est_enr $login2 </h2>";

include("lister_utilisateurs.php");

 ?> 
