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
include_once("include/head.php");
include_once("include/finhead.php");

if ($user_admin !='y') { 
echo "<h1>$lang_admin_droit";
exit;
}

$entrep_nom1=isset($_POST['entrep_nom'])?$_POST['entrep_nom']:"";
if ($entrep_nom1!=$entrep_nom){
$sqlentrep_nom="UPDATE  ".$tblpref."admin SET  designation = '$entrep_nom1' WHERE  nom='entrep_nom'";
mysql_query($sqlentrep_nom) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlentrep_nom<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$tel1=isset($_POST['tel'])?$_POST['tel']:"";
if ($tel1!="$tel"){
$sqltel="UPDATE  ".$tblpref."admin SET  designation = '$tel1' WHERE  nom='tel'";
mysql_query($sqltel) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqltel<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$social1=isset($_POST['social'])?$_POST['social']:"";
if ($social1!="$social"){
$sqlsocial="UPDATE  ".$tblpref."admin SET  designation = '$social1' WHERE  nom='social'";
mysql_query($sqlsocial) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlsocial<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$slogan1=isset($_POST['slogan'])?$_POST['slogan']:"";
if ($slogan1!=$slogan){
$sqlslogan="UPDATE  ".$tblpref."admin SET  designation = '$slogan1' WHERE  nom='slogan'";
mysql_query($sqlslogan) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlslogan<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$mail1=isset($_POST['mail'])?$_POST['mail']:"";
if ($mail1!=$mail){
$sqlmail="UPDATE  ".$tblpref."admin SET  designation = '$mail1' WHERE  nom='mail'";
mysql_query($sqlmail) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlmail<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$devise1=isset($_POST['devise'])?$_POST['devise']:"";
if ($devise1!=$devise){
$sqldevise="UPDATE  ".$tblpref."admin SET  designation = '$devise1' WHERE  nom='devise'";
mysql_query($sqldevise) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqldevise<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$logo1=isset($_POST['logo'])?$_POST['logo']:"";
if ($logo1!=$logo){
$sqllogo="UPDATE  ".$tblpref."admin SET  designation = '$logo1' WHERE  nom='logo'";
mysql_query($sqllogo) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqllogo<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$lang1=isset($_POST['lang'])?$_POST['lang']:"";
if ($lang1!=$lang){
$sqllang="UPDATE  ".$tblpref."admin SET  designation = '$lang1' WHERE  nom='lang'";
mysql_query($sqllang) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqllang<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$site1=isset($_POST['site'])?$_POST['site']:"";
if ($site1!=$site){
$sqlsite="UPDATE  ".$tblpref."admin SET  designation = '$site1' WHERE  nom='site'";
mysql_query($sqlsite) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlsite<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$c_postal1=isset($_POST['c_postal'])?$_POST['c_postal']:"";
if ($c_postal1!=$c_postal){
$sqlc_postal="UPDATE  ".$tblpref."admin SET  designation = '$c_postal1' WHERE  nom='c_postal'";
mysql_query($sqlc_postal) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlc_postal<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$ville1=isset($_POST['ville'])?$_POST['ville']:"";
if ($ville1!=$ville){
$sqlville="UPDATE  ".$tblpref."admin SET  designation = '$ville1' WHERE  nom='ville'";
mysql_query($sqlville) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlville<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$indicatif_tel1=isset($_POST['indicatif_tel'])?$_POST['indicatif_tel']:"";
if ($indicatif_tel1!=$indicatif_tel){
$sqlindicatif_tel="UPDATE  ".$tblpref."admin SET  designation = '$indicatif_tel1' WHERE  nom='indicatif_tel'";
mysql_query($sqlindicatif_tel) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlindicatif_tel<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$smtp1=isset($_POST['smtp'])?$_POST['smtp']:"";
if ($smtp1!=$smtp){
$sqlsmtp="UPDATE  ".$tblpref."admin SET  designation = '$smtp1' WHERE  nom='smtp'";
mysql_query($sqlsmtp) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlsmtp<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$port1=isset($_POST['port'])?$_POST['port']:"";
if ($port1!=$port){
$sqlport="UPDATE  ".$tblpref."admin SET  designation = '$port1' WHERE  nom='port'";
mysql_query($sqlport) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlport<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$username_smtp1=isset($_POST['username_smtp'])?$_POST['username_smtp']:"";
if ($username_smtp1!=$username_smtp){
$sqlusername_smtp="UPDATE  ".$tblpref."admin SET  designation = '$username_smtp1' WHERE  nom='username_smtp'";
mysql_query($sqlusername_smtp) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlusername_smtp<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$password_smtp1=isset($_POST['password_smtp'])?$_POST['password_smtp']:"";
if ($password_smtp1!=$password_smtp){
$sqlpassword_smtp="UPDATE  ".$tblpref."admin SET  designation = '$password_smtp1' WHERE  nom='password_smtp'";
mysql_query($sqlpassword_smtp) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlpassword_smtp<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$impression1=isset($_POST['impression'])?$_POST['impression']:"";
if ($impression1!=$impression){
$sqlimpression="UPDATE  ".$tblpref."admin SET  designation = '$impression1' WHERE  nom='impression'";
mysql_query($sqlimpression) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlimpression<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$debut_saison1=isset($_POST['debut_saison'])?$_POST['debut_saison']:"";
if ($debut_saison1!=$debut_saison){
$sqldebut_saison="UPDATE  ".$tblpref."admin SET  designation = '$debut_saison1' WHERE  nom='debut_saison'";
mysql_query($sqldebut_saison) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqldebut_saison<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}
$fin_saison1=isset($_POST['fin_saison'])?$_POST['fin_saison']:"";
if ($fin_saison1!=$fin_saison){
$sqlfin_saison="UPDATE  ".$tblpref."admin SET  designation = '$fin_saison1' WHERE  nom='fin_saison'";
mysql_query($sqlfin_saison) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sqlfin_saison<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=admin.php><h3>RETOUR A L'administration de Net-Billetterie</h3></a></p>");
}

$message="<h2>$lang_new_config_ok</h2>";
?>
<table width="760" border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
		<?php
		if ($user_admin != y) { 
		echo "<h1>$lang_admin_droit";
		exit;
		}
		?>
		</td>
	</tr>
	<tr>
		<?php
		if($message !=''){
		echo"<tr><TD>$message</TD></tr>";
		}
		?>
	</tr>
</table>
<?php
include_once("include/bas.php");
 ?> 
