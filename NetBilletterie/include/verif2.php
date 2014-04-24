<?php
/*
 * Factux le facturier libre
 * Copyright (C) 2003-2004 Guy Hendrickx
 * 
 * Licensed under the terms of the GNU  General Public License:
 * 		http://www.opensource.org/licenses/gpl-license.php
 * 
 * For further information visit:
 * 		http://factux.sourceforge.net
 * 
 * File Name: fckconfig.js
 * 	Editor configuration settings.
 * 
 * * Version:  1.1.5
 * * * Modified: 23/07/2005
 * 
 * File Authors:
 * 		Guy Hendrickx
 *.
 */
//error_reporting(0);
include_once("../include/config/common.php");
//===============================================
//pour controler si bien logué

class Auth{
    static function isLogged(){
        if (isset($_SESSION['Auth']) && isset($_SESSION['Auth']['login']) && isset($_SESSION['Auth']['pass'])&& isset($_SESSION['Auth']['tblpref'])) {
            extract($_SESSION['Auth']);
            $sql="SELECT num FROM ".$tblpref."user WHERE login='$login' AND pwd='$pass' ";
            $req=mysql_query($sql) or die (mysql_error());
            if( mysql_num_rows($req)>0){
                return true;
            }
            else{
                return false;
            }
        }
        else {
            return false;
        }
    }
}
//===============================================
include_once("../include/config/var.php");
include '../include/lib/Zebra_Session.php';
$session = new Zebra_Session;

if(Auth::isLogged()){
}
else{
	header('location:login.inc.php');
}

 $login=$_SESSION['Auth']['login'];
 $lang=$_SESSION['Auth']['lang'];
 $tblpref=$_SESSION['Auth']['tblpref'];

if($_SESSION['Auth']=='')
{
	echo "Vous n'êtes pas autorisé à accéder à cette zone";
	include('login.inc.php');
	exit;
}

if ($lang=='')
{ 
	$lang ="fr";  
}
$sqlz = "SELECT * FROM ".$tblpref."user WHERE ".$tblpref."user.login = \"$login\"";
$req = mysql_query($sqlz) or die('Erreur SQL !<br/>'.$sqlz.'<br/>'.mysql_error());
while($data = mysql_fetch_array($req))
{
    $user_num    = $data['num'];
    $user_nom    = $data["nom"];
    $user_prenom = $data["prenom"];
    $user_email  = $data['email'];
    $user_fact   = $data['fact'];
    $user_com    = $data['com'];
    $user_dev    = $data['dev'];
    $user_admin  = $data['admin'];
    $user_dep    = $data['dep'];
    $user_stat   = $data['stat'];
    $user_art    = $data['art'];
    $user_cli    = $data['cli'];
    $print_user  = $data['print_user'];
    $user_menu   = $data['menu'];
}
 if ($entrep_nom==""){
    $message="<h1>Il semblerait que vous n'ayez pas encore configuré Net-Billetterie</h1>";
    include("../admin.php");
  }
		?>