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
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';
$login2=isset($_POST['login2'])?$_POST['login2']:"";
$pass=isset($_POST['pass'])?$_POST['pass']:"";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$prenom=isset($_POST['prenom'])?$_POST['prenom']:"";
$mail=isset($_POST['mail'])?$_POST['mail']:"";
$pass2=isset($_POST['pass2'])?$_POST['pass2']:"";
$num_user=isset($_POST['num_user'])?$_POST['num_user']:"";

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
$print_user = "y";
}

if($login2=='' || $nom=='' )
{
echo "$lang_oublie_champ";
include('lister_utilisateurs.php');
exit;
}
if($pass != $pass2)
    {
    echo "<h1>Erreur les deux mots de passe ne correspondent pas</h1>";
    include('editer_utilisateur.php'); // On inclus le formulaire d'identification
    exit;
    }
else

if ($pass != '') { 

$pass_crypt = md5($pass);
$sql7 = "UPDATE " . $tblpref ."user 
SET `pwd` = '".$pass_crypt."', 
`login` = '".$login2."',
`nom` = '".$nom."', 
`prenom` = '".$prenom."', 
`email` = '".$mail."', 
`dev` = '".$dev."', 
`com` = '".$com."', 
`fact` = '".$fact."', 
`dep` = '".$dep."', 
`stat` = '".$stat."', 
`art` = '".$art."', 
`cli` = '".$cli."',
`print_user` = '".$print_user."', 
`menu` = '".$menu."', 
`admin` = '".$admin."'
WHERE `num` = '".$num_user."'";
}
if ($pass == '') {

$sql7 = "UPDATE " . $tblpref ."user 
SET `nom` = '".$nom."', 
`prenom` = '".$prenom."', 
`email` = '".$mail."', 
`dev` = '".$dev."', 
`com` = '".$com."', 
`fact` = '".$fact."', 
`dep` = '".$dep."', 
`stat` = '".$stat."', 
`art` = '".$art."', 
`cli` = '".$cli."',
`print_user` = '".$print_user."', 
`menu` = '".$menu."',
`admin` = '".$admin."'
WHERE `num` = '".$num_user."'";
}
mysql_query($sql7) or die('Erreur SQL !<br>'.$sql7.'<br>'.mysql_error());


$message="la fiche utitlisateur à bien été changée<br>";
include("lister_utilisateurs.php");
 
 ?> 
